<?php

/**
 * @package application.models
 */
class Category extends CActiveRecord
{
	public $children;

	public function rules()
	{
		return array();
	}
	
	public function tableName()
	{
		return 'category';
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
