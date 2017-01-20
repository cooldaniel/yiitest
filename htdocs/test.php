<?php

require_once(dirname(__FILE__).'/../../../projects/D/autoload.php');

foreach (range('a', 'z') as $char)
{
    echo ($char);
}


var_dump(xdebug_code_coverage_started());
xdebug_start_code_coverage();
var_dump(xdebug_code_coverage_started());

xdebug_start_code_coverage();

function a($a) {
    echo $a * 2.5;
}

function b($count) {
    for ($i = 0; $i < $count; $i++) {
        a($i + 0.17);
    }
}

b(6);
b(10);

var_dump(xdebug_get_code_coverage());

D::pd(xdebug_get_profiler_filename());
D::fp();