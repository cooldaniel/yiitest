<?php

class ResourceController extends Controller
{
    public function actionList()
    {
        $accessToken = Yii::app()->request->getParam('access_token');

        $error = TokenAuthManager::getInstance()->validateToken($accessToken);
        if ($error !== null) {

            $data = [
                'code'=>50000,
                'msg'=>$error,
                'data'=>'',
            ];

            echo UnicodeJson::json_encode($data);

        } else {

            $data = [
                'code'=>200,
                'msg'=>'',
                'data'=>[
                    ['url'=>Yii::app()->request->hostInfo.'/pictures/1.ig.jpg'],
                    ['url'=>Yii::app()->request->hostInfo.'/pictures/2.ig.jpg'],
                    ['url'=>Yii::app()->request->hostInfo.'/pictures/3.ig.jpg'],
                    ['url'=>Yii::app()->request->hostInfo.'/pictures/4.ig.jpg'],
                    ['url'=>Yii::app()->request->hostInfo.'/pictures/5.ig.jpg'],
                ],
                'total_num'=>10,
            ];

            echo UnicodeJson::json_encode($data);

        }
    }
}
