<div>
<form>
<form>

<ul id="list_1">
    <li>list with <strong><em>random</em></strong> data</li>
	<li><?php echo rand(); ?></li>
    <div>
    <li>
    </div>
    </li>
    <div>
    <div>
    
</div>
</div>
</form>
</form>
</form>
<div>

<?php
/**
 * 注意：
 * 以上代码不能像下面那样加注释,否则IE浏览器将停止工作,但在opera和firefox下能正常工作.
 * 因为增加的注释和不合法的<form/>标签组合在一起导致解析错误.
 */

/*
<!--ul外部的标签,联合ul内部的标签,不合法-->
<div>
<form>
<form>

<ul id="list_1"> <!--为成对闭合的ul-->
    <li>list with <strong><em>random</em></strong> data</li> <!--正常数据-->
	<li><?php echo rand(); ?></li> <!--正常数据-->
    
    <!--ul内部的交错嵌套标签-->
    <div>
    <li>
    </div>
    </li>
    <div>
    
    <!--ul内部的不完整标签-->
    <div>

<!--ul在这里没有闭合-->

<!--其它不合法标签-->
</div>
</div>
</form>
</form>
</form>
<div>
*/ ?>