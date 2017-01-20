<?php

/**
 *
 * @package application.controllers
 */
class RegController extends Controller
{
    /**
     * 由于html内容由自己生成，因此可以通过给叶节点标签添加标识的方式，减少标签匹配的复杂度.
     * 该方法不同于泛html标签取法.
     */
    public function actionIndex()
    {
        $html = '<dl class="form-row">
          <dt>手机号码</dt>
          <dd>
                        <span data-unit-phone class="strong-text">134*****196</span><span class="icon icon-has-auth"></span><a href="/account/unbindmobile" class="form-link">修改</a>
                      </dd>
        </dl><dl class="form-row">
          <dt>头像</dt>
          <dd><a href="/account/avatar" class="portrait-img  "><img data-unit-avatar src="/dev/images/portrait/10.png" alt="头像" width="60"></a></dd>
        </dl><dl class="form-row">
          <dt>登录名</dt>
          <dd><strong data-unit-name>daniel</strong></dd>
        </dl><dl class="form-row">
          <dt>评价</dt>
          <dd><input data-unit-comment value="hello" /></dd>
        </dl>';

        $pattern = $this->createUnitPattern('span', 'phone');
        $img = $this->getPageString($html, $pattern);
        $pattern = $this->createUnitPattern('strong', 'name');
        $img = $this->getPageString($html, $pattern);
        $pattern = $this->createUnitPattern('img', 'avatar', 'src');
        $img = $this->getPageString($html, $pattern);
        $pattern = $this->createUnitPattern('input', 'comment', 'value');
        $img = $this->getPageString($html, $pattern);
    }

    /**
     * 根据html标签名字、表示、所取属性名等信息，生成匹配正则表达式.
     * @param $tagName
     * @param $signName
     * @param string $attrName
     * @return string
     */
    public function createUnitPattern($tagName, $signName, $attrName='')
    {
        if ($attrName == ''){
            // 取标签文本
            $pattern = '/<{tagName}(?:[^>]*)data-unit-{signName}(?:[^>]*)>([^<]*)<\/{tagName}>/';
        }else{
            // 取属性值
            $pattern = '/<{tagName}(?:[^>]*)data-unit-{signName}(?:[^>]*){attrName}\s*=\s*"([^"]*)(?:[^>]*)\/?>/';
        }
        return strtr($pattern, array(
            '{tagName}'=>$tagName,
            '{signName}'=>$signName,
            '{attrName}'=>$attrName,
        ));
    }

    /**
     * 从给定html内容中匹配指定字符串.
     * @param $html
     * @param $pattern
     * @return string
     */
    public function getPageString($html, $pattern)
    {
        if (!empty($html)){
            preg_match_all($pattern, $html, $match);
            \D::pd($match);
            if (isset($match[1]) && !empty($match[1])){
                return trim($match[1][0]);
            }
        }
        return '';
    }
}