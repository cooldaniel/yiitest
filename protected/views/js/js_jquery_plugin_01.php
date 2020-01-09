<?php
/**
 * 可外置的jQuery插件示例及分析.
 *
 * 此插件设计与调用原理见实例的(1),(2),(3),(4),(5),(6)步骤说明.
 *
 * 这里测试简单写法.
 */
?>

<?php ob_start(); ?>

<!-- 构造html结构 -->
<?php

//(1)在php代码里确定元素id
$id = 'list_' . rand();

//(2)将id传递给HTML结构对象
?>
<div id="<?php echo $id; ?>">
    <ul>
        <li class="hidden" style="display:none">
            <input type="text" value="<?php echo rand(); ?>"/>
        </li>
        <li>
            one<span class="additional-content">about one</span>
        </li>
        <li class="checked">
            two<span class="additional-content">about two</span>
        </li>
        <li>
            three<span class="additional-content">about three</span>
        </li>
    </ul>
</div>

<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>

<!-- 引入jquery插件和css -->
<script><?php echo file_get_contents(Yii::app()->getBasePath() . '/views/js/assets/jquery.myPlugin.js'); ?></script>
<style><?php echo file_get_contents(Yii::app()->getBasePath() . '/views/js/assets/jquery.myPlugin.css'); ?></style>

<!-- 注册jquery插件调用js脚本 -->
<?php

//(3)将id用在js中调用插件方法(在这里调用插件),调用时可传递额外的参数
$options = array(
    'alwaysCheckedClass' => 'node-checked',
    'beforeCallback'=>'function () {
        console.log("before callback");
    }',
    'afterCallback'=>'function () {
        console.log("after callback");
    }',
);

if (0)
{
    // php方式生成配置选项
    $jsOptions = '{';
    foreach ($options as $index => $item)
    {
        if (is_string($item) && (strpos($item, 'function') === false))
        {
            $item = "'{$item}'";
        }
        $jsOptions .= "'{$index}': {$item},";
    }
    $jsOptions = rtrim($jsOptions, ',');
    $jsOptions .= '}';

    // 调试的时候要把整个EOD表达式注释掉，如果只在EOD里面注释掉代码，则前面生成的$jsOptions字符串会导致js语法错误
    // 可以通过查看生成的js代码查看错误原因
    $js = <<<EOD
$('#{$id}').myPlugin($jsOptions);
EOD;

}
else
{
    // js方式生成配置选项
    $js = <<<EOD
$('#{$id}').myPlugin({
    alwaysCheckedClass: 'node-checked',
    beforeCallback: function () {
        console.log("before callback");
    },
    afterCallback: function () {
        console.log("after callback");
    }
});
EOD;

}
Yii::app()->clientScript->registerScript($id, $js);
?>

<?php
$this->widget('application.widgets.CodeFormatView', array(
    'file' => __FILE__,
    'content' => ob_get_clean(),
    'defaultClose' => false,
    'renderHtml' => !false,
    'renderCode' => !false,
    'legend' => 'jquery plugin 01'
));
?>