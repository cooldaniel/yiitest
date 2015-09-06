<?php
/**
 * 用于在HTML页面中友好地显示代码内容
 */
 
 /*PHP 关键词 and  or  xor  __FILE__  exception (PHP 5)  
__LINE__  array()  as  break  case  
class  const  continue  declare  default  
die()  do  echo()  else  elseif  
empty()  enddeclare  endfor  endforeach  endif  
endswitch  endwhile  eval()  exit()  extends  
for  foreach  function  global  if  
include()  include_once()  isset()  list()  new  
print()  require()  require_once()  return()  static  
switch  unset()  use  var  while  
__FUNCTION__  __CLASS__  __METHOD__  final (PHP 5)  php_user_filter (PHP 5)  
interface (PHP 5)  implements (PHP 5)  extends  public (PHP 5)  private (PHP 5)  
protected (PHP 5)  abstract (PHP 5)  clone (PHP 5)  try (PHP 5)  catch (PHP 5)  
throw (PHP 5)  cfunction (PHP 4 only)  this (PHP 5 only)  
*/
class CodeFormat
{
	public static function encode($text)
	{
		
	}
	
	//元素id前缀,s表示shell,c表示content
	const PREFIX='sc';
	public static $count=0;
	public static $shellClass='shell';
	public static $contentClass='c';
	public static function render($file,$rel='',$htmlOptions=array())
	{
		$c=file_get_contents($file);
		$c=preg_replace('/\<\?php\s*ob_start\(\);\s*\?\>/','',$c);
		$c=preg_replace('/\<\?php\s*\$rel=ob_get_clean\(\);\s*CodeFormat::render\(__FILE__,\$rel\);\s*\?\>/','',$c);
		
		if(isset($htmlOptions['shell']))
			$shellClass=$htmlOptions['shell'];
		else
			$shellClass=self::$shellClass;
		if(isset($htmlOptions['contentClass']))
			$contentClass=$htmlOptions['contentClass'];
		else
			$contentClass=self::$contentClass;
		if(isset($htmlOptions['lengend']))
			$lengend=$htmlOptions['lengend'];
		else
			$lengend='template';
		$id=self::PREFIX.self::$count++;
		echo '<fieldset title="'.$lengend.'" class="'.$shellClass.'"><legend>'.$lengend.
		'</legend><div class="'.$contentClass.'" id="'.$id.'"><div class="code">code:</div><pre>&lt;?php'.
		htmlspecialchars($c).'?&gt;</pre><div class="result">result:</div>'.
		$rel.'</div></fieldset>';
		
		$js="
//隐藏
var c=jQuery('.c');
c.slideUp();
c.addClass('down');
//点击事件
jQuery('.shell').live('click',function()
{
	var c=jQuery('#$id');
	if(c.hasClass('down'))
	{
		c.slideDown();
		c.removeClass('down');
	}
	else
	{
		c.slideUp();
		c.addClass('down');
	}
});
";
		$cs=Yii::app()->clientScript;
		if(!$cs->isScriptRegistered('code'));
			$cs->registerScript('code',$js);
	}
}
?>