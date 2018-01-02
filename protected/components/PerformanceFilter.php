<?php
/**
 * 性能过滤器.
 * @copyright lsx 2012/09/04
 * @package application.components
 */

class PerformanceFilter extends CFilter
{
	public $saySomething;

    public function __construct()
    {
        echo '<div>进入自定义过滤类</div>';
    }

    /**
	 * 重载CFilter::prefilter().
	 */
	public function prefilter($filterChain)
	{
		echo '<div>调用'.__CLASS__. '::' . __FUNCTION__ . '</div>';
		echo '<div>通过CControler::filters()给'.__CLASS__.'设置的属性：' . $this->saySomething . '</div>';


        // 这里可以获取控制器和action的名字判断是否允许访问
        $controllerName = Yii::app()->controller->id;
        $actionName = Yii::app()->controller->action->id;
        \D::pd($controllerName, $actionName);

        // 这里返回true表示允许后续执行，返回false表示不往下执行，也就实现了防止访问的功能（权限过滤）
		return true;
	}
	
	/**
	 * 重载CFilter::postfilter().
	 */
	public function postfilter($filterChain)
	{
		echo '<div>调用'.__CLASS__. '::' . __FUNCTION__ . '</div>';
	}
}

/*
CApplication::run()
	CWebApplication::processRequest()
		CWebApplication::runController()
			CWebApplication::createController()
				CWebApplication::parseActionParams()
				Yii::createComponent()
					if(!class_exists($class)) Yii::import()
			CController::init()
			CController::run()
				CController::createAction()
					new CInlineAction / CController::createActionFromMap(CController::actions())
				
				CWebApplication::beforeControllerAction() // CWebModule封装了该方法法
				
				CWebApplication::runActionWithFilters()
					CFilterChain::run()
						
						CController::filterAbc()
							CFilterChain::run()
							
								CController::filterDef()
									CFilterChain::run()
										
										FooFilter::prefilter()
										FooFilter::filter()
											CFilterChain::run()
												
												CController::filterXyz()
													CFilterChain::run()
														
														BarFilter::prefilter()
														BarFilter::filter()
															CFilterChain::run()
																
																CController::runAction()
																	CController::beforeAction()
																	CAction::runwithParams()
																	CController::afterAction()
																
														Barfilter::postfilter()	
																												
										FooFilter::postfilter()
					
				CWebApplication::afterControllerAction() // CWebModule封装了该方法

说明：
1.依次执行一系列过滤器时，如果某一个过滤器的filter()没有调用CFilterChain::run()，那么后续的过滤器以及CController::runAction()都不会被执行，而已经执行的过滤器的postfilter()方法会被逆序执行，因为依次执行过滤器采用的是函数嵌套调用的方式.
2.CAction封装了CController::method().
3.CWebApplication和CWebModule都有beforeControllerAction()和afterControllerAction().
4.从inline action和class action的实现可以看到，Yii应用程序对象处理用户请求的过程是，将用户的请求定位到某个controller-action，这样，用户具体得到的响应内容，可以在action中具体构建，同时，在定位controller-action的过程中，可以加入一系列的预处理和后处理.
*/