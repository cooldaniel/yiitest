<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="en" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/api.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.js"></script>
<title>Yii Framework Class Reference</title>
</head>

<body>
<div id="apiPage">

<div id="apiHeader">
<a href="http://www.yiiframework.com">Yii Framework</a> v1.1.6 Class Reference
</div><!-- end of header -->

<div id="content">
<?php echo $content; ?>
</div><!-- end of content -->

<div id="apiFooter">
Copyright &copy; 2008-2011 by <a href="http://www.yiisoft.com">Yii Software LLC</a><br/>
All Rights Reserved.<br/>
</div><!-- end of footer -->

<script type="text/javascript">
/*<![CDATA[*/
//Yii -- 默认显示继承的属性/方法
/*$("a.toggle").toggle(function(){
	$(this).text($(this).text().replace(/Hide/,'Show'));
	$(this).parents(".summary").find(".inherited").hide();
},function(){
	$(this).text($(this).text().replace(/Show/,'Hide'));
	$(this).parents(".summary").find(".inherited").show();
});*/
$(".sourceCode a.show").toggle(function(){
	$(this).text($(this).text().replace(/show/,'hide'));
	$(this).parents(".sourceCode").find("div.code").show();
},function(){
	$(this).text($(this).text().replace(/hide/,'show'));
	$(this).parents(".sourceCode").find("div.code").hide();
});
$("a.sourceLink").click(function(){
	$(this).attr('target','_blank');
});

//Custom -- 默认隐藏继承的属性/方法
$("a.toggle").each(function(){
	$(this).parents(".summary").find(".inherited").hide();
	$(this).text($(this).text().replace(/Hide/,'Show'));
});
$("a.toggle").toggle(function(){
	$(this).text($(this).text().replace(/Show/,'Hide'));
	$(this).parents(".summary").find(".inherited").show();
},function(){
	$(this).text($(this).text().replace(/Hide/,'Show'));
	$(this).parents(".summary").find(".inherited").hide();
});
/*]]>*/
</script>

</div><!-- end of page -->
</body>
</html>