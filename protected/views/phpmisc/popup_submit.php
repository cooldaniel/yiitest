<?php
//$this->renderPartial('/layouts/block_single',array('title'=>'Form security test','back'=>$this->createUrl('phpMisc/index')));
?>

<?php
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.js');
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl.'/js/wbox/wbox.min.js');
Yii::app()->getClientScript()->registerCssFile(Yii::app()->baseUrl.'/js/wbox/files/wbox.css');
?>

<script type="text/javascript">
jQuery(document).ready(function($){
	var url='<?php echo $this->createUrl('phpMisc/form'); ?>';
	var data='';
	
	function getIframeDocument(element) {
		return  element.contentDocument || element.contentWindow.document;
	};
	
	function getIframeWindow(element){		
		return  element.contentWindow;
		//return  element.contentWindow || element.contentDocument.parentWindow;
	}
	
	var callBack=function(box){
		$('#boxFrame').each(function(){
			var e=getIframeDocument(this);
			$('input:submit',e).live('click',function(){
				
			});
		});
	}
	
	$("#setPos").wBox({opacity:0.2,yPos:1,callBack:callBack,title:'Popup submit',show:true,html:'<iframe id="boxFrame" src="'+url+'"></iframe>'});
});
</script>