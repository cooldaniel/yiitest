<?php
/**
 * 测试自定义图片下载的header头部
 * @copyright lsx 2012/10/24
 * @package application.controllers
 */
class ImageController extends Controller
{
	public function actionShow()
	{
		$file = 'monkey.gif';

		if (file_exists($file)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.basename($file));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			ob_clean();
			flush();
			readfile($file);
			exit;
		}

	}

	public function actionOnError()
    {
        $this->render('onError');
    }
}