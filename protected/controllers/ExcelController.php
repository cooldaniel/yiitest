<?php

class ExcelController extends Controller
{
	public function actionIndex()
	{
        // 使用YiiExcel
        $excel = new YiiExcel();

        \D::pd($excel);


        // 使用原生PHPExcel组件
        $excel = new PHPExcel();
        $excel->setActiveSheetIndex(0);
        $sheet = $excel->getActiveSheet();

        $sheet->getStyle('A1')->getAlignment()->setShrinkToFit(true);//字体变小以适应宽
        $sheet->getStyle('A1')->getAlignment()->setWrapText(true);//自动换行

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('A')->setWidth(30);

        \D::pd($excel);
    }

    public function actionLoadDataInFile()
    {
        // 必须转义路径分隔符
        $path = str_replace('\\', '/', realpath(Yii::app()->getRuntimePath()));
        $file = $path . '/load_data_infile.txt';

        if (file_exists($file)){
            $sql = "load data infile '{$file}' ignore into table load_data_infile character set utf8 fields 
                    terminated by ',' enclosed by '\"' lines terminated by '\n' (`name`,`content`);";
            \D::pd($sql);
            $command = Yii::app()->db->createCommand($sql);
            $res = $command->execute();
            \D::pd($res);
        }else{
            \D::pd($file, file_exists($file), is_dir($path));
        }
    }
}