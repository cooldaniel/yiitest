<?php

include './foo.php';
use daniel\foo\Foo;
$foo = new Foo();
$foo::index();

include './bar.php';
use daniel\foo\bar\Bar;
$bar = new Bar();
$bar::index();