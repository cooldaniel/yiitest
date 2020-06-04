
;(function ($) {

    $.fn.swapcookiedata = function (options) {

        $(this).each(function () {

            var settings = $.extend({}, $.fn.swapcookiedata.defaults, options || {});

            // ID和配置
            $.fn.swapcookiedata.id = settings.name + '_' + Math.random();
            $.fn.swapcookiedata.settings[$.fn.swapcookiedata.id] = settings;

            console.log(settings);
            console.log($.fn.swapcookiedata.id);

            // 前置调用
            if (settings.beforeCallback) {
                settings.beforeCallback();
            }

            settings.name = $(this).attr('name');
            settings.type = $(this)[0].tagName.toLowerCase();

            console.log(settings);

            // 处理
            $.fn.swapcookiedata.swapCookieDataByType(settings.name, settings.type);

            // 后置调用
            if (settings.afterCallback) {
                settings.afterCallback();
            }
        });

        return $.fn.swapcookiedata;
    };

    $.fn.swapcookiedata.pluginName = function () {
        return '$.fn.swapcookiedata';
    };

    $.fn.swapcookiedata.id = null;

    $.fn.swapcookiedata.defaults = {
        name: null,
        type: 'textarea',
        beforeCallback: null,
        afterCallback: null
    };

    $.fn.swapcookiedata.settings = {};

    $.fn.swapcookiedata.getCookieName = function (name) {
        return name + '_' + 'backup';
    };

    $.fn.swapcookiedata.getCookieData = function () {
        return $.cookie($.fn.swapcookiedata.getCookieName($.fn.swapcookiedata.settings[$.fn.swapcookiedata.id].name));
    };

    $.fn.swapcookiedata.swapCookieDataByType = function (name, type) {

        var cookieName = $.fn.swapcookiedata.getCookieName(name);
        var selector = type + '[name="' + name + '"]';

        console.log(cookieName, selector);
        console.log($.cookie(cookieName));
        console.log($(selector).val());

        // 载入页面的时候从cookie读取数据到文本域
        if ($.cookie(cookieName)) {
            $(selector).val($.cookie(cookieName));
        }

        // 输入文本框的时候保存到cookie
        $(selector).on('keyup', function () {
            $.cookie(cookieName, $(this).val(), {expires: 1000});
            console.log(cookieName + ': ' + $.cookie(cookieName));
        });

        // 输入文本框的时候保存到cookie
        $(selector).on('change', function () {
            $.cookie(cookieName, $(this).val(), {expires: 1000});
            console.log(cookieName + ': ' + $.cookie(cookieName));
        });
    };
})(jQuery);