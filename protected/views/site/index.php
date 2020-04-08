<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('app', 'Index');
?>

<br/>
<br/>
<h3>接口列表</h3>

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
                </div>
                <?php endforeach; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</form>
