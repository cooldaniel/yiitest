<?php

class FormHelper
{
    public static function createFrom($config)
    {
        echo $style = <<<EOD
<style>
.section {
    margin:100px;
}

.section fieldset {
    border:0px;
}

.section fieldset legend {
    font-weight:bold;
}
</style>
EOD;



        $config=array(
            'title'=>'用户登录',
            'description'=>'请输出信息',
            'attributes'=>array( //<form>标签的HTML属性
                'style'=>'
                    border:0px solid red; 
                    margin:1em; padding:1em; 
                    background-color:#FFFFFF;
                '
            ),
            'elements'=>array( //元素类型见 {@see CFormInputElement::coreTypes}
                'uName'=>array(
                    'visible'=>true,
                    'type'=>'text',
                    'class'=>'User_username_class',
                    'id'=>'User_username_id',
                    'name'=>'User_username_name', //这里定义的name属性不会被应用
                    'value'=>'默认值'
                )
            ),
            'buttons'=>array( //按钮类型见 {@see CFormButtonElement::coreTypes}
                'submit'=>array('type'=>'submit','visible'=>true,'value'=>'submit'),
                'reset'=>array('type'=>'reset','visible'=>true,'value'=>'reset')
            ),
            'activeForm'=>array( //真正的表达对象
                'id'=>'user_form',
                'enableAjaxValidation'=>true,
                'method'=>'get',
                'action'=>Yii::app()->createUrl('user/index'),
                'clientOptions'=>array(

                ),
                'htmlOptions'=>array(
                    //
                )
            )
        );
        $model = new Country();
        $form=new CForm($config,$model);

        echo '<div class="section">';
        echo $form->render();
        echo '</div>';
    }
}