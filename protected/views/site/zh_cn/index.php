<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1><?php echo Yii::t('app', 'Welcome to'); ?> <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<p>Daniel's shop是一个电子商务站点.</p>

<?php

D::pd(Yii::t('app', 'name'));
D::pd(Yii::t('goods', 'goodsName'));
D::pd(Yii::app()->messages);

D::pd(Yii::app()->language);

D::pd(Yii::getLogger()->getLogs());











?>
