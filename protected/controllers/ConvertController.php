<?php

/**
 * @package application.controllers
 */
class ConvertController extends Controller
{
	public function actionIndex()
	{
		$model=new ConvertForm();
        $user = Yii::app()->user;

        // Get the last data from the session to show again
        if ($user->hasState('convertdata')) {
			$model->attributes = $user->getState('convertdata');
		}

		// Process the post data
		if(isset($_POST['ConvertForm'])) {
			$model->attributes=$_POST['ConvertForm'];

            // Make sure that validating the format before using
			if($model->validate()) {

                // run
                $res = (new ConvertHelper())->run($_POST['ConvertForm']);

                // Keep the result prompt and data for the next request showing.
                $user->setState('convertdata', $res);
                $user->setFlash('operationSucceeded', 'Operation Succeeded');

                // Refresh the page to discard the post operation
                $this->refresh();
			}
		}

		// Init the choice if null
		if (!$model->choice) {
            $model->choice = ConvertHelper::CHOICE_JSON;
        }

		$this->render('index-tab',array('model'=>$model));
	}
}























