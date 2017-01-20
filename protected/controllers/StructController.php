<?php

/**
 *
 * @package application.controllers
 */
class StructController extends Controller
{
    public $res;

    public function actionIndex()
    {
        $data = $this->cc(1, 5);
        D::pd($data);
    }

    public function cc($amount, $coins)
    {
        $item = [];

        $item['text'] = "cc $amount $coins";
        $item['offset_multi'] = $coins;

        $coins_next = $coins - 1;
        $amount_next = $amount - $this->coin($coins);
        if ($coins_next >= 0)
        {
            $item['left'] = $this->cc($amount, $coins_next);
        }
        if ($amount_next >= 0)
        {
            $item['right'] = $this->cc($amount_next, $coins);
        }

        return $item;
    }

    public function coin($coin)
    {
        $list = [1=>1, 2=>5, 3=>10, 4=>25, 5=>50];
        if ($coin > 0)
        {
            return $list[$coin];
        }
        else
        {
            return -1;
        }
    }
}