<?php

/**
 * 跨域访问测试.
 *
 * @package application.controllers
 */
class CrossDomainController extends Controller
{
    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionPage()
    {
        $this->render('page');
    }

    public function actionIframe()
    {
        $this->render('iframe');
    }

    /**
     * 通过{@see actionServerQuery}和{@see actionServerQueryAnswer}成对测试在浏览器和在服务器端分别给服务器发送URL请求
     * 在cookie方面的区别.
     *
     * 结论：可以实现这样的效果：用户访问A网站时所产生的对B网站的跨域访问请求均提交到A网站的指定页面，由该页面代替用户页面完成交互，
     * 从而返回合适的结果.缺点是A网站的服务器负担增加，且无法代用户保存会话状态（cookie丢失）.
     */
    public function actionServerQuery()
    {
        $url = $this->createAbsoluteUrl('serverQueryAnswer');
        $params = array();
        $post = false;

        // 告诉浏览器添加cookie
        setcookie('name', 'daniel');

        // 前面设置的cookie跟这里单独请求另一个URL没有关系
        // 浏览器给服务器端发送cookie由浏览器的cookie管理功能负责处理，服务器端在使用curl发送URL请求时没有自动构造和发送cookie的功能，
        // 这也反映了cookie仅由浏览器管理的机制
        $http = new cls_http_query();
        $res = $http->curl_query($url, $params, $post);
        D::pd($res);
    }
    public function actionServerQueryAnswer()
    {
        // 当客户端浏览器访问该URL时会有cookie，当服务端使用curl访问时则无（参考{@see actionServerQuery}注释说明）.
        echo json_encode(array(rand(), $_POST, $_GET, $_COOKIE, $_SERVER));
    }
}