<?php

/**
 * @package application.models
 */
class User extends CActiveRecord
{
	
	public function rules()
	{
		return array();
	}
	
	public function tableName()
	{
		return 'user';
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
