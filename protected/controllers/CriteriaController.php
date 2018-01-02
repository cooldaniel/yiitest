<?php

class CriteriaController extends Controller
{
	public function actionIndex()
	{
        $goods = new Goods();

        $criteria = new CDbCriteria();
        $criteria->select = 'gId';
        $criteria->limit = 3;
        $list = $goods->findAll($criteria);


        foreach ($list as $row){
            \D::pd($row->gId);
            \D::pd($row->gName);
        }


        \D::pd($list);
	}
}