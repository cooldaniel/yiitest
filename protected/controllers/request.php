<?php

//require_once(dirname(__FILE__).'/../../../../projects/D/autoload.php');


function request($url, $postData=[], $post=0)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
    curl_setopt($ch, CURLOPT_POST, $post);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $return = curl_exec($ch);
    curl_close($ch);
    return $return;
}


$max = 1000;
$url = 'http://120.24.158.114:8000/hi.php';
while (1){
    $res = request($url);
    echo $res .rand() . "\n";
    sleep(1);
}