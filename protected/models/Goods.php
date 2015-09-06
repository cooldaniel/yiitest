<?php

/**
 * 表 "goods" 的静态model类.
 *
 * 以下是表 'goods' 的可用列:
 * @property integer $gId
 * @property string $gName
 * @property string $gSn
 * @property string $gKeyWords
 * @property string $gDesc
 * @property string $gBrief
 * @property string $gColor
 * @property string $gSize
 * @property integer $gShape
 * @property string $gImgThumb
 * @property string $gImg
 * @property string $gImgOriginal
 * @property string $gPriceMarket
 * @property string $gPrice
 * @property double $gPriceMarketRatio
 * @property string $gCountingUnit
 * @property double $gPromotionDiscount
 * @property integer $gPromotionStart
 * @property integer $gPromotionEnd
 * @property integer $gIsPromotion
 * @property integer $gIsAvailable
 * @property integer $gIsNew
 * @property integer $gIsBest
 * @property integer $gIsHot
 * @property integer $gIsNFS
 * @property integer $gIsFreeShipping
 * @property integer $gTimeAdd
 * @property integer $gTimeLastUpdate
 * @property integer $gInventory
 * @property integer $gInventoryWarn
 * @property integer $gClicks
 * @property integer $gSaleroom
 * @property string $gUserEvaluation
 * @property integer $gGoodsBrand
 * @property integer $gGoodsClassify
 * @property integer $gGoodsType
 * @property string $gDesignRecommendation
 */
class Goods extends CActiveRecord
{
	/**
	 * 返回指定AR类的静态model
	 * @return Goods 静态的model类
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string 相关的数据表名字
	 */
	public function tableName()
	{
		return 'goods';
	}

