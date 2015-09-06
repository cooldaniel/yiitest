// JavaScript Document

/**
 * 思考:
 * 1.和写成公用的js函数这种方式比较哪个更好?
 */

/**
 * jQueyr插件,提供对外接口,封装具体实现
 */
;(function($){
	
	$.fn.fetch=function(options){
		return this.each(function(){
			var settings=$.extend({},$.fn.fetch.defaults,options||{});
			var url=settings.url;
			var type=settings.type;
			var data=settings.data;
			var dataType=settings.dataType;
			var live=settings.live;
			var event=settings.event;
			if(url==''){
				if(settings.debug)
					alert('url无效');
				else
					return false;
			}
			var $this=$(this);
			var id=$this.attr('id');
			jQuery('#'+id).live(event,function(){
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
			});
		});
	};
	
	$.fn.fetch.settings={};
	$.fn.fetch.defaults={
		url:'',
		data:'',
		dataType:'text',
		event:'click',
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
})(jQuery);