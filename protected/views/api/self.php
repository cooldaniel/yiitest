<div class="block">自定制api测试</div>

<?php
$api=new AppApiModel;

// 本地文档测试
/*$basePath=Yii::getPathOfAlias('application.components');
$conPath=Yii::getPathOfAlias('application.controllers');
$sourceFilePaths=array(
	//$basePath.'/CodeFormat.php',
	//$basePath.'/D.php',
	//$basePath.'/PathDumper.php',
	$basePath.'/Controller.php',
	$conPath.'/SiteController.php'
);*/


//77frame 文档测试
//重定义原因：在yiitest项目中定义并在运行这个请求时已经加载的类不能出现在$sourceFilePaths中.
//但是为什么Yii的却可以？不是它可以而是yii里面的类都是以C开头的，这里不会出现重定义.
$basePath='E:/php/77frame/protected';

//front
$sourceFilePaths=array(
	$basePath."/actions/member/InfoListAction.php",
	$basePath."/components/ArModelBase.php",
	$basePath."/components/BottomMenuCWidget.php",
	$basePath."/components/CH.php",
	$basePath."/components/CartsListCWidget.php",
	$basePath."/components/ConfFormCWidget.php",
	$basePath."/components/Controller.php",
	$basePath."/components/D.php",
	$basePath."/components/FileBase.php",
	$basePath."/components/FileHelper.php",
	$basePath."/components/GoodsBase.php",
	$basePath."/components/GoodsCommon.php",
	$basePath."/components/GoodsExchange.php",
	$basePath."/components/GoodsNormal.php",
	$basePath."/components/GoodsSubscribing.php",
	$basePath."/components/HotSaleCWidget.php",
	$basePath."/components/HttpRequest.php",
	$basePath."/components/MemberBase.php",
	$basePath."/components/MemberBaseModel.php",
	//$basePath."/components/MemberIdentity.2011.03.30.php", //与MemberIdentity.php重定义类
	$basePath.'/components/MemberBaseController.php',
	$basePath."/components/MemberIdentity.php",
	$basePath."/components/MemberMenuCWidget.php",
	$basePath."/components/MemberSubscriberApplyBase.php",
	$basePath."/components/PagesMenuCWidget.php",
	$basePath."/components/PriFunc.php",
	$basePath."/components/ProSetTopCWidget.php",
	$basePath."/components/RecentDTCWidget.php",
	$basePath."/components/SearchCWidget.php",
	$basePath."/components/Shopping.php",
	$basePath."/components/SpCalculator.php",
	$basePath."/components/TagCWidget.php",
	$basePath."/components/TreeCWidget.php",
	$basePath."/components/Uc.php", //包含了uc扩展的lib.php比较特殊,但还是可以处理的
	$basePath."/components/widgets/AlbumView.php",
	$basePath."/components/widgets/ColorView.php",
	$basePath."/components/widgets/SwitchCardView.php",
	$basePath."/components/widgets/treeview/BaseTreeView.php",
	$basePath."/components/widgets/treeview/NestingTreeView.php",
	$basePath."/components/widgets/treeview/PrefixTreeView.php",
	$basePath."/controllers/AddressController.php",
	$basePath."/controllers/AppController.php",
	$basePath."/controllers/CartController.php",
	$basePath."/controllers/ContractController.php",
	$basePath."/controllers/CustomController.php",
	$basePath."/controllers/DataController.php",
	$basePath."/controllers/FavoritesController.php",
	$basePath."/controllers/OrderController.php",
	$basePath."/controllers/PagesController.php",
	$basePath."/controllers/ProductController.php",
	$basePath."/controllers/ScoreController.php",
	$basePath."/controllers/SiteController.php",
	$basePath."/controllers/SubscriberController.php",
	$basePath."/controllers/UcController.php",
	$basePath."/helpers/CArray.php",
	$basePath."/models/AdItem.php",
	$basePath."/models/AdPosition.php",
	$basePath."/models/Applyfor.php",
	$basePath."/models/ContactForm.php",
	$basePath."/models/Custom.php",
	$basePath."/models/Favorites.php",
	$basePath."/models/MemberLoginForm.php",
	$basePath."/models/MemberOrderConsignee.php",
	$basePath."/models/MemberOrderGoods.php",
	$basePath."/models/OrderForm.php",
	$basePath."/models/OrderReview.php",
	$basePath."/models/SearchForm.php",
	$basePath."/models/Tag.php"
);

