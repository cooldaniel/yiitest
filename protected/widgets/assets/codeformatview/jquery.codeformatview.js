/**
 * CodeFormatView客户端js脚本
 * 主要功能是使用jQuery的slideUp()和slideDown()函数实现代码格式化区域的滑动显示效果
 * @version 2011.03.07
 */
;(function ($) {
    /**
     * codeFormatView 设置函数
     * @param map codeFormatView的配置.可用选项有:
     * - clickLegend:显示滑动效果时点击的位置
     */
    $.fn.codeFormatView = function (options) {

        return this.each(function () {

            var settings = $.extend({}, $.fn.codeFormatView.defaults, options || {});
            var $this = $(this);

            //获取当前元素的id
            var id = $this.attr('id');

            //点击区域
            var lg = $(this.children[0]);
            var l = settings.clickLegend ? lg : $this;

            //隐藏
            var c = $(this.children[1]);
            if (settings.defaultClose) {
                c.slideUp();
                c.addClass('down');
                l.attr('title', '点击展开');
                lg.addClass('plus');
            } else {
                c.slideDown();
                c.removeClass('down');
                l.attr('title', '点击收起');
                lg.removeClass('plus');
            }

            //点击事件
            l.bind('click', function () {
                if (c.hasClass('down')) {
                    c.slideDown();
                    c.removeClass('down');
                    l.attr('title', '点击收起');
                    lg.removeClass('plus');

                } else {
                    c.slideUp();
                    c.addClass('down');
                    l.attr('title', '点击展开');
                    lg.addClass('plus');
                }
            });

            //alert(lg.attr('class'));
            /*l.bind('mouseover',function()
            {
                c.slideDown();
            });

            l.bind('mouseout',function()
            {
                c.slideUp();
            });*/
        });
    };

    $.fn.codeFormatView.defaults = {
        clickLegend: true,
        defaultClose: true
    };

    /*$.fn.codeFormView.settings={};

    $.fn.codeFormView.slideUp=function()
    {

    }*/

})(jQuery);