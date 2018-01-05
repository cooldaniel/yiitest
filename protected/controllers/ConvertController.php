<?php

/**
 * @package application.controllers
 */
class ConvertController extends Controller
{
    protected $convert_helper;

	public function getConvertHelper()
    {
        if ($this->convert_helper === null) {
            $this->convert_helper = new ConvertHelper();
        }
        return $this->convert_helper;
    }

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

                $res = $this->getConvertHelper()->convert($_POST['ConvertForm']);

                // Keep the result prompt and data for the next request showing.
                $user->setState('convertdata', $res);
                $user->setFlash('operationSucceeded', 'Operation Succeeded');

                // Refresh the page to discard the post operation
                $this->refresh();
			}
		}

		// Set choice as json if null
		if (!$model->choice) {
            $model->choice = ConvertHelper::CHOICE_JSON;
        }

		$this->render('index',array('model'=>$model));
	}
}























