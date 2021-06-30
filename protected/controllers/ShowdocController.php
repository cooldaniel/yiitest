<?php

/**
 * @package application.controllers
 */
class ShowdocController extends Controller
{
	public function actionIndex()
	{
		$model=new ShowdocForm();
        $user = Yii::app()->user;

        // Get the last data from the session to show again
        if ($user->hasState('showdocdata')) {
			$model->attributes = $user->getState('showdocdata');
		}

		// Process the post data
		if(isset($_POST['ShowdocForm'])) {
			$model->attributes=$_POST['ShowdocForm'];

            // Make sure that validating the format before using
			if($model->validate()) {

                // run
                $res = (new ShowdocHelper())->run($_POST['ShowdocForm']);

                // Keep the result prompt and data for the next request showing.
                $user->setState('showdocdata', $res);
                $user->setFlash('operationSucceeded', 'Operation Succeeded');

                // Refresh the page to discard the post operation
                $this->refresh();
			}
		}

		$this->render('index-tab',array('model'=>$model));
	}
}























