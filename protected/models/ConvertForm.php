<?php

/**
 * ConvertForm class.
 * 
 * @package application.models
 */
class ConvertForm extends CFormModel
{
    public $input;
    public $json;
    public $jsonencode;
    public $array;
    public $likearray;
    public $postman;

    /**
     * 用冒号分隔键值对
     * @var string $list
     */
    public $list;

    /**
     * 用空格分隔键值对，可以用来从fiddler复制表单项，转换到list，用于postman表单.
     * @var string $listspace
     */
    public $listspace;

    public $choice;
    public $sort = ConvertHelper::SORT_NO;
    public $sortByAssoc;
    public $sortByKey;
    public $sortByRecurse;
    public $dataCount;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            array('input', 'safe'),
            array('json', 'validateJson'),
            array('jsonencode', 'safe'),
            array('array', 'validateArray'),
            array('likearray', 'validateLikeArray'),
            array('postman', 'validatePostman'),
            array('list', 'validateList'),
            array('listspace', 'validateListSpace'),
            array('choice', 'numerical'),
            array('sort', 'numerical'),
            array('sortByAssoc', 'numerical'),
            array('sortByKey', 'numerical'),
            array('sortByRecurse', 'numerical'),
            array('dataCount', 'numerical'),
        );
    }

    public function validateJson($attribute, $params)
    {
        if ($this->choice == ConvertHelper::CHOICE_JSON && !is_array(json_decode($this->$attribute)) && !is_object(json_decode($this->$attribute))) {
            $this->addError($attribute, "The {$attribute} attribute is not a json string.");
        }
    }

    public function validateArray($attribute, $params)
    {
        if ($this->choice == ConvertHelper::CHOICE_ARRAY && !is_array(@$this->evaluateExpression($this->$attribute))) {
            $this->addError($attribute, "The {$attribute} attribute is not an array string.");
        }
    }

    public function validateLikeArray($attribute, $params)
    {
//        if ($this->choice == ConvertHelper::CHOICE_LIKEARRAY && !is_array(@$this->evaluateExpression($this->$attribute))) {
//            $this->addError($attribute, "The {$attribute} attribute is not an array string.");
//        }
    }

    public function validatePostman($attribute, $params)
    {
//        if ($this->choice == ConvertHelper::CHOICE_POSTMAN && !is_array(@$this->evaluateExpression($this->attribute))) {
//            $this->addError($attribute, "The {$attribute} attribute is not an array string.");
//        }
    }

    public function validateList($attribute, $params)
    {

    }

    public function validateListSpace($attribute, $params)
    {

    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'json'=>Yii::t('code', 'Json'),
            'jsonencode'=>Yii::t('code', 'Json Encode'),
            'array'=>Yii::t('code', 'Array'),
            'likearray'=>Yii::t('code', 'Like Array'),
            'postman'=>Yii::t('code', 'Postman'),
            'list'=>Yii::t('code', 'List'),
            'listspace'=>Yii::t('code', 'List Space'),
            'choice'=>Yii::t('code', 'Choice'),
            'sort'=>Yii::t('code', 'Sort'),
            'sortByAssoc'=>Yii::t('code', 'Sort By Assoc'),
            'sortByKey'=>Yii::t('code', 'Sort By Key'),
            'sortByRecurse'=>Yii::t('code', 'Sort By Recurse'),
        );
    }
}