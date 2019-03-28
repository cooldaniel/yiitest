<?php
class TokenAuthController extends Controller
{
    private $allowed_response_type = ['code'];

    public function init()
    {
        parent::init();
    }

    public function actionTestcurl()
    {
        \D::noclean();
        \D::log($_GET, $_POST);
        echo 'done';
    }

    // 第三方跳转到这里通过页面让用户进行授权
    // 第三方平台对当前已登录用户的授权请求页面
    // 第三方平台发起请求时，当前用户必须是已登录状态，此时可以使用session
	public function actionAuthPage()
    {
        $this->loginRequired();

        // 检测请求参数
        if (!$this->checkAuthRequestParams($_GET)) {

            $this->redirect($this->createUrl('tokenauth/invalidrequestparams'));
        }

        // 保存合法请求参数到session
        // 从第三方平台请求过来的时候才需要保存，如果是表单验证失败则不需要保存
        if (!isset($_SESSION['invalid_auth_page_form'])) {

            $_SESSION['auth_request_data'] = $_GET;
        }

        // 显示授权页面给当前登录用户操作
        $this->render('authPage');
    }

    // 同意授权，返回code
    public function actionAuth()
    {
        $this->loginRequired();

        // 获取授权请求数据
        $authRequestParams = empty($_SESSION['auth_request_data']) ? null : $_SESSION['auth_request_data'];
        if (!$authRequestParams) {

            Yii::log('没有session项：必须是授权请求页面跳转提交的表单');

            // 必须是授权请求页面跳转提交的表单
            exit('没有session项：必须是授权请求页面跳转提交的表单');
        }

        // 判断提交的表单是否有效
        if (!isset($_POST['auth'])) {

            // 表单无效处理
            Yii::app()->getUser()->setFlash('validate_error', '请选择auth');

            // 标识是表单验证无效跳转过去的，此时不需要保存$_GET数据，避免覆盖
            $_SESSION['invalid_auth_page_form'] = 1;

            $this->redirect($this->createUrl('tokenauth/authpage'));
        }

        // 根据授权选择结果进行处理
        $auth = Yii::app()->request->getPost('auth');
        if (!$auth) {

            // 不授权，告诉第三方当前用户拒绝授权
            $data = [
                'code'=>ERR_OPERATE_AUTH_CODE_NO,
                'msg'=>$GLOBALS['ERR_MESSAGE'][ERR_OPERATE_AUTH_CODE_NO],
                'data'=>'',
            ];

        } else {

            $transaction = Yii::app()->db->beginTransaction();
            try
            {
                // 同意授权，返回code和state
                $code = TokenAuthManager::getInstance()->generateCode($authRequestParams);

                // 删除之前请求的code记录
                TokenAuthManager::getInstance()->clearCode($authRequestParams['client_id']);

                // 保存code记录
                TokenAuthManager::getInstance()->saveCode($code, $authRequestParams);

                $failed = false;

                $transaction->commit();

            } catch (Exception $e) {

                $failed = true;

                Yii::log('生成code记录错误：'.$e->getMessage());

                $transaction->rollback();
            }

            if ($failed) {

                // 系统错误，无法生成或者获取code数据
                $data = [
                    'code'=>50000,
                    'msg'=>'系统错误，无法生成或者获取code数据',
                    'data'=>'',
                ];

            } else {

                // 这里可以不用删除actionAuth()设置的session数据$_SESSION['invalid_auth_page_form']
                // 因为每次请求actionAuth()它都会被重置
                //unset($_SESSION['invalid_auth_page_form']);

                // 响应第三方平台
                $state = $authRequestParams['state'];

                $data = [
                    'code'=>ERR_OPERATE_SUCCESS,
                    'msg'=>$GLOBALS['ERR_MESSAGE'][ERR_OPERATE_AUTH_CODE_YES],
                    'data'=>[
                        'code'=>$code,
                        'state'=>$state,
                    ],
                ];
            }
        }

        unset($_SESSION['auth_request_data']);

        $redirect_uri = $authRequestParams['redirect_uri'];
        $dest_uri = $redirect_uri . '?' . http_build_query($data);
        $this->redirect($dest_uri);
    }

