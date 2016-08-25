<?php

class RandController extends Controller
{	
	public function actionIndex()
	{
		$s16 = $this->createNonceStr();
		$s32 = $this->createNonceStr(32);
		$s128 = $this->createNonceStr(128);
		D::pd($s16, $s32, $s128);

        D::pd($this->create_guid());
        D::pd($this->guid());
	}
	
	public function createNonceStr($length = 16)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";

        for ($i = 0; $i < $length; $i++) {
          $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }

        return $str;
    }

    public function create_guid()
    {
        return strtoupper(md5(uniqid(mt_rand(), true)));
    }

    /**
     * @return string
     */
    public function guid()
    {
        if (function_exists('com_create_guid'))
        {
            return com_create_guid();
        }
        else
        {
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = chr(123)// "{"
                .substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12)
                .chr(125);// "}"
            return $uuid;
        }
    }
}