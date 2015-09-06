/**
 * The module library defined from yii-framework.
 * @version 2011.03.19
 * @author lsx
 */

jQuery(document).ready(function($) {
	// call the init() method of every module
	var init = function(module) {
		if($.isFunction(module.init) && (module.trigger==undefined || $(module.trigger).length)) {
			module.init();
		}
		$.each(module, function() {
			if($.isPlainObject(this)) {
				init(this);
			}
		});
	};
	init(site);
});

// the root module
var site = (function($) {
	var pub = {
		init : function() {
			
		}
	};

	return pub;
})(jQuery);
