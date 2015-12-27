<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 * @package application.components
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	public function init()
	{
		parent::init();
		$this->changeLanguage();
	}
	
	public function changeLanguage()
	{
		$language = Yii::app()->language;
		
		if (isset($_GET['LANGUAGE_ID']))
		{
			$language = $_GET['LANGUAGE_ID'];
		}
		elseif (($cookie = Yii::app()->request->cookies['LANGUAGE_ID']) !== null)
		{
			$language = $cookie->value;
		}
		
		if ($this->validateLanguageID($language))
		{
			Yii::app()->language = $language;
			Yii::app()->request->cookies['LANGUAGE_ID'] = new CHttpCookie('LANGUAGE_ID', $language);
		}
	}
	
	/**
	 * 验证语种ID是否正确.
	 * @param string $code 语种id.
	 * @return boolean 直接在系统预定义的语种ID列表中查找，找不到就算是非法的，返回false，反之返回true.
	 */
	public function validateLanguageID($id)
	{
		return in_array(trim($id), array('zh_cn', 'en_us', 'fr_fr'));
	}
	
	/**
	 * 基于给定的参数，创建并设置当前页面标题.
	 * @param array $params 组成页面标题的字符串参数数组，每一个元素表示一个组成字符串.
	 * 该方法将应用名称和这些参数依次用两边加空格的短横线顺序链接，格式如下：
	 * appname - user center - order list
	 * 从左向右依次表示从应用名称到具体页面位置.此外，该方法对参数字符串进行了I18N处理.
	 */
	public function createPageTitle($params=array())
	{
		foreach ($params as $index => $string)
		{
			$params[$index] = Yii::t('app', $string);
		}
		array_unshift($params, Yii::app()->name);
		$this->pageTitle = implode(' - ', $params);
	}
}