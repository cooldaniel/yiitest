<?php

/**
 * ContactForm class.
 * 
 * @package application.models
 */
class DiffArrayForm extends CFormModel
{
    public $array1;
    public $array2;
    public $diff;
    public $direct;
    public $choice;
    public $sort = ConvertHelper::SORT_NO;
    public $sortByAssoc;
    public $sortByKey;
    public $sortByRecurse;
    public $natsort;
    public $dataCount;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            array('array1', 'validateArray'),
            array('array2', 'validateArray'),
            array('diff', 'safe'),
            array('direct', 'validateDirect'),
            array('dataCount', 'safe'),
            array('choice', 'safe'),
            array('sort', 'safe'),
            array('sortByAssoc', 'safe'),
            array('sortByKey', 'safe'),
            array('sortByRecurse', 'safe'),
            array('natsort', 'safe'),
        );
    }

    public function validateArray($attribute, $params)
    {
        if (!is_array(@$this->evaluateExpression($this->$attribute))) {
            $this->addError($attribute, "The {$attribute} attribute is not an array string.");
        }
    }

    public function validateDirect($attribute, $params)
    {
        if (!in_array($this->$attribute, array_keys(DiffArraytHelper::$directList))) {
            $this->addError($attribute, "The {$attribute} attribute is invalid.");
        }
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'array1'=>Yii::t('code', 'Array1'),
            'array2'=>Yii::t('code', 'Array2'),
            'diff'=>Yii::t('code', 'Diff'),
            'direct'=>Yii::t('code', 'Direct'),
            'choice'=>Yii::t('code', 'Choice'),
            'sort'=>Yii::t('code', 'Sort'),
            'sortByAssoc'=>Yii::t('code', 'Sort By Assoc'),
            'sortByKey'=>Yii::t('code', 'Sort By Key'),
            'sortByRecurse'=>Yii::t('code', 'Sort By Recurse'),
            'natsort'=>Yii::t('code', 'Nat sort'),
        );
    }
}