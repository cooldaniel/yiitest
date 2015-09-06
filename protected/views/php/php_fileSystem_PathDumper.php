<?php ob_start(); ?>

<?php
// Yii
$path=YII_PATH;
$pd=new PathDumper($path);
$pd->dirToIgnore=array('data','messages','views','assets','vendors','cli','components','controller','generators','models','views','js');
$pd->fileToKeep=array('php');

// yiitest
$path=Yii::getPathOfAlias('application');
$pd=new PathDumper($path);

// 77frame
$path='D:/php/building/77frame/protected';
$pd=new PathDumper($path);
$pd->dirToIgnore=array('.svn','views','themes','commands','data','config','extensions','messages','runtime','tests','classes','assets');
$pd->fileToKeep=array('php');

$pd->dump();
//$pd->files();
//$pd->filesEx();
$pd->filesArray();
?>

<?php
$this->widget('application.widgets.CodeFormatView',array(
	'file'=>__FILE__,
	'content'=>ob_get_clean(),
	//'defaultClose'=>false,
	'legend'=>'PathDumper'
));
?>







