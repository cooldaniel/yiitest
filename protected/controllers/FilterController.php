<?php
/**
 * Yii filter 功能测试
 * @copyright lsx 2012/09/17
 * @package application.controllers
 */

class FilterController extends Controller
{
	public function filters()
	{
		return array(
			// 除了index这个action外，对其它的任意action都进行访问控制过滤
			'accessControl - index', // 对应的filter是 CController::filterAccessControl()
			
			// 
			'ajaxOnly + ajaxSearch', // 对应的filter是 CController::filterAjaxOnly()
			'postOnly + postGet', // 对应的filter是 CController::filterPostOnly()
			
			// 自定义class filter
			array(
				'PerformanceFilter',
				'hello'=>'~~~ said hi here ~~~'
			),
			
			// 自定义的inline filter
			'bar'
		);
	}
	
	/**
	 * 用于{@link filters()}的'accessControl' filter的访问控制规则.
	 */
	public function accessRules()
	{
		return array(
			array(
				'allow',
				'actions'=>array('edit'),
				'roles'=>array('admin', 'editor'),
				'message'=>'Access Denied.'
			),
			array('deny')
		);
	}
	
	/**
	 " inline filter 'bar'.
	 * inline filter 没有 pre-filter 和 post-filter 功能，因为CInlineFilter::filter()重载了CFilter::filter()，
	 * 后者提供了这两个功能.
	 */
	public function filterBar($filterChain)
	{
		echo 'inline filter "bar"<br/><br/>';
		$filterChain->run();
	}
	
	public function actionIndex()
	{
		// index action can be accessed by anyone.
		$this->render('index');
	}
	
	public function actionEdit()
	{
		// edit action only for admin and editor.
	}
	
	public function actionSearch()
	{
		// search action only for ajax request.
	}
	
	public function actionPostGet()
	{
		// some action only for post request.
	}
}