<?php
$t=microtime();
D::pd($t);

$d=explode(' ',$t);
D::pd($d[0]+$d[1]); // 和microtime(true)一样

$t=microtime(true);

D::date(false,$t);
D::date(false,$d[1]);
?>