<?php
Yii::import('application.modules.admin.components.*');
Yii::import('application.moudles.admin.models.*');
class AdminModule extends CWebModule
{
	protected $assetsUrl;
	
	public function getAssetsUrl()
	{
		if($this->assetsUrl===null)
			$this->assetsUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('admin.assets'));
		return $this->assetsUrl;
	}
	
	public function setAssetsUrl($value)
	{
		$this->assetsUrl=$value;
	}
	
	public function init()
	{
		
	}
}
?>