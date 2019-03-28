<?php

/* http请求结果 */
define('ERR_HTTP_SUCCESS', 200);
define('ERR_HTTP_FAILED', 500);

/* 业务操作结果 */
define('ERR_OPERATE_SUCCESS', 200);
define('ERR_OPERATE_FAILED', 50000);

// 授权码操作结果
define('ERR_OPERATE_AUTH_CODE_YES', 200);
define('ERR_OPERATE_AUTH_CODE_NO', 50001);
define('ERR_OPERATE_AUTH_CODE_FAILED_STRUCT', 50002);
define('ERR_OPERATE_AUTH_CODE_FAILED_VALIDATE', 50003);
define('ERR_OPERATE_AUTH_CODE_FAILED_TOKEN', 50004);

$GLOBALS['ERR_MESSAGE'] = [
    ERR_HTTP_SUCCESS=>'接口请求成功',
    ERR_HTTP_FAILED=>'接口请求失败',

    ERR_OPERATE_SUCCESS=>'操作成功',
    ERR_OPERATE_SUCCESS=>'操作失败',

    ERR_OPERATE_AUTH_CODE_YES=>'授权成功',
    ERR_OPERATE_AUTH_CODE_NO=>'拒绝授权',
    ERR_OPERATE_AUTH_CODE_FAILED_STRUCT=>'授权失败，系统错误，无法获取授权码，返回数据结构错误，请稍后重试',
    ERR_OPERATE_AUTH_CODE_FAILED_VALIDATE=>'授权失败，系统错误，无法获取授权码，返回数据验证无效，请稍后重试',
    ERR_OPERATE_AUTH_CODE_FAILED_TOKEN=>'授权失败，系统错误，无法获取token，请稍后重试',
];


