<?php
class TestData extends Data
{
	public $one;
	public $two;
	
	public function rules()
	{
		return array(
			array('one,two','required')
		);
	}
}
?>