//back
//存在两个问题：前后台存在同名类，可通过分别渲染前后台api来解决这个问题，但是同时引发另一个问题，即前后台共用类必须被提供.
//为了解决这两个问题，将前后台分开渲染，并在后台中提供前后台共用的类.
$sourceFilePaths=array(
	//附加前后台共用的类
	$basePath."/components/ArModelBase.php",
	/*$basePath."/components/GoodsBase.php",
	$basePath."/components/GoodsCommon.php",
	$basePath."/components/GoodsExchange.php",
	$basePath."/components/GoodsNormal.php",
	$basePath."/components/GoodsSubscribing.php",
	$basePath."/components/MemberSubscriberApplyBase.php",
	$basePath."/components/MemberBase.php",
	
	//仅后台
	$basePath."/modules/admin/AdminModule.php",
	$basePath."/modules/admin/components/AdminBaseController.php",
	$basePath."/modules/admin/components/AdminUserIdentity.php",
	$basePath."/modules/admin/components/AuthBaseController.php",
	$basePath."/modules/admin/components/Breadcrumbs.php",
	$basePath."/modules/admin/components/GoodsBaseController.php",
	$basePath."/modules/admin/components/HU.php",
	$basePath."/modules/admin/components/MemberBaseController.php",
	$basePath."/modules/admin/components/MenuAndAuth.php",
	$basePath."/modules/admin/components/Size2Price.php",
	$basePath."/modules/admin/components/UsersBaseController.php",
	$basePath."/modules/admin/controllers/AdItemController.php",
	$basePath."/modules/admin/controllers/AdPositionController.php",
	$basePath."/modules/admin/controllers/AdminUsersController.php",
	$basePath."/modules/admin/controllers/AuthitemController.php",
	$basePath."/modules/admin/controllers/BackgroundAttributeController.php",
	$basePath."/modules/admin/controllers/BackgroundController.php",
	$basePath."/modules/admin/controllers/DefaultController.php",
	$basePath."/modules/admin/controllers/FrameAttributeController.php",
	$basePath."/modules/admin/controllers/FrameController.php",
	$basePath."/modules/admin/controllers/FrameMateriaController.php",
	$basePath."/modules/admin/controllers/FrameParaController.php",
	$basePath."/modules/admin/controllers/FurnitureAttributeController.php",
	$basePath."/modules/admin/controllers/FurnitureController.php",
	$basePath."/modules/admin/controllers/GoodsBrandController.php",
	$basePath."/modules/admin/controllers/GoodsClassifyController.php",
	$basePath."/modules/admin/controllers/GoodsController.php",
	$basePath."/modules/admin/controllers/GoodsTypeAttributeController.php",
	$basePath."/modules/admin/controllers/GoodsTypeController.php",
	$basePath."/modules/admin/controllers/HelpClassifyController.php",
	$basePath."/modules/admin/controllers/HelpController.php",
	$basePath."/modules/admin/controllers/LinkController.php",
	$basePath."/modules/admin/controllers/MemberController.php",
	$basePath."/modules/admin/controllers/MemberOrderController.php",
	$basePath."/modules/admin/controllers/MemberRankController.php",
	$basePath."/modules/admin/controllers/MemberSubscriberApplyController.php",
	$basePath."/modules/admin/controllers/QaController.php",
	$basePath."/modules/admin/controllers/ReferController.php",
	$basePath."/modules/admin/controllers/ScenceAttributeController.php",
	$basePath."/modules/admin/controllers/ScenceController.php",
	$basePath."/modules/admin/controllers/SubscribingController.php",
	$basePath."/modules/admin/controllers/TestController.php",
	$basePath."/modules/admin/controllers/UsersController.php",
	$basePath."/modules/admin/controllers/UsersLevelController.php",
	$basePath."/modules/admin/models/AdminLoginForm.php",
	$basePath."/modules/admin/models/AdminUsers.php",
	$basePath."/modules/admin/models/Authassignment.php",
	$basePath."/modules/admin/models/Authitem.php",
	$basePath."/modules/admin/models/Authitemchild.php",
	$basePath."/modules/admin/models/Background.php",
	$basePath."/modules/admin/models/BackgroundAttribute.php",
	$basePath."/modules/admin/models/Frame.php",
	$basePath."/modules/admin/models/FrameAttribute.php",
	$basePath."/modules/admin/models/FrameMateria.php",
	$basePath."/modules/admin/models/FramePara.php",
	$basePath."/modules/admin/models/Furniture.php",
	$basePath."/modules/admin/models/FurnitureAttribute.php",
	$basePath."/modules/admin/models/Goods.php",
	$basePath."/modules/admin/models/GoodsAttribute.php",
	$basePath."/modules/admin/models/GoodsBrand.php",
	$basePath."/modules/admin/models/GoodsClassify.php",
	$basePath."/modules/admin/models/GoodsSizePrice.php",
	$basePath."/modules/admin/models/GoodsType.php",
	$basePath."/modules/admin/models/GoodsTypeAttribute.php",
	$basePath."/modules/admin/models/Help.php",
	$basePath."/modules/admin/models/HelpClassify.php",
	$basePath."/modules/admin/models/Link.php",
	$basePath."/modules/admin/models/Member.php",
	$basePath."/modules/admin/models/MemberOrderInfo.php",
	$basePath."/modules/admin/models/MemberRank.php",
	$basePath."/modules/admin/models/MemberSubscriberApply.php",
	$basePath."/modules/admin/models/Qa.php",
	$basePath."/modules/admin/models/Refer.php",
	$basePath."/modules/admin/models/Scence.php",
	$basePath."/modules/admin/models/ScenceAttribute.php",
	$basePath."/modules/admin/models/Subscribing.php",
	$basePath."/modules/admin/models/Users.php",
	$basePath."/modules/admin/models/UsersLevel.php"*/
);





