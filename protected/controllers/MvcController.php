<?php

/**
 * 将单个操作作为单元，多个则简单横向走多趟单个.
 * @package application.controllers
 */
class MvcController extends Controller
{
    public function validateSpecialInfo($id)
    {

    }

    /**
     * 单个.
     */
    public function actionDelete()
    {
        $id = Yii::app()->request->getParam('id');
        $this->changeStatus($id, SimulateModel::STATUS_DELETED, '删除', 'delete');
    }

    public function actionDisable()
    {
        $id = Yii::app()->request->getParam('id');
        $this->changeStatus($id, SimulateModel::STATUS_DISABLED, '冻结', 'disable');
    }

    public function actionEnable()
    {
        $id = Yii::app()->request->getParam('id');
        $this->changeStatus($id, SimulateModel::STATUS_NORMAL, '解冻', 'enable');
    }

    public function changeStatus($id, $status, $operate_title, $method)
    {
        $res = $this->changeStatusInternal($id, $status, $operate_title, $method);
        echo json_encode($res);
        exit;
    }

    public function changeStatusInternal($id, $status, $operate_title, $method)
    {
        // 错误代码1表示非数据验证类型（系统类型）操作失败，作为初始状态.
        $res = ['code'=>1, 'msg'=>'失败', 'data'=>[]];
        $errors = [];
        $model = new SimulateModel();

        // 数据验证
        // 不能解冻/冻结已删除记录
        $status_old = $model->getStatus($id);
        if ($status == SimulateModel::STATUS_NORMAL ||
            $status == SimulateModel::STATUS_DISABLED)
        {
            if ($status_old == SimulateModel::STATUS_DELETED)
            {
                $errors['status'] = '记录已删除';
            }
        }
        // 不能删除未冻结记录
        if ($status == SimulateModel::STATUS_DELETED)
        {
            if ($status_old == SimulateModel::STATUS_NORMAL)
            {
                $errors['status'] = '不能删除未冻结记录';
            }
        }

        // model外验证错误
        if ($this->validateSpecialInfo($id))
        {
            $errors['specialInfo'] = '该specialInfo字段不能为空';
        }

        // model内验证错误
        $model->validate();

        // 所有错误
        $errors = array_merge($errors, $model->getErrors());

        // 保存
        $hasErrors = !empty($errors);
        if (!$hasErrors && $model->$method($id))
        {
            // 错误代码0表示操作成功
            $res['code'] = 0;
            $res['msg'] = '成功';
            $res['data'][$id] = $model->toArray();
        }
        else
        {
            if ($hasErrors)
            {
                // 错误代码2表示两种情况：
                // 1. 请求参数错误.
                // 2. 数据有效性验证，以及数据可操作性验证失败.
                $res['code'] = 2;
                $res['msg'] = '失败，数据不合法';
                $res['data'][$id] = $errors;
            }
        }

        $res['msg'] = $operate_title . $res['msg'];
        return $res;
    }

    /**
     * 批量.
     */
    public function actionDeleteMulti()
    {
        $idList = Yii::app()->request->getParam('idList');
        $this->changeStatusMulti($idList, SimulateModel::STATUS_DELETED, '删除', 'delete');
    }

    public function actionDisableMulti()
    {
        $idList = Yii::app()->request->getParam('idList');
        $this->changeStatusMulti($idList, SimulateModel::STATUS_DISABLED, '冻结', 'disable');
    }

    public function actionEnableMulti()
    {
        $idList = Yii::app()->request->getParam('idList');
        $this->changeStatusMulti($idList, SimulateModel::STATUS_NORMAL, '解冻', 'enable');
    }

    public function changeStatusMulti($idList, $status, $operate_title, $method)
    {
        $res = ['code'=>1, 'msg'=>'失败', 'data'=>[]];
        $idList = explode(',', $idList);

        // 循环处理记录项并分开收集操作结果数据
        $multiTrue = true;
        $multiError = false;
        foreach ($idList as $id)
        {
            $itemRes = $this->changeStatusInternal($id, $status, $operate_title, $method);
            $res['data'][] = $itemRes['data'];

            // 存在错误
            if ($multiTrue && ($res['code'] != 0))
            {
                $multiTrue = false;
            }

            // 存在数据错误
            if (!$multiError && ($res['code'] == 2))
            {
                $multiError = true;
            }
        }

        // 设置统一的返回结果描述
        if ($multiTrue)
        {
            $res['code'] = 0;
            $res['msg'] = '成功';
        }
        elseif ($multiError)
        {
            $res['code'] = 2;
            $res['msg'] = '失败，数据不合法';
        }

        $res['msg'] = '批量' . $operate_title . $res['msg'];
        echo json_encode($res);
        exit;
    }

