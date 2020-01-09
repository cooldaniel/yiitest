/**
 * 可外置的jQuery插件函数定义脚本.
 */
;(function ($) {

    $.fn.myPlugin = function (options) {

        //(4)在插件方法中使用jQuery.each()来使得在each()指定的函数中可以通过this.id来获得HTML结构对象的id,从而把握了整个HTML结构.
        return $(this).each(function () {
            var settings = $.extend({}, $.fn.myPlugin.defaults, options || {});
            var id = $(this).attr('id');

            //保存配置以便在整个插件环境都可以通过$.fn.myPlugin.settings来使用
            //注意:这里通过id来标识分组,因为这个组件可复用,而后续在额外定义函数中应该使用此id来访问特定配置.
            $.fn.myPlugin.settings[id] = settings;
            console.log(settings);

            if (settings.beforeCallback) {
                settings.beforeCallback();
            }

            //(5)基于HTML结构来控制该结构内部的元素(要求该结构是个良好的结构)
            var alwaysCheckedClass = settings.alwaysCheckedClass;

            //仅对非alwaysCheckedClass标识的li应用"鼠标经过更换颜色"、"隐藏内容显示"效果
            $('#' + id + ' li').hover(function () {
                if (this.className != alwaysCheckedClass) {
                    $(this).css('color', 'red');
                }
                $(this).children('span').eq(0).show();
            }, function () {
                if (this.className != alwaysCheckedClass) {
                    $(this).css('color', 'inherit');
                }
                $(this).children('span').eq(0).hide();
            });

            //(6)事件触发调用其它预定函数,在这些函数中将使用上面保存的配置数据.
            $('#' + id + ' li span').live('click', function () {
                $.fn.myPlugin.someApp(id, $(this).text());
            });

            //(7)渲染后调用
            if (settings.afterCallback) {
                settings.afterCallback();
            }
        });
    };

    /**
     * 用在插件和HTML中的配置.
     * - alwaysCheckedClass: 总是选中的li的class名称
     */
    $.fn.myPlugin.defaults = {
        alwaysCheckedClass: 'checked',
        beforeCallback: null,
        afterCallback: null
    };

    /**
     * 用于保存初始配置的属性.
     */
    $.fn.myPlugin.settings = {};

    /**
     * @return string 返回插件的全名.
     */
    $.fn.myPlugin.pluginName = function () {
        return '$.fn.myPlugin';
    };

    /**
     * 返回某些由服务器端脚本在构建HTML结构对象时渲染的额外数据.
     */
    $.fn.myPlugin.someDynamic = function (id) {
        return $('#' + id + ' li.hidden > input').val();
    };

    /**
     * 额外的使用$.fn.myPlugin.settings配置的例子函数.
     */
    $.fn.myPlugin.someApp = function (id, content) {
        var someappId = id + '_someapp';
        var html = '<div id="' + someappId + '">' +
            'Plugin name: ' + $.fn.myPlugin.pluginName() + '.<br/>' +
            'Class "alwaysCheckedClass": ' + $.fn.myPlugin.settings[id].alwaysCheckedClass + '.<br/>' +
            'Click content : ' + content + '.<br/>' +
            'Id: ' + id + '.<br/>' +
            'Content generated dynamicly: ' + $.fn.myPlugin.someDynamic(id) + '.<br/>' +
            'By $.fn.myPlugin.someApp()' + '.<br/>' +
            '</div>';

        // 先删除
        $('#' + someappId).remove();

        // 再添加
        $('#' + id).append($(html));
    }
})(jQuery);