$sourceFilePaths=parseDirectorySeparator($sourceFilePaths);
$api->build($sourceFilePaths);

function parseDirectorySeparator($data)
{
	foreach($data as $k=>$v)
		$data[$k]=str_replace('/',DIRECTORY_SEPARATOR,$v);
	return $data;
}

echo CHtml::tag('h1',array(),'SourceFilePaths: '.count($sourceFilePaths));
echo CHtml::tag('h1',array(),'Classes: '.count($api->classes));
foreach($api->classes as $name=>$class)
{
	echo CHtml::openTag('div',array('class'=>'code-block'));
	echo CHtml::tag('h5',array(),$name);
	echo CHtml::tag('div',array());
	//echo $name;
	$this->widget('application.widgets.SelfApiView',array(
		'doc'=>$class
	));
	echo CHtml::closeTag('div');
	echo CHtml::closeTag('div');
}

Yii::app()->getClientScript()->registerCoreScript('jquery');
?>

<style type="text/css">
div.code-block{border:1px solid red; margin:2em 0;}
</style>

<script type="text/javascript">
$(document).ready(function(){
	/*$('div.code-block').each(function(){
		$(this).children('div').slideUp();
	});
	$('div.code-block').toggle(function(){
		$(this).children('div').slideDown();
	},function(){
		$(this).children('div').slideUp();
	});*/
});
</script>












