<?php

/**
 * @package application.models.mongodb
 */
class YibaiAccountTaskQueue extends EMongoDocument
{
    public $id;
    public $account_id;
    public $type;
    public $platform_code;
    public $create_time;

    // This has to be defined in every model, this is same as with standard Yii ActiveRecord
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    // This method is required!
    public function getCollectionName()
    {
        return 'yibai_account_task_queue';
    }

    public function rules()
    {
        return array(
            array('id, account_id, type, platform_code, create_time', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'account_id' => 'Account id',
            'type' => 'Type',
            'platform_code' => 'Platform code',
            'create_time' => 'Create time',
        );
    }
}