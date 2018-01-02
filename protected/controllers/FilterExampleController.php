<?php

/**
 * 自定义过滤器类
 * Class PerformanceFilter
 */
class PerformanceFilter extends CFilter
{
	public $saySomething;

    /**
	 * 重载CFilter::prefilter().
	 */
	public function prefilter($filterChain)
	{
        echo '<div>执行自定义过滤类</div>';
		echo '<div>调用'.__CLASS__. '::' . __FUNCTION__ . '()</div>';
		echo '<div>通过CControler::filters()给'.__CLASS__.'()设置的属性：' . $this->saySomething . '</div>';
        echo '<br/>';

        // 这里返回true表示允许后续执行，返回false表示不往下执行，也就实现了防止访问的功能（权限过滤）
		return true;
	}

	/**
	 * 重载CFilter::postfilter().
	 */
	public function postfilter($filterChain)
	{
		echo '<div>调用'.__CLASS__. '::' . __FUNCTION__ . '()</div>';
        echo '<br/>';
	}
}

/**
 * 假设这是控制器的基类.
 * Class BaseExampleController
 */
class BaseExampleController extends Controller
{
    public function filters()
	{
		return array(

			// 自定义class filter
			array(
				'PerformanceFilter',
				'saySomething'=>'Hello Wrold!'
			),

			// 自定义内部方法过滤器
			'myInlineFilter',
		);
	}

	public function filterMyInlineFilter($filterChain)
	{
		echo '<div>执行自定义内部方法过滤器</div>';
        echo '<br/>';

		$filterChain->run();
	}
}

/**
 * 具体的业务功能类.
 * Class FilterExampleController
 */
class FilterExampleController extends BaseExampleController
{
    // 具体的业务页面
	public function actionIndex()
	{
		echo '<div>要进入的页面</div>';
        echo '<br/>';
	}
}