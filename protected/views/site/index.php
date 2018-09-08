<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<br/>
<br/>
<h3>接口列表</h3>

<p class="hint">
自动根据controller目录文件的action方法生成接口列表，勾选后就可以显示在站点首页接口列表.<br/>
操作方式：勾选要显示的接口列表，去掉不需要显示的接口列表选中状态. <a href="<?php echo $this->createUrl('site/index'); ?>">index</a> <a href="<?php echo $this->createUrl('site/select'); ?>">select</a>
</p>

<form action="" method="post">

<?php if ($showForm): ?>
<span style="position: fixed; top:230px; left: 1300px; right: auto;  bottom: auto;">
    <input type="submit" name="submit" value="submit" />
</span>
<?php endif; ?>

<table style="width: auto;">
    <tbody>
        <?php foreach ($data as $name => $group): ?>
        <tr>
            <th style="vertical-align: top; text-align: right;">
                <span class="span-3"><?php echo $name; ?></span>
            </th>
            <td>
                <?php foreach ($group as $row): ?>
                <div>
                    <span class="span-6"><a href="<?php echo $row['url']?>"><?php echo $row['text']?></a></span>
                    <span><input type="checkbox" name="form[checked_list][]" value="<?php echo $row['route']?>" <?php if ($row['checked']): ?>checked="checked"<?php endif; ?> /></span>
                </div>
                <?php endforeach; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</form>