	/**
	 * @return array model属性的验证规则
	 */
	public function rules()
	{
		return array(
			array('gName','required'),
			
			array('gShape, gPromotionStart, gPromotionEnd, gIsPromotion, gIsAvailable, gIsNew, gIsBest, gIsHot, gIsNFS, gIsFreeShipping, gTimeAdd, gTimeLastUpdate, gInventory, gInventoryWarn, gClicks, gSaleroom, gGoodsBrand, gGoodsClassify, gGoodsType', 'numerical', 'integerOnly'=>true),
			array('gPriceMarketRatio, gPromotionDiscount', 'numerical'),
			array('gName, gKeyWords, gBrief, gColor, gCountingUnit, gUserEvaluation', 'length', 'max'=>255),
			array('gSn', 'length', 'max'=>12),
			array('gSize, gPriceMarket, gPrice', 'length', 'max'=>100),
			array('gDesc, gImgThumb, gImg, gImgOriginal, gDesignRecommendation', 'safe'),
			
            //搜索用
			array('gId, gName, gSn, gKeyWords, gDesc, gBrief, gColor, gSize, gShape, gImgThumb, gImg, gImgOriginal, gPriceMarket, gPrice, gPriceMarketRatio, gCountingUnit, gPromotionDiscount, gPromotionStart, gPromotionEnd, gIsPromotion, gIsAvailable, gIsNew, gIsBest, gIsHot, gIsNFS, gIsFreeShipping, gTimeAdd, gTimeLastUpdate, gInventory, gInventoryWarn, gClicks, gSaleroom, gUserEvaluation, gGoodsBrand, gGoodsClassify, gGoodsType, gDesignRecommendation', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array 关联规则
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array 自定义的属性标签 (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'gId' => 'G',
			'gName' => 'G Name',
			'gSn' => 'G Sn',
			'gKeyWords' => 'G Key Words',
			'gDesc' => 'G Desc',
			'gBrief' => 'G Brief',
			'gColor' => 'G Color',
			'gSize' => 'G Size',
			'gShape' => 'G Shape',
			'gImgThumb' => 'G Img Thumb',
			'gImg' => 'G Img',
			'gImgOriginal' => 'G Img Original',
			'gPriceMarket' => 'G Price Market',
			'gPrice' => 'G Price',
			'gPriceMarketRatio' => 'G Price Market Ratio',
			'gCountingUnit' => 'G Counting Unit',
			'gPromotionDiscount' => 'G Promotion Discount',
			'gPromotionStart' => 'G Promotion Start',
			'gPromotionEnd' => 'G Promotion End',
			'gIsPromotion' => 'G Is Promotion',
			'gIsAvailable' => 'G Is Available',
			'gIsNew' => 'G Is New',
			'gIsBest' => 'G Is Best',
			'gIsHot' => 'G Is Hot',
			'gIsNFS' => 'G Is Nfs',
			'gIsFreeShipping' => 'G Is Free Shipping',
			'gTimeAdd' => 'G Time Add',
			'gTimeLastUpdate' => 'G Time Last Update',
			'gInventory' => 'G Inventory',
			'gInventoryWarn' => 'G Inventory Warn',
			'gClicks' => 'G Clicks',
			'gSaleroom' => 'G Saleroom',
			'gUserEvaluation' => 'G User Evaluation',
			'gGoodsBrand' => 'G Goods Brand',
			'gGoodsClassify' => 'G Goods Classify',
			'gGoodsType' => 'G Goods Type',
			'gDesignRecommendation' => 'G Design Recommendation',
		);
	}

	/**
	 * 基于当前搜索/过滤条件检索models列表
	 * @return CActiveDataProvider
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('gId',$this->gId);
		$criteria->compare('gName',$this->gName,true);
		$criteria->compare('gSn',$this->gSn,true);
		$criteria->compare('gKeyWords',$this->gKeyWords,true);
		$criteria->compare('gDesc',$this->gDesc,true);
		$criteria->compare('gBrief',$this->gBrief,true);
		$criteria->compare('gColor',$this->gColor,true);
		$criteria->compare('gSize',$this->gSize,true);
		$criteria->compare('gShape',$this->gShape);
		$criteria->compare('gImgThumb',$this->gImgThumb,true);
		$criteria->compare('gImg',$this->gImg,true);
		$criteria->compare('gImgOriginal',$this->gImgOriginal,true);
		$criteria->compare('gPriceMarket',$this->gPriceMarket,true);
		$criteria->compare('gPrice',$this->gPrice,true);
		$criteria->compare('gPriceMarketRatio',$this->gPriceMarketRatio);
		$criteria->compare('gCountingUnit',$this->gCountingUnit,true);
		$criteria->compare('gPromotionDiscount',$this->gPromotionDiscount);
		$criteria->compare('gPromotionStart',$this->gPromotionStart);
		$criteria->compare('gPromotionEnd',$this->gPromotionEnd);
		$criteria->compare('gIsPromotion',$this->gIsPromotion);
		$criteria->compare('gIsAvailable',$this->gIsAvailable);
		$criteria->compare('gIsNew',$this->gIsNew);
		$criteria->compare('gIsBest',$this->gIsBest);
		$criteria->compare('gIsHot',$this->gIsHot);
		$criteria->compare('gIsNFS',$this->gIsNFS);
		$criteria->compare('gIsFreeShipping',$this->gIsFreeShipping);
		$criteria->compare('gTimeAdd',$this->gTimeAdd);
		$criteria->compare('gTimeLastUpdate',$this->gTimeLastUpdate);
		$criteria->compare('gInventory',$this->gInventory);
		$criteria->compare('gInventoryWarn',$this->gInventoryWarn);
		$criteria->compare('gClicks',$this->gClicks);
		$criteria->compare('gSaleroom',$this->gSaleroom);
		$criteria->compare('gUserEvaluation',$this->gUserEvaluation,true);
		$criteria->compare('gGoodsBrand',$this->gGoodsBrand);
		$criteria->compare('gGoodsClassify',$this->gGoodsClassify);
		$criteria->compare('gGoodsType',$this->gGoodsType);
		$criteria->compare('gDesignRecommendation',$this->gDesignRecommendation,true);
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}