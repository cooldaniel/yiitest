<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('app', 'URL');
?>

<style>
a:link {color: rgb(0,0,204)}
a:visited {color: rgb(85,26,139)}
a:hover {color: rgb(0,0,240)}
a:active {color: rgb(255,0,0)}
</style>

<?php foreach ($data as $title => $item): ?>

    <?php echo CHtml::tag('h1', ['style'=>'margin-top:30px'], $title); ?>

    <div style="margin: 1.6em auto 1em;">
        <div style="display:inline-block; width:30%;">
            <span>入队</span>
            <span>执行</span>
            <span>暂停</span>
            <span>清空</span>
        </div>
        <div style="display:inline-block; width:30%;">
            <span>入队</span>
            <span>执行</span>
            <span>暂停</span>
            <span>清空</span>
        </div>
        <div style="display:inline-block; width:30%;">
            <span>入队</span>
            <span>执行</span>
            <span>暂停</span>
            <span>清空</span>
        </div>
    </div>

    <div>
        <?php foreach ($item as $text => $urlList): ?>

            <?php foreach ($urlList as $url): ?>

                <div style="display:inline-block; width:30%;">
                <?php echo CHtml::link($text, $url, ['target'=>'_blank']); ?>
                </div>

            <?php endforeach; ?>

        <?php endforeach; ?>
    </div>

<?php endforeach; ?>