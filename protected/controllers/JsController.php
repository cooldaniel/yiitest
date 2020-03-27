<?php
class JsController extends Controller
{
	public function actionIndex()
	{
		$this->render('js');
	}
	
	//jQuery slide
	public function actionJquerySlide()
	{
		$this->render('js_jquery_slide');
	}
	
	//jQuery ajax
	public function actionJqueryAjax()
	{
		$this->render('js_jquery_ajax');
	}

    /**
     * 尝试编写jQuery独立插件.
     *
     * 目的：
     * 编写独立widget需要的html结构、css、jQuery插件，方便代码复用以及避免代码之间干扰.
     *
     * 设计思路：
     * 1.在action里获取数据数组，然后在js_jquery_plugin视图里渲染.
     * 2.js_jquery_plugin视图使用布局/layouts/block_items，形成自动渲染item子视图的效果.
     * 3.在item视图里，使用ob_start()和ob_get_clean()获取生成的html、js、css代码，然后使用application.widgets.CodeFormatView
     * 渲染方便查看的fieldset方式，每个fieldset可以看做是tab标签页，标签页里面或者标签页之间创建的html结构id唯一，调用jQuery插件
     * 创建的实例也是唯一，从而形成独立widget效果.
     *
     * 注意：
     * application.widgets.CodeFormatView本身已经实现了相同的而效果，它采用yii的widget分装方式进行使用，
     * 这里采用手动构造组合的方式输出，目的是希望在非yii框架里也可以这样使用.
     */
	public function actionJqueryPlugin()
	{
		$this->render('js_jquery_plugin');
	}
	
	//module
	public function actionModule()
	{
		$this->render('js_module');
	}
	
	//ajax response test
	public function actionAjaxResponse()
	{
		if(isset($_REQUEST['id']))
			echo 'ajax response here with data: id='.$_REQUEST['id'];
		else
			echo 'ajax response here without data';
	}
	
	public function actionAjaxCommunicatePost()
	{
		echo $_POST['name'];
	}
	public function actionAjaxCommunicateGet()
	{
		echo $_GET['name'];
	}
	
	public function actionAjaxReload()
	{
		echo $this->render('fragements/list_1');
	}

	public function actionBlockAndSeries()
    {
        $this->render('js_block_and_series');
    }

    public function actionDd()
    {
        $this->render('dd');
    }
}
