<?php
class TestData2 extends Data2
{
	public $uName;
	public $uEmail;
	public $uSex;
	public $uPwd;
	public $uSn;
	public $uMoney;
	public $uM;
	
	public function tableName()
	{
		return 'user';
	}
	
	public function rules()
	{
		return array(
			array('uName,uEmail,uSex,uPwd,uSn,uMoney,uM','safe')
		);
	}
}
?>