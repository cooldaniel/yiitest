<?php
/**
 * 可外置的jQuery插件示例及分析.
 *
 * 此插件设计与调用原理见实例的(1),(2),(3),(4),(5),(6)步骤说明.
 *
 * 这里测试创建多个实例的情况.
 */
?>

<?php ob_start(); ?>

<!-- 构造html结构 -->
<?php
// 测试数据
$data = range(1, 2);

// 唯一id列表
$uniqueIdList = [];
?>

<div class="tab-block">

    <?php // 生成多个独立的操作区域 ?>
    <?php foreach ($data as $index => $item): ?>

        <?php
        //(1)在php代码里确定元素id - 生成唯一id，由编写DOM结构的人负责id的唯一性
        $id = 'list_' . $index . '_' . rand();

        // 后面注册js脚本的时候使用这些唯一id
        $uniqueIdList[] = $id;
        ?>

        <?php //(2)将id传递给HTML结构对象 ?>
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
    <?php endforeach; ?>

</div>

<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>

<!-- 引入jquery插件和css -->
<script><?php echo file_get_contents(Yii::app()->getBasePath() . '/views/js/assets/jquery.myPlugin.js'); ?></script>
<style><?php echo file_get_contents(Yii::app()->getBasePath() . '/views/js/assets/jquery.myPlugin.css'); ?></style>

<!-- 注册jquery插件调用js脚本 -->
<?php

//(3)将id用在js中调用插件方法(在这里调用插件),调用时可传递额外的参数
foreach ($uniqueIdList as $id)
{
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

    Yii::app()->clientScript->registerScript($id, $js);
}

?>

<?php
$this->widget('application.widgets.CodeFormatView', array(
    'file' => __FILE__,
    'content' => ob_get_clean(),
    'defaultClose' => false,
    'renderHtml' => !false,
    'renderCode' => !false,
    'legend' => 'jquery plugin 02'
));
?>