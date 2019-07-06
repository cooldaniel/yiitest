<?php
class ApiController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
	
	/* ----- 借助yii提供的ApiModel来生成帮助文档 ----- */
	
	/**
	 * 借助yii提供的ApiModel来生成帮助文档.
	 * 调用即生成.
	 */
	public function actionYii()
	{
		$this->layout='//layouts/api';
		
		echo "Beginning to make the api document at ".date('Y-m-d H:i:s')."\n<br/>";
		echo "Making the api document......\n<br/>";
		
		echo "Beginning to build the api classes.\n<br/>";
		echo "Building the api classes ......\n<br/>";
		$api=new AppApiModel;
		$sourceFilePaths=$this->getSourceFilePaths();
		$api->build($sourceFilePaths);
		echo "Having builded the api classes.\n<br/>";
		
		echo "Beginning to render the api classes view.\n<br/>";
		echo "Rendering the api classes view ......\n<br/>";
		$packages=$api->packages;
		$classes=$api->classes;
		
		D::pd(count($classes));
		
		// yii
		//$basePath=Yii::app()->basePath.'/documents/yii';
		//$view='class';
		
		// bugubugu
		//$basePath=Yii::app()->basePath.'/documents/77frame/';
		//$view='bg_class';
		
		// yii & bugubugu
		$basePath=Yii::app()->basePath.'/documents/yii&bugu/';
		$view='class';
		foreach($api->classes as $name=>$class)
		{
			$file=$basePath.$name.'.html';
			$content=$this->render($view,array('class'=>$class),true);
			$content=preg_replace('/\/htdocs\//','',$content);
			file_put_contents($file,$content);
		}
		echo "Having rendered the api classes view.\n<br/>";
		echo "Done at ".date('Y-m-d H:i:s');
	}
	
	public function getSourceFilePaths()
	{
		$data=$this->getSourceFilePathsOfBugu();
		//$data=$this->getSourceFilePathsOfYii();
		//$data=ray_merge($this->getSourceFilePathsOfBugu(),$this->getSourceFilePathsOfYii());
		return $this->parseDirectorySeparator($data);
	}
	
	public function getSourceFilePathsOfBugu()
	{
		// bugubugu
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
			//$basePath."/components/MemberIdentity.2011.03.30.php",
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
		/*$sourceFilePaths=array(
			//附加前后台共用的类
			$basePath."/components/ArModelBase.php",
			$basePath."/components/GoodsBase.php",
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
			$basePath."/modules/admin/models/UsersLevel.php"
		);*/
		
		return $sourceFilePaths;
	}
	
	public function getSourceFilePathsOfYii()
	{
		// yii
		$yiiPath='E:\php\77frame\includes\framework-yii-1.1.3.r2247';
		//D::pde(file_exists($yiiPath.'\yii.php'));
		//D::pde(file_get_contents($yiiPath.'/web/auth/CAccessControlFilter.php'));
		
		return array(
			//Yii::getPathOfAlias('application.components.Controller').'.php'
			$yiiPath.'\yii.php',
			$yiiPath.'\YiiBase.php',
			$yiiPath.'\base\interfaces.php',
			$yiiPath.'\base\CApplication.php',
			$yiiPath.'\base\CApplicationComponent.php',
			$yiiPath.'\base\CBehavior.php',
			$yiiPath.'\base\CComponent.php',
			$yiiPath.'\base\CErrorEvent.php',
			$yiiPath.'\base\CErrorHandler.php',
			$yiiPath.'\base\CException.php',
			$yiiPath.'\base\CExceptionEvent.php',
			$yiiPath.'\base\CHttpException.php',
			$yiiPath.'\base\CModel.php',
			$yiiPath.'\base\CModelBehavior.php',
			$yiiPath.'\base\CModelEvent.php',
			$yiiPath.'\base\CModule.php',
			$yiiPath.'\base\CSecurityManager.php',
			$yiiPath.'\base\CStatePersister.php',
			$yiiPath.'\caching\CApcCache.php',
			$yiiPath.'\caching\CCache.php',
			$yiiPath.'\caching\CDbCache.php',
			$yiiPath.'\caching\CDummyCache.php',
			$yiiPath.'\caching\CEAcceleratorCache.php',
			$yiiPath.'\caching\CFileCache.php',
			$yiiPath.'\caching\CMemCache.php',
			$yiiPath.'\caching\CWinCache.php',
			$yiiPath.'\caching\CXCache.php',
			$yiiPath.'\caching\CZendDataCache.php',
			$yiiPath.'\caching\dependencies\CCacheDependency.php',
			$yiiPath.'\caching\dependencies\CChainedCacheDependency.php',
			$yiiPath.'\caching\dependencies\CDbCacheDependency.php',
			$yiiPath.'\caching\dependencies\CDirectoryCacheDependency.php',
			$yiiPath.'\caching\dependencies\CExpressionDependency.php',
			$yiiPath.'\caching\dependencies\CFileCacheDependency.php',
			$yiiPath.'\caching\dependencies\CGlobalStateCacheDependency.php',
			$yiiPath.'\collections\CAttributeCollection.php',
			$yiiPath.'\collections\CConfiguration.php',
			$yiiPath.'\collections\CList.php',
			$yiiPath.'\collections\CListIterator.php',
			$yiiPath.'\collections\CMap.php',
			$yiiPath.'\collections\CMapIterator.php',
			$yiiPath.'\collections\CQueue.php',
			$yiiPath.'\collections\CQueueIterator.php',
			$yiiPath.'\collections\CStack.php',
			$yiiPath.'\collections\CStackIterator.php',
			$yiiPath.'\collections\CTypedList.php',
			$yiiPath.'\console\CConsoleApplication.php',
			$yiiPath.'\console\CConsoleCommand.php',
			$yiiPath.'\console\CConsoleCommandRunner.php',
			$yiiPath.'\console\CHelpCommand.php',
			$yiiPath.'\db\CDbCommand.php',
			$yiiPath.'\db\CDbConnection.php',
			$yiiPath.'\db\CDbDataReader.php',
			$yiiPath.'\db\CDbException.php',
			$yiiPath.'\db\CDbTransaction.php',
			$yiiPath.'\db\ar\CActiveFinder.php',
			$yiiPath.'\db\ar\CActiveRecord.php',
			$yiiPath.'\db\ar\CActiveRecordBehavior.php',
			$yiiPath.'\db\schema\CDbColumnSchema.php',
			$yiiPath.'\db\schema\CDbCommandBuilder.php',
			$yiiPath.'\db\schema\CDbCriteria.php',
			$yiiPath.'\db\schema\CDbExpression.php',
			$yiiPath.'\db\schema\CDbSchema.php',
			$yiiPath.'\db\schema\CDbTableSchema.php',
			$yiiPath.'\db\schema\mssql\CMssqlColumnSchema.php',
			$yiiPath.'\db\schema\mssql\CMssqlCommandBuilder.php',
			$yiiPath.'\db\schema\mssql\CMssqlPdoAdapter.php',
			$yiiPath.'\db\schema\mssql\CMssqlSchema.php',
			$yiiPath.'\db\schema\mssql\CMssqlTableSchema.php',
			$yiiPath.'\db\schema\mysql\CMysqlColumnSchema.php',
			$yiiPath.'\db\schema\mysql\CMysqlSchema.php',
			$yiiPath.'\db\schema\mysql\CMysqlTableSchema.php',
			$yiiPath.'\db\schema\oci\COciColumnSchema.php',
			$yiiPath.'\db\schema\oci\COciCommandBuilder.php',
			$yiiPath.'\db\schema\oci\COciSchema.php',
			$yiiPath.'\db\schema\oci\COciTableSchema.php',
			$yiiPath.'\db\schema\pgsql\CPgsqlColumnSchema.php',
			$yiiPath.'\db\schema\pgsql\CPgsqlSchema.php',
			$yiiPath.'\db\schema\pgsql\CPgsqlTableSchema.php',
			$yiiPath.'\db\schema\sqlite\CSqliteColumnSchema.php',
			$yiiPath.'\db\schema\sqlite\CSqliteCommandBuilder.php',
			$yiiPath.'\db\schema\sqlite\CSqliteSchema.php',
			$yiiPath.'\i18n\CChoiceFormat.php',
			$yiiPath.'\i18n\CDateFormatter.php',
			$yiiPath.'\i18n\CDbMessageSource.php',
			$yiiPath.'\i18n\CGettextMessageSource.php',
			$yiiPath.'\i18n\CLocale.php',
			$yiiPath.'\i18n\CMessageSource.php',
			$yiiPath.'\i18n\CNumberFormatter.php',
			$yiiPath.'\i18n\CPhpMessageSource.php',
			$yiiPath.'\i18n\gettext\CGettextFile.php',
			$yiiPath.'\i18n\gettext\CGettextMoFile.php',
			$yiiPath.'\i18n\gettext\CGettextPoFile.php',
			$yiiPath.'\logging\CDbLogRoute.php',
			$yiiPath.'\logging\CEmailLogRoute.php',
			$yiiPath.'\logging\CFileLogRoute.php',
			$yiiPath.'\logging\CLogFilter.php',
			$yiiPath.'\logging\CLogRoute.php',
			$yiiPath.'\logging\CLogRouter.php',
			$yiiPath.'\logging\CLogger.php',
			$yiiPath.'\logging\CProfileLogRoute.php',
			$yiiPath.'\logging\CWebLogRoute.php',
			$yiiPath.'\utils\CDateTimeParser.php',
			$yiiPath.'\utils\CFileHelper.php',
			$yiiPath.'\utils\CFormatter.php',
			$yiiPath.'\utils\CMarkdownParser.php',
			$yiiPath.'\utils\CPropertyValue.php',
			$yiiPath.'\utils\CTimestamp.php',
			$yiiPath.'\utils\CVarDumper.php',
			$yiiPath.'\validators\CBooleanValidator.php',
			$yiiPath.'\validators\CCaptchaValidator.php',
			$yiiPath.'\validators\CCompareValidator.php',
			$yiiPath.'\validators\CDefaultValueValidator.php',
			$yiiPath.'\validators\CEmailValidator.php',
			$yiiPath.'\validators\CExistValidator.php',
			$yiiPath.'\validators\CFileValidator.php',
			$yiiPath.'\validators\CFilterValidator.php',
			$yiiPath.'\validators\CInlineValidator.php',
			$yiiPath.'\validators\CNumberValidator.php',
			$yiiPath.'\validators\CRangeValidator.php',
			$yiiPath.'\validators\CRegularExpressionValidator.php',
			$yiiPath.'\validators\CRequiredValidator.php',
			$yiiPath.'\validators\CSafeValidator.php',
			$yiiPath.'\validators\CStringValidator.php',
			$yiiPath.'\validators\CTypeValidator.php',
			$yiiPath.'\validators\CUniqueValidator.php',
			$yiiPath.'\validators\CUnsafeValidator.php',
			$yiiPath.'\validators\CUrlValidator.php',
			$yiiPath.'\validators\CValidator.php',
			$yiiPath.'\web\CActiveDataProvider.php',
			$yiiPath.'\web\CArrayDataProvider.php',
			$yiiPath.'\web\CAssetManager.php',
			$yiiPath.'\web\CBaseController.php',
			$yiiPath.'\web\CCacheHttpSession.php',
			$yiiPath.'\web\CClientScript.php',
			$yiiPath.'\web\CController.php',
			$yiiPath.'\web\CDataProvider.php',
			$yiiPath.'\web\CDbHttpSession.php',
			$yiiPath.'\web\CExtController.php',
			$yiiPath.'\web\CFormModel.php',
			$yiiPath.'\web\CHttpCookie.php',
			$yiiPath.'\web\CHttpRequest.php',
			$yiiPath.'\web\CHttpSession.php',
			$yiiPath.'\web\CHttpSessionIterator.php',
			$yiiPath.'\web\COutputEvent.php',
			$yiiPath.'\web\CPagination.php',
			$yiiPath.'\web\CSort.php',
			$yiiPath.'\web\CSqlDataProvider.php',
			$yiiPath.'\web\CTheme.php',
			$yiiPath.'\web\CThemeManager.php',
			$yiiPath.'\web\CUploadedFile.php',
			$yiiPath.'\web\CUrlManager.php',
			$yiiPath.'\web\CWebApplication.php',
			$yiiPath.'\web\CWebModule.php',
			$yiiPath.'\web\CWidgetFactory.php',
			$yiiPath.'\web\actions\CAction.php',
			$yiiPath.'\web\actions\CInlineAction.php',
			$yiiPath.'\web\actions\CViewAction.php',
			$yiiPath.'\web\auth\CAccessControlFilter.php',
			$yiiPath.'\web\auth\CAuthAssignment.php',
			$yiiPath.'\web\auth\CAuthItem.php',
			$yiiPath.'\web\auth\CAuthManager.php',
			$yiiPath.'\web\auth\CBaseUserIdentity.php',
			$yiiPath.'\web\auth\CDbAuthManager.php',
			$yiiPath.'\web\auth\CPhpAuthManager.php',
			$yiiPath.'\web\auth\CUserIdentity.php',
			$yiiPath.'\web\auth\CWebUser.php',
			$yiiPath.'\web\filters\CFilter.php',
			$yiiPath.'\web\filters\CFilterChain.php',
			$yiiPath.'\web\filters\CInlineFilter.php',
			$yiiPath.'\web\form\CForm.php',
			$yiiPath.'\web\form\CFormButtonElement.php',
			$yiiPath.'\web\form\CFormElement.php',
			$yiiPath.'\web\form\CFormElementCollection.php',
			$yiiPath.'\web\form\CFormInputElement.php',
			$yiiPath.'\web\form\CFormStringElement.php',
			$yiiPath.'\web\helpers\CGoogleApi.php',
			$yiiPath.'\web\helpers\CHtml.php',
			$yiiPath.'\web\helpers\CJSON.php',
			$yiiPath.'\web\helpers\CJavaScript.php',
			$yiiPath.'\web\renderers\CPradoViewRenderer.php',
			$yiiPath.'\web\renderers\CViewRenderer.php',
			$yiiPath.'\web\services\CWebService.php',
			$yiiPath.'\web\services\CWebServiceAction.php',
			$yiiPath.'\web\services\CWsdlGenerator.php',
			$yiiPath.'\web\widgets\CActiveForm.php',
			$yiiPath.'\web\widgets\CAutoComplete.php',
			$yiiPath.'\web\widgets\CClipWidget.php',
			$yiiPath.'\web\widgets\CContentDecorator.php',
			$yiiPath.'\web\widgets\CFilterWidget.php',
			$yiiPath.'\web\widgets\CFlexWidget.php',
			$yiiPath.'\web\widgets\CHtmlPurifier.php',
			$yiiPath.'\web\widgets\CInputWidget.php',
			$yiiPath.'\web\widgets\CMarkdown.php',
			$yiiPath.'\web\widgets\CMaskedTextField.php',
			$yiiPath.'\web\widgets\CMultiFileUpload.php',
			$yiiPath.'\web\widgets\COutputCache.php',
			$yiiPath.'\web\widgets\COutputProcessor.php',
			$yiiPath.'\web\widgets\CStarRating.php',
			$yiiPath.'\web\widgets\CTabView.php',
			$yiiPath.'\web\widgets\CTextHighlighter.php',
			$yiiPath.'\web\widgets\CTreeView.php',
			$yiiPath.'\web\widgets\CWidget.php',
			$yiiPath.'\web\widgets\captcha\CCaptcha.php',
			$yiiPath.'\web\widgets\captcha\CCaptchaAction.php',
			$yiiPath.'\web\widgets\pagers\CBasePager.php',
			$yiiPath.'\web\widgets\pagers\CLinkPager.php',
			$yiiPath.'\web\widgets\pagers\CListPager.php',
			
			// gii
			$yiiPath.'\gii\CCodeFile.php',
			$yiiPath.'\gii\CCodeForm.php',
			$yiiPath.'\gii\CCodeGenerator.php',
			$yiiPath.'\gii\CCodeModel.php',
			$yiiPath.'\gii\GiiModule.php',
			
			// logging
			$yiiPath.'\logging\CDbLogRoute.php',
			$yiiPath.'\logging\CEmailLogRoute.php',
			$yiiPath.'\logging\CFileLogRoute.php',
			$yiiPath.'\logging\CLogFilter.php',
			$yiiPath.'\logging\CLogger.php',
			$yiiPath.'\logging\CLogRouter.php',
			$yiiPath.'\logging\CProfileLogRoute.php',
			$yiiPath.'\logging\CWebLogRoute.php',
			
			// test
			/*$yiiPath.'\test\CDbFixtureManager.php',
			$yiiPath.'\test\CDbTestCase.php',
			$yiiPath.'\test\CTestCase.php',
			$yiiPath.'\test\CWebTestCase.php',*/
			
			// console
			$yiiPath.'\console\CConsoleApplication.php',
			$yiiPath.'\console\CConsoleCommand.php',
			$yiiPath.'\console\CConsoleCommandRunner.php',
			$yiiPath.'\console\CHelpCommand.php',
			
			// zii
			$yiiPath.'\zii\behaviors\CTimestampBehavior.php',
			$yiiPath.'\zii\widgets\CBaseListView.php',
			$yiiPath.'\zii\widgets\CBreadcrumbs.php',
			$yiiPath.'\zii\widgets\CDetailView.php',
			$yiiPath.'\zii\widgets\CListView.php',
			$yiiPath.'\zii\widgets\CMenu.php',
			$yiiPath.'\zii\widgets\grid\CButtonColumn.php',
			$yiiPath.'\zii\widgets\grid\CCheckBoxColumn.php',
			$yiiPath.'\zii\widgets\grid\CDataColumn.php',
			$yiiPath.'\zii\widgets\grid\CGridColumn.php',
			$yiiPath.'\zii\widgets\grid\CGridView.php',
			$yiiPath.'\zii\widgets\grid\CLinkColumn.php',
			$yiiPath.'\zii\widgets\jui\CJuiAccordion.php',
			$yiiPath.'\zii\widgets\jui\CJuiAutoComplete.php',
			$yiiPath.'\zii\widgets\jui\CJuiButton.php',
			$yiiPath.'\zii\widgets\jui\CJuiDatePicker.php',
			$yiiPath.'\zii\widgets\jui\CJuiDialog.php',
			$yiiPath.'\zii\widgets\jui\CJuiDraggable.php',
			$yiiPath.'\zii\widgets\jui\CJuiDroppable.php',
			$yiiPath.'\zii\widgets\jui\CJuiInputWidget.php',
			$yiiPath.'\zii\widgets\jui\CJuiProgressBar.php',
			$yiiPath.'\zii\widgets\jui\CJuiResizable.php',
			$yiiPath.'\zii\widgets\jui\CJuiSelectable.php',
			$yiiPath.'\zii\widgets\jui\CJuiSlider.php',
			$yiiPath.'\zii\widgets\jui\CJuiSliderInput.php',
			$yiiPath.'\zii\widgets\jui\CJuiSortable.php',
			$yiiPath.'\zii\widgets\jui\CJuiTabs.php',
			$yiiPath.'\zii\widgets\jui\CJuiWidget.php',
		);
	}
	
	public function getParentClassesNames($parentClasses)
	{
		$parentClassesNames='';
		foreach($parentClasses as $parent)
		{
			$parentClassesNames.=" &raquo; <a href=\"{$parent}.html\">{$parent}</a>";
		}
		return $parentClassesNames;
	}
	
	public function getSubClassesNames($subClasses)
	{
		$subClassesNames='';
		foreach($subClasses as $subClass)
		{
			$subClassesNames.="<a href=\"{$subClass}.html\">{$subClass}</a>, ";
		}
		return rtrim($subClassesNames,', ');
	}
	
	public function parseDirectorySeparator($data)
	{
		foreach($data as $k=>$v)
			$data[$k]=str_replace('/',DIRECTORY_SEPARATOR,$v);
		return $data;
	}
	
	/* ----- 自己设计api文档生成工具 ----- */
	
	public function actionSelf()
	{
		$this->render('self');
	}
}
