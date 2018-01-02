<?php
class FrameworkController extends Controller
{
    public function actionIndex()
    {
        $this->widget('CListPager', ['pageSize'=>10, 'itemCount'=>100]);
    }
}


































