<?php

class CacheController extends Controller
{
	public function actionIndex()
	{
		//header('HTTP/1.1 304 Not Modified');
		header("expires=Thu, 01-Jan-2017 00:00:01 GMT");
		$this->render('index', array('rand'=>rand()));
	}

	public function actionMem()
	{
		$host = 'localhost';
		$port = 11211;
		$memcache = new Memcache;
		//$memcache->connect($host, $port) or die ("Could not connect");
		$memcache->addServer($host, $port);

		$version = $memcache->getVersion();
		echo "服务端版本信息: ".$version."<br/>\n";

		$tmp_object = new stdClass;
		$tmp_object->str_attr = 'test';
		$tmp_object->int_attr = rand();

		$memcache->set('key', $tmp_object, false, 10) or die ("Failed to save data at the server");
		echo "将数据保存到缓存中（数据10秒后失效）<br/>\n";

		$get_result = $memcache->get('key');
		echo "从缓存中取到的数据:<br/>\n";

		D::pd($get_result);

		D::ref($memcache);
		D::pd($memcache->getstats());
		D::pd($memcache->getserverstatus($host, $port));

		$memcache->flush();
		D::pd($memcache->get('key'));
	}

	public function actionMemd()
	{
		$m = new Memcached();
		$m->addServer('localhost', 11211);
		$items = array(
			'key1' => 'value1',
			'key2' => 'value2',
			'key3' => 'value3'
		);
		$m->setMulti($items);
		$m->getDelayed(array('key1', 'key3'), true, 'result_cb');

		function result_cb($memc, $item)
		{
			var_dump($item);
		}

	}
}