<?php

/**
 * ContactForm class.
 * 
 * @package application.models
 */
class ConvertForm extends CFormModel
{
    public $json;
    public $array;
    public $likearray;
    public $postman;
    public $list;
    public $choice;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            array('json', 'validateJson'),
            array('array', 'validateArray'),
            array('likearray', 'validateLikeArray'),
            array('postman', 'validatePostman'),
            array('list', 'validateList'),
            array('choice', 'numerical'),
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

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'json'=>Yii::t('code', 'Json'),
            'array'=>Yii::t('code', 'Array'),
            'likearray'=>Yii::t('code', 'Like Array'),
            'postman'=>Yii::t('code', 'Postman'),
            'list'=>Yii::t('code', 'List'),
            'choice'=>Yii::t('code', 'Choice'),
        );
    }
}