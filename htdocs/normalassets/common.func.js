// JavaScript Document

/**
 * 公用的js函数
 */
function fetch(options)
{
	var defaults=defaults={
		url:'',
		data:'',
		dataType:'text',
		//是否调试js脚本状态
		debug:false,
		//默认处理ajax响应时是否使用alert提错方式
		alert:false,
		//默认的处理ajax响应的方法,调试状态时打印显示结果,否则什么都不做
		process:function(response,settings){
			if(settings.debug){
				if(settings.alert)
					alert(response)
				else
					$('body').append(response);
			}
		}
	};
	
	var options=options||defaults;
	var settings=$.extend({},options);
	var url=settings.url;
	var type=settings.type;
	var data=settings.data;
	var dataType=settings.dataType;;
	if(url=='')
	{
		if(settings.debug)
			alert('url无效');
		else
			return false;
	}	
	jQuery.ajax({
		type:type,
		url:url,
		data:data,
		dataType:dataType,
		success:function(response){
			if(typeof(settings.process)==='string')
				eval(settings.process);
			else
				settings.process(response,settings);
		}
	});
}