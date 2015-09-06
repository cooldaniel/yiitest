<?php
class WidgetsController extends Controller
{
	public function actionIndex()
	{
		$this->render('widgets');
	}
	
	public function actionCform()
	{
		//测试表单的ajax数据验证
		$model=new User;
		$this->performAjaxValidation($model,'user_form');
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->validate())
			{
				Yii::app()->user->setFlash('submit_data_user','submit data: '.D::pdo($_POST['User']));
				$this->refresh();
			}
		}
		$this->render('cform',array('model'=>$model));
	}
	
	//data render test
	public function actionData()
	{
		//$model=new Data();
		
		$model=new TestData2();
		$this->render('data',array('model'=>$model));
	}
	
	//CListView test
	public function actionListView()
	{
		$model=new User;
		$model->unsetAttributes();
		$this->render('listView',array('model'=>$model));
	}
	
	//CGridView test
	//@version 2011.03.15
	public function actionGridView()
	{
		$model=new User;
		$model->unsetAttributes();
		$this->render('gridView',array('model'=>$model));
	}
	
	//for CGridView delete
	//@version 2011.03.15
	public function actionDelete()
	{
		echo 'delete';
	}
	
	//CFlexWidget test
	//@version 2011.03.16
	public function actionFlexWidget()
	{
		$this->render('flexWidget');
	}
	
	//CMultifileUpload test
	//@version 2011.03.16
	public function actionMultifileUpload()
	{
		$model=new User;
		//$model->unsetAttributes();
		D::pd($_POST);
		/*if(isset($_POST['User']))
		{
			D::pde($_POST);
		}*/
		$this->render('multifileUpload',array('model'=>$model));
	}
	
	//CDetailView
	public function actionDetailView()
	{
		$this->render('detailView');
	}
	
	//CTreeView
	public function actionTreeView()
	{
		$this->render('treeView');
	}
	
	//stateful form
	//@version 2011.07.21
	public function actionStatefulForm()
	{
		$this->render('statefulForm');
	}
}
?>