<?php

/**
 * ShowdocForm class.
 * 
 * @package application.models
 */
class ShowdocForm extends CFormModel
{
    public $request;
    public $response;
    public $requestDoc;
    public $responseDoc;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            array('request', 'validateRequest'),
            array('response', 'validateResponse'),
        );
    }

    public function validateRequest($attribute, $params)
    {
        if (trim($this->$attribute) == '') {
            $this->addError($attribute, "The {$attribute} attribute should not be empty.");
            return false;
        }

        return true;
    }

    public function validateResponse($attribute, $params)
    {
        if (trim($this->$attribute) == '') {
            $this->addError($attribute, "The {$attribute} attribute should not be empty.");
            return false;
        }

        return true;
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'request'=>Yii::t('code', 'Request'),
            'response'=>Yii::t('code', 'Response'),
        );
    }
}