<?php

/**
 * JoinForm class.
 * 
 * @package application.models
 */
class JoinForm extends CFormModel
{
	public $list;
    public $output;
    public $totalCount;
    public $activeCount;
    public $emptyCount;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('list', 'required'),
			array('output, totalCount, activeCount, emptyCount', 'safe'),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'list'=>Yii::t('code', 'List'),
			'output'=>Yii::t('code', 'Output'),
			'totalCount'=>Yii::t('code', 'Total Count'),
			'activeCount'=>Yii::t('code', 'Active Count'),
			'emptyCount'=>Yii::t('code', 'Empty Count'),
		);
	}
}