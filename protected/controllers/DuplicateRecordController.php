<?php

/**
 * 模拟重复记录添加、更新、监控等.
 *
 * 结论：
 *
 * 测试用例：>ab -n 100 -c 100 http://yiitest.local/?r=duplicateRecord/index
 *
 * 唯一索引解决了重复问题，但是好像还有其它问题.
 *
 * @package application.controllers
 */
class DuplicateRecordController extends Controller
{
    public function actionIndex()
    {
        \D::noclean();
        $this->import();
        \D::pd('done');
    }

    public function import()
    {
        // 构造数据
        $data_list = $this->getDataList();

        // 相比在循环内记录单行的情况，这里的数据行顺序才是正确的，但是，因为线程切换问题，先来的请求不一定比后来的请求先生成数据
        // 但是不管怎样，因为线程之间数据的独立性，这里的数据总是能够得到保证的.
//        \D::log($data_list);

        // 执行批量操作
        $transaction = Yii::app()->db->beginTransaction();
        try{

            foreach ($data_list as $data) {

                // 这里获取的进程ID，如果是httpd使用模块方式调用php，则该进程ID就是httpd的进程
                // 由于httpd线程切换的原因，这里记录的$data顺序可能是多个线程之间交叉的情况.
//                \D::log(array('pid'=>getmypid(), 'data'=>$data));

                $model = new DuplicateRecord();

                $old = $model->findByAttributes(['title'=>$data['title']]);
                if (!$old) {
                    $data['remark'] = 'add';
                    $data['created'] = time();
                    $model->setAttributes($data);
                    $model->save();
                } else {
                    $old->content = $data['content'];
                    $old->remark = '' . ' update';
                    $old->modified = time();
                    $old->save();
                }
            }

            $transaction->commit();

        } catch (\Exception $e) {
            $transaction->rollback();
        }
    }

    public function getDataList()
    {
        $res = [];
        $range = range(1, 10);
        foreach ($range as $num) {
            $title = 'title_'.$num;
            $res[] = [
                'title'=>$title,
                'content'=>rand(),
            ];
        }
        return $res;
    }
}