    // 第三方平台拿着code来获取access_token
    public function actionToken()
    {
        $code = Yii::app()->request->getParam('code');

        // 验证code
        $error = TokenAuthManager::getInstance()->validateCode($code);
        if ($error !== null) {

            $data = [
                'code'=>50000,
                'msg'=>$error,
                'data'=>'',
            ];

            echo UnicodeJson::json_encode($data);
            exit;
        }

        // 根据请求参数生成access_token和refresh_token保存到数据库里
        $transaction = Yii::app()->db->beginTransaction();
        try
        {
            $access_token = TokenAuthManager::getInstance()->generateAccessToken();
            $refresh_token = TokenAuthManager::getInstance()->generateRefreshToken();

            TokenAuthManager::getInstance()->saveToken($access_token, $refresh_token);

            $token_row = TokenAuthManager::getInstance()->findTokenRow($access_token);

            $failed = false;

            //throw new Exception('test');

            $transaction->commit();

        } catch (Exception $e) {

            $failed = true;

            Yii::log('生成token记录错误：'.$e->getMessage());

            $transaction->rollback();
        }

        if ($failed) {

            // 系统错误，无法生成或者获取token数据
            $data = [
                'code'=>50000,
                'msg'=>'系统错误，无法生成或者获取token数据',
                'data'=>'',
            ];

        } else {

            $data = [
                'code'=>200,
                'msg'=>'用户授权成功',
                'data'=>$token_row->attributes,
            ];
        }

        echo UnicodeJson::json_encode($data);
    }

    // 第三方平台拿着refresh_token来主动刷新access_token
    public function actionRefreshToken()
    {
        $refreshToken = Yii::app()->request->getParam('refresh_token');

        // 缺少字段
        if ($refreshToken === null) {

            $data = [
                'code'=>50000,
                'msg'=>'缺少refresh_token字段',
                'data'=>'',
            ];

            echo UnicodeJson::json_encode($data);
            exit;
        }

        // 找不到记录
        $token_row = TokenAuthManager::getInstance()->findTokenRowByRefreshToken($refreshToken);
        if (!$token_row) {

            $data = [
                'code'=>50000,
                'msg'=>'refresh_token无效',
                'data'=>'',
            ];

            echo UnicodeJson::json_encode($data);
            exit;
        }

        $transaction = Yii::app()->db->beginTransaction();
        try
        {
            TokenAuthManager::getInstance()->clearToken($token_row->access_token);

            $access_token = TokenAuthManager::getInstance()->generateAccessToken();
            $refresh_token = TokenAuthManager::getInstance()->generateRefreshToken();

            TokenAuthManager::getInstance()->saveToken($access_token, $refresh_token);

            $token_row = TokenAuthManager::getInstance()->findTokenRow($access_token);

            $failed = false;

            $transaction->commit();

        } catch (\Exception $e) {

            $failed = true;

            Yii::log('刷新token错误，生成token记录错误：'.$e->getMessage());

            $transaction->rollback();
        }

        if ($failed) {

            // 系统错误，无法生成或者获取token数据
            $data = [
                'code'=>50000,
                'msg'=>'系统错误，无法生成或者获取token数据',
                'data'=>'',
            ];

        } else {

            $data = [
                'code'=>200,
                'msg'=>'用户授权成功',
                'data'=>$token_row->attributes,
            ];
        }

        echo UnicodeJson::json_encode($data);
    }

    // 第三方平台拿着access_token请求资源服务器的时候，资源服务器拿着这个access_token来验证是否有效
    // 注意：这里不考虑资源服务器和认证服务器的通信认证问题，只考虑第三方平台和认证服务器的通信认证问题
    // 所以，该接口仅供内部资源服务器验证access_token是否有效时使用
    public function actionCheckToken()
    {
        $accessToken = Yii::app()->request->getParam('access_token');

        $error = TokenAuthManager::getInstance()->validateToken($accessToken);

        if ($error !== null) {

            $data = [
                'code'=>5000,
                'msg'=>'access_token无效',
                'data'=>'',
            ];

        } else {

            $data = [
                'code'=>200,
                'msg'=>'access_token有效',
                'data'=>'',
            ];
        }

        echo UnicodeJson::json_encode($data);
    }

    // 无效请求参数
    public function actionInvalidRequestParams()
    {
        $isAjax = false;
        if ($isAjax) {
            $data = [
                'code'=>5000,
                'msg'=>'无效的请求参数',
                'data'=>'',
            ];
            echo UnicodeJson::json_encode($data);
        } else {
            $this->render('invalidRequestParamsPage');
        }
    }

    public function checkAuthRequestParams($params)
    {
        return true;
    }

    public function checkAllowedResponseType($code)
    {
        return isset($this->allowed_response_type[$code]) ? true : false;
    }

    public function loginRequired($lastUri=null)
    {
        if (Yii::app()->getUser()->getIsGuest()) {
            $this->redirect($this->createUrl('site/login'), ['last_uri'=>$lastUri]);
        }
    }

    public function checkIsLogined()
    {
        return true;
    }

}
