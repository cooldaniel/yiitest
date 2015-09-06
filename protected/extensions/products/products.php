<?php
/**
 * bugubugu产品类建模.
 * @version 2011.09.17
 * @author lsx
 */

/* ----- 商品数据模型 ----- */

/**
 * 按产品特性而不是状态分类,因此不按普通商品、积分兑换、签约作品应用概念定义产品分类,而按具体特性(如微喷打印、手绘绘制画芯、相框等)分类.
 * 为了反映应用概念的区别,将设置标识区分普通商品、积分兑换、签约作品,以及普通商品的国画、名画、油画,签约作品的摄影作品、创意设计等,但这属于
 * 但这属于状态标识.
 */

/**
 * 产品接口类.
 */
interface IProduct
{
	/**
	 * 保存价格尺寸.
	 */
	public function saveSizeAndPrice();
	/**
	 * 保存图片.
	 */
	public function saveImage();
	/**
	 * 指定分类标识.
	 */
	public function specifyClassIdentifying();
}

/**
 * 产品抽象类,定义所有产品基本行为和属性.
 */
abstract class Product
{
	/**
	 * 保存价格尺寸.
	 */
	public function saveSizeAndPrice()
	{
		
	}
	/**
	 * 保存图片.
	 */
	public function saveImage()
	{
		
	}
	/**
	 * 指定分类标识.
	 */
	public function specifyClassIdentifying()
	{
		
	}
}

/**
 * 微喷打印类产品.
 * 打印的是图片,不是画,画的特性请参考{@see PaintingProduct}描述.
 * 站内提供：微喷打印类图片产品.
 * 签约会员提供：摄影作品、创意设计、手绘艺术作品的照片.这是要求上传的原图足够大的原因.它们上传的原图都用于微喷打印,只是图片来源类型不同而已.
 */
class PrintingProduct extends Product
{
	
}

/**
 * 手工绘制画芯类产品.
 * 此画芯类产品均通过委托画家手工绘制得来.
 * 站内提供：国画、油画、名画.
 * 签约会员提供：手绘艺术作品.
 */
class PaintingProduct extends Product
{
	
}

/**
 * 框画一体类产品.
 */
class FramePaintingProduct extends Product
{
	
}

/**
 * 框类产品.
 * 分框条和成品框两类.
 * 框条和框都是产品,但框中用到了框条,只是对框条进行了处理并构建成框.
 * 买的不是框条,而是买家指定框条种类,并指定目标框尺寸,最后交给商家制定并交付于买家.
 * 其中,买家可以在商城站点使用配框系统等应用模拟得到目标框的模型.
 */
class FramingProduct extends Product
{
	
}

/**
 * 框条类产品.
 */
class FrameStripProduct extends Product
{
	
}

/**
 * 成形框产品.
 * 框,是用某种框条做成的框,是一个成品,形状、材质多样.
 * 与框条不同,一个框指定了使用哪种框条,并且还包括框的造型、尺寸、重量以及其它必要的适合描述框的信息.
 */
class FrameProduct extends Product
{
	
}
?>