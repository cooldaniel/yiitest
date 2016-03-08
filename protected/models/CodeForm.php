<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 * 
 * @package application.models
 */
class CodeForm extends CFormModel
{
	public $cardNumList;
	public $codeList;
	public $codeListWithCard;
	public $codeErrors;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('cardNumList', 'required'),
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
			'cardNumList'=>Yii::t('code', 'cardNumList'),
			'codeList'=>Yii::t('code', 'codeList'),
			'codeListWithCard'=>Yii::t('code', 'codeListWithCard'),
			'codeErrors'=>Yii::t('code', 'codeErrors'),
		);
	}
}