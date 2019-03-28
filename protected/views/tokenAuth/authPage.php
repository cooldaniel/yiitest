<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h3>TokenAuth - request code</h3>

<div>
    错误：
    <?php
    echo Yii::app()->getUser()->getFlash('validate_error');
    ?>
</div>

<form action="<?php echo Yii::app()->createAbsoluteUrl('tokenauth/auth'); ?>" method="post">

<div>
    <label for="auth">Auth?</label>
    <input type="radio" name="auth" value=1 />
    <input type="radio" name="auth" value=0 />
</div>

<div>
    <input type="submit" />
</div>

</form>
