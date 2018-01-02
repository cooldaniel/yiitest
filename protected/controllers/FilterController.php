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
            // 对应的filter：CController::filterAccessControl()
			'accessControl - index',
			
			// 对应的filter：CController::filterAjaxOnly()
			'ajaxOnly + ajaxSearch',

            // 对应的filter：CController::filterPostOnly()
			'postOnly + postGet',
			
			// 自定义class filter
			array(
				'PerformanceFilter',
				'saySomething'=>'Hello Wrold!'
			),
			
			// 自定义内部方法过滤器
			'myInlineFilter'
		);
	}
	
	/**
	 * 用于{@link filters()}的'accessControl' filter的访问控制规则.
	 */
	public function accessRules()
	{return [];
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
	 * inline filter 类型的过滤器没有 pre-filter 和 post-filter 功能，
     * 因为CInlineFilter::filter()重载了CFilter::filter()，具体可以看CInlineFilter的文档。
     *
	 * 如果需要这两个功能，可以继承{@see CFilter}定义过滤器类.
	 */
	public function filterMyInlineFilter($filterChain)
	{
		echo '<div>自定义内部方法过滤器</div>';

		$filterChain->run();
	}
	
	public function actionIndex()
	{
		echo '<div>总是可以访问首页</div>';
	}

	public function actionDeny()
    {
        echo '<div>不允许访问</div>';
    }
	
	public function actionOnlyPost()
	{
        echo '<div>只允许POST访问</div>';
	}
	
	public function actionOnlyAjax()
	{
        echo '<div>只允许AJAX访问</div>';
	}
}