    /**
     * 配合批量操作{@link actionMulti}，模拟单个操作.
     */
    public function actionSingle()
    {
        // 错误代码1表示非数据验证类型（系统类型）操作失败，作为初始状态.
        $res = ['code'=>1, 'msg'=>'操作失败', 'data'=>[]];
        $id = Yii::app()->request->getParam('id');

        $errors = [];
        $model = new SimulateModel();

        // model外验证错误
        if ($this->validateSpecialInfo($id))
        {
            $errors['specialInfo'] = '该specialInfo字段不能为空';
        }

        // model内验证错误
        $model->validate();

        // 所有错误
        $errors = array_merge($errors, $model->getErrors());
        $hasErrors = !empty($errors);

        // 保存
        if (!$hasErrors && $model->delete($id))
        {
            // 错误代码0表示操作成功
            $res['code'] = 0;
            $res['msg'] = '操作成功';
            $res['data'][$id] = $model->toArray();
        }
        else
        {
            if ($hasErrors)
            {
                // 错误代码2表示数据验证类型操作失败
                $res['code'] = 2;
                $res['msg'] = '数据不合法';
                $res['data'][$id] = $errors;
            }
        }

        echo json_encode($res);
        exit;
    }

    /**
     * 模拟批量操作.单个操作请参考{@link actionSingle}
     */
    public function actionMulti()
    {
        $res = ['code'=>1, 'msg'=>'操作失败', 'data'=>[]];
        $idList = Yii::app()->request->getParam('idList');
        $idList = explode(',', $idList);

        // 循环处理记录项并分开收集操作结果数据
        $model = new SimulateModel();
        $multiTrue = true;
        $multiError = false;
        foreach ($idList as $id)
        {
            $errors = [];

            // model外验证错误
            if ($this->validateSpecialInfo($id))
            {
                $errors['specialInfo'] = '该specialInfo字段不能为空';
            }

            // model内验证错误
            $model->validate();

            // 所有错误
            $errors = array_merge($errors, $model->getErrors());
            $hasErrors = !empty($errors);

            // 保存
            if (!$hasErrors && $model->delete($id))
            {
                $res['data'][$id] = $model->toArray();
            }
            else
            {
                $multiTrue = false;
                if ($hasErrors)
                {
                    $multiError = true;
                    $res['data'][$id] = $errors;
                }
            }
        }

        // 设置统一的返回结果描述
        if ($multiTrue)
        {
            $res['code'] = 0;
            $res['msg'] = '操作成功';
        }
        elseif ($multiError)
        {
            $res['code'] = 2;
            $res['msg'] = '数据不合法';
        }

        echo json_encode($res);
        exit;
    }

    /**
     * API返回结果格式定义.
     */
    public function error()
    {
        // code: 操作结果错误码; msg: 操作结果错误描述; data: 附加数据.操作成功时可以包含正常数据，失败时包含错误数据.
        $res = array('code'=>0, 'msg'=>'操作成功', 'data'=>array());
        $res = array('code'=>1, 'msg'=>'操作失败', 'data'=>array(
            100=>array('name'=>'记录名长度不对', 'sex'=>'性别设置错误'),
            101=>array('name'=>'记录名长度不对', 'mobile'=>'手机格式错误'),
        ));
    }
}

/**
 * Class SimulateModel
 * 模拟数据模型.
 */
class SimulateModel
{
    const STATUS_NORMAL = 1;
    const STATUS_DISABLED = 2;
    const STATUS_DELETED = 3;

    private $_db;
    private $table;

    public function __construct()
    {
        $this->_db = new Db();
    }

    private $_errors = [];

    public function validate()
    {
        // set errors
    }

    public function getErrors()
    {
        return $this->_errors;
    }

    public function delete($id)
    {
        return $this->changeStatus($id, self::STATUS_DELETED);
    }

    public function disable($id)
    {
        return $this->changeStatus($id, self::STATUS_DELETED);
    }

    public function enable($id)
    {
        return $this->changeStatus($id, self::STATUS_DELETED);
    }

    private function changeStatus($id, $status)
    {
        try
        {
            $this->_db->begin();

            $sql = "UPDATE $this->table 
                    SET status = $status 
                    WHERE id = $id";
            $res = $this->query($sql);

            // 删除操作需要的额外处理
            if ($res && ($status == self::STATUS_DELETED))
            {
                $sql = "UPDATE $this->table 
                        SET username_backup = username, phone_backup = phone, username = '', phone = '' 
                        WHERE id = $id OR master_id = $id";
                $this->query($sql);
            }

            $this->_db->commit();
            return true;
        }
        catch (Exception $e)
        {
            $this->_db->rollback();
            return false;
        }
    }

    public function getStatus($id)
    {

    }

    public function toArray()
    {
        return [];
    }
}

class Db
{
    public function begin()
    {

    }

    public function commit()
    {

    }

    public function rollback()
    {

    }
}