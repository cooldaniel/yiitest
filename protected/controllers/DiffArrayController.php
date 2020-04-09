<?php

/**
 * @package application.controllers
 */
class DiffArrayController extends Controller
{
	public function actionIndex()
	{
		$model=new DiffArrayForm();
        $user = Yii::app()->user;

        // Get the last data from the session to show again
        if ($user->hasState('diffarraydata')) {
			$model->attributes = $user->getState('diffarraydata');
		}

		// Process the post data
		if(isset($_POST['DiffArrayForm'])) {
			$model->attributes=$_POST['DiffArrayForm'];

            // Make sure that validating the format before using
			if($model->validate()) {

                // Run
                $res = (new DiffArraytHelper())->run($_POST['DiffArrayForm']);

                // Keep the result prompt and data for the next request showing.
                $user->setState('diffarraydata', $res);
                $user->setFlash('operationSucceeded', 'Operation Succeeded');

                // Refresh the page to discard the post operation
                $this->refresh();
			}
		}

		// Init the direct if null
		if (!$model->direct) {
            $model->direct = DiffArraytHelper::DIRECT_LEFT_RIGHT;
        }

//		\D::logc($model->attributes);

		$this->render('index',array('model'=>$model));
	}
}























