<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1><?php echo Yii::t('app', 'Welcome to'); ?> <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>


<!--
// 通过表单提交方式跨域访问
<form action="http://xzhshop.local/test.php" method="post" name="theForm">
    <input type="text" name="name" value="daniel" />
    <input type="submit" value="submit" />
</form>
<script>
$(function(){
    // 自动提交表单
    //$('form[name="theForm"]').submit();
});
</script>
-->

<!--
<script>
// AJAX无法跨域访问
$(function(){
    $.ajax({
        url: 'http://xzhshop.local/user.php?kkk=111',
        type: 'POST',
        data: {
            name: 'daniel',
            age: 19,
            sex: 1
        },
        success: function(response){
            console.log(response);
        }
    });
});
</script>
-->

<!--
// 通过资源加载方式跨域访问 - 测试登录状态
<img src="http://xzhshop.local/user.php?kkk=111" />
-->

<!--
// 通过资源加载方式跨域访问 - 测试非登录状态
<img src="http://xzhshop.local/test.php?kkk=111" />
-->

<!--
<script>
//设置cookie
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}
//获取cookie
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) != -1) return c.substring(name.length, c.length);
    }
    return "";
}
//清除cookie
function clearCookie(name) {
    setCookie(name, "", -1);
}
</script>
<script>
// cookie访问测试
$(function(){
    console.log(document.cookie);
    console.log(getCookie('PHPSESSID'));
    console.log(getCookie('ECS_ID'));
});
</script>
-->

<?php
/*
D::pd(Yii::t('app', 'name'));
D::pd(Yii::t('goods', 'goodsName'));
D::pd(Yii::app()->messages);
D::pd(Yii::app()->language);
D::pd(Yii::getLogger()->getLogs());
*/

$data = array(
    array(
        'text'=>'1111',
        'children'=>array(
            array('text'=>'dd', 'url'=>'#'),
            array('text'=>'dd', 'url'=>'#'),
            array('text'=>'dd', 'url'=>'#'),
            array('text'=>'dd', 'url'=>'#'),
            array('text'=>'dd', 'url'=>'#'),
            array('text'=>'dd', 'url'=>'#'),
        ),
    ),
    array(
        'text'=>'22222',
        'children'=>array(
            array('text'=>'dd', 'url'=>'#'),
            array('text'=>'dd', 'url'=>'#'),
            array('text'=>'dd', 'url'=>'#'),
            array('text'=>'dd', 'url'=>'#'),
            array('text'=>'dd', 'url'=>'#'),
            array('text'=>'dd', 'url'=>'#'),
        ),
    ),
);
?>

<table>
    <thead>
        <tr>
            <th>模块</th>
            <th>功能</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $row): ?>
        <?php
            $count = count($row['children']);
            $first = array_shift($row['children']);
        ?>

        <tr>
            <td rowspan="<?php echo $count; ?>"><?php echo $row['text']; ?></td>
            <td><?php echo $first['text']; ?></td>
        </tr>

        <?php foreach ($row['children'] as $item): ?>
            <tr><td><a href="<?php echo $item['url']; ?>"><?php echo $item['text']; ?></a></td></tr>
        <?php endforeach ?>

        <?php endforeach ?>
    </tbody>
</table>

<script>
//$(function(){
//	$.ajax({
//		url: 'http://192.168.0.39:8081/init/findMarriageList.do',
//		type: 'POST',
//		dataType: 'json',
//		success: function(res) {
//			var rows = res.response;
//			alert(rows[0].codeName);
//		}
//	});
//});
</script>