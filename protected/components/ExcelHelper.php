<?php
/**
 * 用于辅助使用PHPExcel的工具类.
 */
class ExcelHelper
{
	public function download($file, $filename='')
    {
        if (empty($filename)){
            $filename = pathinfo($file, PATHINFO_BASENAME);
        }

        $content = file_get_contents($file);
        $size = filesize($file);
        header("Content-Type:application/octet-stream;charset=utf-8");
        header("Accept-Ranges: bytes");
        header("Accept-Length: $size");
        header("Content-Disposition:attachment;filename={$filename}");
        header("Pragma:no-cache");
        header("Expires:0");
        echo $content;
    }
}