<?php

//namespace app\components\databuilder;

/**
 * Class ArrayBuilder
 * @package app\components\databuilder
 *
 * 构造多维数组 - 用这种数组方式，需要不断地写键名，也是不太方便，但这好像没法克服
 *
 *
 *
 *
 */

        // 通过对象的方式设置模板数据 - 虽然不用写键名，但是代码太多，看着不方便
        // 作为内部实现纯面向对象处理可以，但是作为自动化的数据协议格式没有数组方便
//        $tpl = [];
//
//        $c = Column::getInstance();
//        $c->name = 'title';
//        $c->type = Column::TYPE_STRING;
//
//        $tpl[] = $c;

// 示例
//$tpl = [
//    ['name'=>'title', 'type'=>'string'],
//    ['name'=>'status', 'type'=>'enum', 'value'=>'1,2,3'],
//
//    ['name'=>'sub', 'type'=>'array', 'tpl'=>[
//        ['name'=>'title', 'type'=>'string'],
//        ['name'=>'status', 'type'=>'enum', 'value'=>'1,2,3'],
//
//        ['name'=>'sub', 'type'=>'array', 'tpl'=>[
//            ['name'=>'title', 'type'=>'string'],
//            ['name'=>'status', 'type'=>'enum', 'value'=>'1,2,3'],
//
//            ['name'=>'sub', 'type'=>'array', 'tpl'=>[
//                ['name'=>'title', 'type'=>'string'],
//                ['name'=>'status', 'type'=>'enum', 'value'=>'1,2,3'],
//
//                ['name'=>'sub', 'type'=>'array', 'tpl'=>[
//                    ['name'=>'title', 'type'=>'string'],
//                    ['name'=>'status', 'type'=>'enum', 'value'=>'1,2,3'],
//                ]],
//            ]],
//        ]],
//    ]],
//];

class ArrayBuilder
{
    /**
     * 单个字段数据类型.
     */
    const TYPE_STRING = 1;
    const TYPE_INT = 2;
    const TYPE_FLOAT = 3;
    const TYPE_ENUM = 4;
    const TYPE_BOOL = 5;
    const TYPE_NULL = 6;

    /**
     * 多维数组元素返回格式.
     *
     * 会导致嵌套生成json格式问题.
     */
    const RETURN_TYPE_ARRAY = 1;
    const RETURN_TYPE_JSON = 2;

    /**
     * 多行
     * @param $tpl
     * @param int $count
     * @return array
     */
    public function makeData($tpl, $count=1)
    {
        $res = [];
        for ($i=0; $i<$count; $i++) {
            $res[] = $this->makeRowOnTpl($tpl);
        }
        return $res;
    }

    /**
     * 单行.
     * @param $tpl
     * @return array
     */
    public function makeRowOnTpl($tpl)
    {
        $res = [];
        foreach ($tpl as $row) {

            if (!isset($row['type'])) {
                exit('The type field is required.');
            }

            // 模板可以扩展更多自定义选项，例如中英文，名字年龄密码电话邮箱等具体格式内容，生成更加贴近现实的模拟记录

            switch ($row['type']) {
                case 'string':
                    $value = $this->makeString();
                    break;
                case 'int':
                    $value = $this->makeInt();
                    break;
                case 'float':
                    $value = $this->makeFloat();
                    break;
                case 'enum':
                    $value = $this->makeEnum($row['value']);
                    break;
                case 'array':
                    $value = $this->makeRowOnTpl($row['tpl']);
                    break;
                default:
                    exit('Dont supported type.');
            }

            $res[$row['name']] = $value;
        }
        return $res;
    }

    public function makeString($min=null, $max=null)
    {
        return md5(rand());
    }

    public function makeInt($min=null, $max=null)
    {
        return rand();
    }

    public function makeFloat($min=null, $max=null)
    {
        return (float)rand();
    }

    public function makeEnum($value)
    {
        $data = explode(',', $value);
        return $data[array_rand($data)];
    }
}
