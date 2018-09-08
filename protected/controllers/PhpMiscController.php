<?php
class PhpMiscController extends Controller
{
	public function actionIndex()
	{
		$this->render('phpmisc');
	}
	
	public function actionFormSecurity()
	{
		if(isset($_POST['userinput']))
		{
			$d=addslashes($_POST['userinput']);
			
			//$sql="INSERT INTO 77frame.forall(`varchar`) VALUES('{$d}')";
			//D::log($sql);
			//Yii::app()->db->createCommand($sql)->query();
			
			$this->refresh();
		}
		$this->render('formSecurity');
	}
	
	// 弹窗提交表单
	public function actionPopupSubmit()
	{
		$this->render('popup_submit');
	}
	
	public function actionForm()
	{
		$this->layout='lite';
		$this->render('form');
	}

	public function actionRemain()
    {
        echo '<div>';
        echo '<ul>';

        foreach (range(0, 15) as $item) {

            \D::log(($item + 1) % 5);

            echo '<li>'.$item.'</li>';

            if (($item + 1) % 5 == 0) {
                echo '</ul>';
                echo '<ul>';
            }
        }

        echo '</ul>';
        echo '</div>';
    }

    public function actionSlowCpu()
    {
$a = range(1, 1000000);

$i = 1;
while ($i) {
shuffle($a);
sort($a);
rsort($a);

$i--;
}

        \D::usage();
    }

    public function actionBasic()
    {
        \D::pd(get_defined_functions());
        \D::pd(get_defined_vars());
        \D::pd(get_defined_constants());
        \D::pd(get_declared_interfaces());
        \D::pd(get_declared_traits());
        \D::pd(get_declared_classes());
    }
}
