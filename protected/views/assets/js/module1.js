/**
 * @version 2011.03.19
 * @author lsx
 */
site.m=(function($){
	var pub={
		property_1:'property_1',
		function_1:function(data){
			alert(data);
		},
		init:function(options){
			$('.click').live('click',function(){
				//调用整个闭包中定义的函数
				private_function_1();
				//调用pub对象中定义的成员方法
				pub.function_1('public function defind by object "pub".');
			});
		}
	};
	
	//私有属性
	var private_property_1='private_property_1';
	
	//私有函数
	function private_function_1(){
		//访问整个闭包中定义的私有变量
		alert('Access some private property "private_property_1" by private function "private_function_1": '+private_property_1);
		//访问pub对象中定义的成员属性
		alert('Access some public property "property_1" which defined by object "pub": '+pub.property_1);
	};
	
	return pub;
})(jQuery);