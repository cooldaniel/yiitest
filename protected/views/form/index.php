
<div class="form">

<form action="" method="post" name="user" id="form">
	<div class="row">
    	<label>用户名：</label>
        <input type="text" name="username" autocomplete="off" placehoder="请输入用户名" />
        <div class="error"></div>
    </div>
    
    <div class="row">
    	<label>邮箱：</label>
        <input type="text" name="email" autocomplete="off" placehoder="请输入邮箱" />
        <div class="error"></div>
    </div>
    
    <div class="row buttons">
    	<input type="submit" value="提交" />
    </div>
</form>

</div>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.validate.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/additional-methods.js"></script>
<script>
$(function(){
	$('#form').validate({
        submitHandler: function (form) {

        },
        invalidHandler: function (form, validator) {
            console.log(form);
            console.log(validator);
        },
        rules: {
            'username': {
                required: true,
                length: [6, 12],
            },
            'email': {
                required: true,
            }
        },
        messages: {

        }//,
//        errorPlacement: function (e, n) {
//
//        }
    });
});
</script>