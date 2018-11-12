<?php

/**
 *
 * @package application.controllers
 */
class AppController extends Controller
{
    const SEX_MAN = 0;
    const SEX_WOMAN = 1;

    public function actionIndex()
    {
        $time = time() - 24*3600*30;

        // 数据

        $class = [
            ['id'=>1, 'name'=>'', 'description'=>'', 'brief'=>'', 'created_at'=>$time, 'updated_at'=>$time],
            ['id'=>2, 'name'=>'', 'description'=>'', 'brief'=>'', 'created_at'=>$time, 'updated_at'=>$time],
        ];

        // 教师
        $teacher = [
            ['id'=>1, 'username'=>'Daniel', 'sex'=>self::SEX_MAN, 'description'=>'', 'brief'=>'擅长舞蹈，音乐'],
            ['id'=>2, 'username'=>'Tom', 'sex'=>self::SEX_MAN, 'description'=>'', 'brief'=>'擅长数学，计算机'],
            ['id'=>3, 'username'=>'Jone', 'sex'=>self::SEX_MAN, 'description'=>'', 'brief'=>'擅长绘画，艺术设计，书法'],
            ['id'=>4, 'username'=>'Lucy', 'sex'=>self::SEX_WOMAN, 'description'=>'', 'brief'=>'擅长绘画，艺术设计，书法'],
            ['id'=>5, 'username'=>'Jacky', 'sex'=>self::SEX_MAN, 'description'=>'', 'brief'=>'擅长舞蹈，音乐'],
            ['id'=>6, 'username'=>'Amy', 'sex'=>self::SEX_WOMAN, 'description'=>'', 'brief'=>'擅长数学，计算机'],
            ['id'=>7, 'username'=>'Nancy', 'sex'=>self::SEX_WOMAN, 'description'=>'', 'brief'=>'擅长数学，计算机'],
            ['id'=>8, 'username'=>'Sophia', 'sex'=>self::SEX_WOMAN, 'description'=>'', 'brief'=>'擅长舞蹈，音乐'],
            ['id'=>9, 'username'=>'Lily', 'sex'=>self::SEX_WOMAN, 'description'=>'', 'brief'=>'擅长绘画，艺术设计，书法'],
        ];

        // 班级
        $class = [
            ['id'=>1, 'name'=>'小1', 'master_id'=>'1', 'created_at'=>$time, 'updated_at'=>$time],
            ['id'=>2, 'name'=>'小2', 'master_id'=>'2', 'created_at'=>$time, 'updated_at'=>$time],
            ['id'=>3, 'name'=>'小3', 'master_id'=>'3', 'created_at'=>$time, 'updated_at'=>$time],
            ['id'=>4, 'name'=>'中1', 'master_id'=>'4', 'created_at'=>$time, 'updated_at'=>$time],
            ['id'=>5, 'name'=>'中2', 'master_id'=>'5', 'created_at'=>$time, 'updated_at'=>$time],
            ['id'=>6, 'name'=>'中3', 'master_id'=>'6', 'created_at'=>$time, 'updated_at'=>$time],
            ['id'=>7, 'name'=>'大1', 'master_id'=>'7', 'created_at'=>$time, 'updated_at'=>$time],
            ['id'=>8, 'name'=>'大2', 'master_id'=>'8', 'created_at'=>$time, 'updated_at'=>$time],
            ['id'=>9, 'name'=>'大3', 'master_id'=>'9', 'created_at'=>$time, 'updated_at'=>$time],
        ];

        // 家长
        $parent = [
            ['id'=>1, 'username'=>'李易峰', 'sex'=>self::SEX_MAN, 'password'=>md5('123456'), 'nickname'=>'小峰', 'mobile'=>'13800138000', 'phone'=>'0755-12345678', 'email'=>'xiaofeng@qq.com', 'description'=>'', 'brief'=>'', 'created_at'=>$time, 'updated_at'=>$time],
            ['id'=>2, 'username'=>'宋仲基', 'sex'=>self::SEX_MAN, 'password'=>md5('123456'), 'nickname'=>'小宋', 'mobile'=>'13800138001', 'phone'=>'0755-00000000', 'email'=>'songsong@qq.com', 'description'=>'', 'brief'=>'', 'created_at'=>$time, 'updated_at'=>$time],
        ];

        // 宝贝
        $student = [
            ['id'=>1, 'parent_id'=>1, 'class_id'=>1, 'sex'=>self::SEX_WOMAN, 'username'=>'李小丽', 'nickname'=>'小小丽', 'description'=>'', 'brief'=>'喜爱跳舞，音乐', 'slogon'=>'舞动人生', 'created_at'=>$time, 'updated_at'=>$time],
            ['id'=>2, 'parent_id'=>1, 'class_id'=>2, 'sex'=>self::SEX_MAN, 'username'=>'李小峰', 'nickname'=>'小小峰', 'description'=>'', 'brief'=>'喜爱书法，绘画', 'slogon'=>'书画世界', 'created_at'=>$time, 'updated_at'=>$time],
        ];

        // 课程
        $lesson = [
            ['id'=>1, 'name'=>'肚皮舞', 'description'=>'', 'brief'=>'', 'created_at'=>$time, 'updated_at'=>$time],
            ['id'=>2, 'name'=>'街舞', 'description'=>'', 'brief'=>'', 'created_at'=>$time, 'updated_at'=>$time],
            ['id'=>3, 'name'=>'彝族舞', 'description'=>'', 'brief'=>'', 'created_at'=>$time, 'updated_at'=>$time],
            ['id'=>4, 'name'=>'蒙古舞', 'description'=>'', 'brief'=>'', 'created_at'=>$time, 'updated_at'=>$time],
            ['id'=>5, 'name'=>'国画-山水画', 'description'=>'', 'brief'=>'', 'created_at'=>$time, 'updated_at'=>$time],
            ['id'=>6, 'name'=>'国画-人物画', 'description'=>'', 'brief'=>'', 'created_at'=>$time, 'updated_at'=>$time],
            ['id'=>7, 'name'=>'素描', 'description'=>'', 'brief'=>'', 'created_at'=>$time, 'updated_at'=>$time],
            ['id'=>8, 'name'=>'水彩', 'description'=>'', 'brief'=>'', 'created_at'=>$time, 'updated_at'=>$time],
            ['id'=>9, 'name'=>'数学', 'description'=>'', 'brief'=>'', 'created_at'=>$time, 'updated_at'=>$time],
            ['id'=>10, 'name'=>'计算机', 'description'=>'', 'brief'=>'', 'created_at'=>$time, 'updated_at'=>$time],
            ['id'=>11, 'name'=>'艺术设计', 'description'=>'', 'brief'=>'', 'created_at'=>$time, 'updated_at'=>$time],
        ];

        // 学习
        $study = [
            ['student_id'=>1, 'lesson_id'=>1, 'apply_status'=>0, 'created_at'=>$time, 'passed_at'=>''],
            ['student_id'=>1, 'lesson_id'=>2, 'apply_status'=>1, 'created_at'=>$time, 'passed_at'=>$time+24*3600],
            ['student_id'=>1, 'lesson_id'=>3, 'apply_status'=>1, 'created_at'=>$time, 'passed_at'=>$time+24*3600],
            ['student_id'=>1, 'lesson_id'=>4, 'apply_status'=>0, 'created_at'=>$time, 'passed_at'=>''],

            ['student_id'=>1, 'lesson_id'=>5, 'apply_status'=>0, 'created_at'=>$time, 'passed_at'=>''],
            ['student_id'=>1, 'lesson_id'=>6, 'apply_status'=>1, 'created_at'=>$time, 'passed_at'=>$time+24*3600],
            ['student_id'=>1, 'lesson_id'=>7, 'apply_status'=>1, 'created_at'=>$time, 'passed_at'=>$time+24*3600],
            ['student_id'=>1, 'lesson_id'=>8, 'apply_status'=>0, 'created_at'=>$time, 'passed_at'=>''],
        ];

        // 授课
        $teach = [
            ['teacher_id'=>1, 'lesson_id'=>1],
            ['teacher_id'=>1, 'lesson_id'=>2],
            ['teacher_id'=>1, 'lesson_id'=>3],

            ['teacher_id'=>2, 'lesson_id'=>9],
            ['teacher_id'=>2, 'lesson_id'=>10],

            ['teacher_id'=>3, 'lesson_id'=>5],
            ['teacher_id'=>3, 'lesson_id'=>6],
            ['teacher_id'=>3, 'lesson_id'=>7],
            ['teacher_id'=>3, 'lesson_id'=>11],

            ['teacher_id'=>4, 'lesson_id'=>1],
            ['teacher_id'=>4, 'lesson_id'=>2],
            ['teacher_id'=>4, 'lesson_id'=>3],
            ['teacher_id'=>4, 'lesson_id'=>11],

            ['teacher_id'=>5, 'lesson_id'=>1],
            ['teacher_id'=>5, 'lesson_id'=>2],
            ['teacher_id'=>5, 'lesson_id'=>3],

            ['teacher_id'=>6, 'lesson_id'=>5],
            ['teacher_id'=>6, 'lesson_id'=>6],
            ['teacher_id'=>6, 'lesson_id'=>7],

            ['teacher_id'=>7, 'lesson_id'=>5],
            ['teacher_id'=>7, 'lesson_id'=>6],
            ['teacher_id'=>7, 'lesson_id'=>7],

            ['teacher_id'=>8, 'lesson_id'=>9],
            ['teacher_id'=>8, 'lesson_id'=>10],

            ['teacher_id'=>9, 'lesson_id'=>1],
            ['teacher_id'=>9, 'lesson_id'=>2],
            ['teacher_id'=>9, 'lesson_id'=>3],
            ['teacher_id'=>9, 'lesson_id'=>11],
        ];

        // 构造sql



        $sql = '';

        $table = ['study', 'teach', 'student', 'class', 'lesson', 'teacher', 'parent'];
        foreach ($table as $name) {
//            $sql .= "TRUNCATE TABLE {$name};\n";
            $sql .= "DELETE FROM {$name};\n";
        }


        $table = ['teacher', 'class', 'parent', 'student', 'lesson', 'study', 'teach', ];
        foreach ($table as $name) {
            $sql .= "\n\n";
            $sql .= $this->createAddListSql($name, $$name, true, true);
            $sql .= "\n\n";
        }

        $sql = nl2br($sql);
        echo $sql;
    }

    public function createAddListSql($table, $data, $break=false, $stop=false)
    {
        $columns = array_keys(reset($data));
        $sql = 'INSERT INTO `' . $table . '`(`' . implode('`,`', $columns) . '`) VALUES ';

        if ($break) {
            $sql .= "\n";
        }

        foreach ($data as $row){
            $sql .= "(";
            foreach ($row as $value){
                if (is_int($value) || is_float($value)){
                    $sql .= "{$value}";
                }elseif($value === null){
                    $sql .= 'NULL';
                }else{
                    $sql .= "'{$value}'";
                }
                $sql .= ",";

            }
            $sql = rtrim($sql, ',');
            $sql .= "),";

            if ($break) {
                $sql .= "\n";
            }
        }
        $sql = rtrim($sql, ",\n");

        if ($stop) {
            $sql .= ";";
        }

        return $sql;
    }
}