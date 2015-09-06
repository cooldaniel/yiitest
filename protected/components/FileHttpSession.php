<?php
/**
 * 用自定义文件的方式存储session数据.
 * 
 * @Author Daniel
 * @Reference 摘自PHP手册Session扩展的session_set_save_handler()函数介绍一节.
 * @see 该组件扩展自Yii框架的CHttpSession组件，具体编写规则请参考后者.
 */
class FileHttpSession extends CHttpSession
{
    private $savePath;
	
	public function openSession($savePath, $sessionName)
    {
		if (is_dir($savePath)) {
            $this->savePath = $savePath;
        }
		else
			throw new CException(Yii::t('archit','FileHttpSession.savePath "{path}" is not a valid directory.',
				array('{path}'=>$savePath)));

        return true;
    }

    public function closeSession()
    {
        return true;
    }

    public function readSession($id)
    {
        return (string)@file_get_contents("$this->savePath/sess_$id");
    }

    public function writeSession($id, $data)
    {
        return file_put_contents("$this->savePath/sess_$id", $data) === false ? false : true;
    }

    public function destroySession($id)
    {
        $file = "$this->savePath/sess_$id";
        if (file_exists($file)) {
            unlink($file);
        }

        return true;
    }

    public function gcSession($maxlifetime)
    {
        foreach (glob("$this->savePath/sess_*") as $file) {
            if (filemtime($file) + $maxlifetime < time() && file_exists($file)) {
                unlink($file);
            }
        }

        return true;
    }
}