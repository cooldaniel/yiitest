<?php

class TokenAuthManager
{
    use Singleton;

    public function generateCode($authRequestParams)
    {
        $rand = rand();
        $client_id = $authRequestParams['client_id'];
        $redirect_uri = $authRequestParams['redirect_uri'];

        $code = md5($rand . $client_id . $redirect_uri);
        return $code;
    }

    public function saveCode($code, $authRequestParams)
    {
        $data = [
            'code'=>$code,
            'client_id'=>$authRequestParams['client_id'],
            'redirect_uri'=>$authRequestParams['redirect_uri'],
            'expires_in'=>time()+600,
        ];
        $model = new AuthCode();
        $model->setAttributes($data);
        return $model->save();
    }

    public function clearCode($client_id)
    {
        $model = new AuthCode();
        return $model->deleteAll('client_id="'.$client_id.'"');
    }

    public function findCodeRow($code)
    {
        $model = new AuthCode();
        return $model->find('code="'.$code.'"');
    }

    public function generateAccessToken()
    {
        return md5(rand() );
    }

    public function generateRefreshToken()
    {
        return md5(rand() );
    }

    public function saveToken($access_token, $refresh_token)
    {
        $data = [
            'access_token'=>$access_token,
            'token_type'=>'mac',
            'refresh_token'=>$refresh_token,
            'expires_in'=>3600, // 1小时失效
        ];
        $model = new AuthToken();
        $model->setAttributes($data);
        return $model->save();
    }

    public function clearToken($access_token)
    {
        $model = new AuthToken();
        return $model->deleteAll('access_token="'.$access_token.'"');
    }

    public function findTokenRow($access_token)
    {
        $model = new AuthToken();
        return $model->find('access_token="'.$access_token.'"');
    }

    public function findTokenRowByRefreshToken($refresh_token)
    {
        $model = new AuthToken();
        return $model->find('refresh_token="'.$refresh_token.'"');
    }

    public function validateCode($code)
    {
        if (!$code) {
            return "code为空，无效";
        }

        if (strlen($code) != 32) {
            return "code长度不是32位，无效";
        }

        if (!$this->findCodeRow($code)) {
            return "code记录不存在，无效";
        }

        return null;
    }

    public function validateToken($accessToken)
    {
        if (!$accessToken) {
            return "token为空，无效";
        }

        if (strlen($accessToken) != 32) {
            return "token长度不是32位，无效";
        }

        if (!$this->findTokenRow($accessToken)) {
            return "token记录不存在，无效";
        }

        return null;
    }
}