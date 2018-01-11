<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<?php foreach ($data as $row): ?>
<li><a href="<?php echo $row['url']?>"><?php echo $row['text']?></a></li>
<?php endforeach; ?>
