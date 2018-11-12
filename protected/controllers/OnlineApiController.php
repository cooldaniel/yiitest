<?php
class OnlineApiController extends TController
{
	public function actionIndex()
	{
        // utf-8
		$dir = 'D:\ismond\pms\apidoc\闪店侠';

        // 如果系统配置是gbk，路径转为gbk再进行文件系统操作
        if ($this->syscharsetgbk()) {
            $dir = $this->u2g($dir);
        }

        $files = CFileHelper::findFiles($dir);

        // 反斜杠转成斜杠
        $this->normalizePath($files);

        // 如果系统配置是gbk，转为utf-8再显示
        if ($this->syscharsetgbk()) {
            $this->g2ul($files);
        }
        \D::pd($files);

        // 打印路径信息
        foreach ($files as $file) {
            $pathinfo = pathinfo($file);
            \D::pd($pathinfo);

        }

	}

	public function normalizePath(&$files)
    {
        foreach ($files as &$file) {
            $file = str_replace('\\', '/', $file);
        }
    }

	public function syscharsetgbk()
    {
        return $this->syscharset() == 'gbk';
    }

	public function syscharset()
    {
        return stristr(PHP_OS, 'WIN') ? 'gbk' : 'utf-8';
    }

    public function u2g($content)
    {
        return iconv('utf-8', 'gbk', $content);
    }

    public function g2u($content)
    {
        return iconv('gbk', 'utf-8', $content);
    }

    public function u2gl($list)
    {
        foreach ($list as &$item) {
            $item = $this->u2g($item);
        }
    }

    public function g2ul(&$list)
    {
        foreach ($list as &$item) {
            $item = $this->g2u($item);
        }
    }
}
