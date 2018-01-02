<?php

/**
 * 模拟数据构造器.
 *
 * 创建并执行自动化测试.
 *
 * 步骤：
 *  - 定义数据表.
 *  - 定义model.
 *  - 定义model的rules.
 *  - 获取model的字段名列表.
 *  - 获取model根据rules创建的验证器实例，并根据每个验证器实例的属性设置创建每个字段的正常和异常数据列表.
 *  - 根据上一步构造的每个字段的测试值列表，逐行构造错误数据行（有些行可能是正确的，例如string验证器总是会验证特殊字符，而允许特殊字符的字段不会报错）.
 *  - 验证上一步构造的每一个错误数据行.
 *  - 报告验证结果.
 *
 * 目的：
 *  - 执行测试并查看报告，检查测试数据是否包含了所有期望的情况.如果遗漏或者错误，则修改model的验证规则重新测试，如此迭代直到满意为止.
 *
 * @todo 目前的实现只针对单表的简单数据验证，特点是：
 *  - 假设所有表字段都会自动由Gii获取到model的rules()，而且和数据表一一对应.
 *  - 所有字段都是简单的类似number, string类型的字段，没有复合数据字段，例如内容是结构化的json数据.
 *  - 这里假设model对应的就是数据表操作，而不需要像对外接口那样可能要考虑字段映射问题.
 *
 * 后续可能的优化需求：
 *  - 某些字段是复合数据字段的单表处理.
 *  - 两个简单表的联合处理.
 *  - 提交的数据设计多个表，而且数据格式需要解析之后才能对应的接口提交数据处理.
 *  - 考虑字段映射的接口数据处理.
 *
 * 注意：
 *  - 可以考虑给构造器预留回调函数，独立具体的model和数据验证部分.
 *
 * @package application.controllers
 */
class DataBuilderController extends Controller
{
    public function actionIndex()
    {
        $model = new Country();

        // get attribute names
        $attributes = array_keys($model->getAttributes());
        \D::log($attributes);

        \D::log($model->rules());

        // build raw data on model rules
        $rawData = $this->buildRowData($model);
        \D::log($rawData);

        // build test data
        $data = $this->buildData($attributes, $rawData);
        \D::log($data);

        // validate
        $errors = $this->validate($model, $data);
        \D::log($errors);

        // report errors
        $this->reportErrors($model, $data, $errors);

        \D::log($model->getValidators());
    }

    // 通过model的验证规则生成每个字段的错误和正常值.
    public function buildRowData($model)
    {
        $res = [];

        foreach ($model->getValidators() as $validator) {
            $names = $validator->attributes;
            foreach ($names as $name) {

                // string validator
                if ($validator instanceof CStringValidator) {

                    // less than min length
                    if ($validator->min) {
                        $res[$name][] = str_repeat('a', $validator->min - 1);
                    }

                    // greater than max length
                    if ($validator->max) {
                        $res[$name][] = str_repeat('a', $validator->max + 1);
                    }

                    // has special char
                    $len = $validator->max ? $validator->max : 1;
                    $res[$name][] = $this->specialCharString($len);

                    // normal value
                    $res[$name]['normal'] = str_repeat('a', $len);
                }

                // number validator
                if ($validator instanceof CNumberValidator) {

                    // not a number
                    $res[$name][] = 'a';

                    // not an integer
                    if ($validator->integerOnly) {
                        $res[$name][] = 1.2;
                    }

                    // less than min value
                    if ($validator->min) {
                        $res[$name][] = $validator->min - 1;
                    }

                    // greater than max value
                    if ($validator->max) {
                        $res[$name][] = $validator->max + 1;
                    }

                    // normal value
                    $res[$name]['normal'] = $validator->min === null ? 1 : $validator->min;
                }
            }
        }

        return $res;
    }

    // 每一行只包括含一个错误
    public function buildData($attributes, $data)
    {
        $res = [];

        // build empty row as the first row
        $empty = [];
        foreach ($attributes as $attribute) {
            $empty[$attribute] = null;
        }
        $res[] = $empty;

        // collect the normal values as the template row
        $normal = [];
        foreach ($data as $name => $row) {
            $normal[$name] = $row['normal'];
            unset($row['normal']);
            $data[$name] = $row;
        }

        // build list
        foreach ($data as $name => $values) {
            foreach ($values as $value) {
                // always use the normal row as the row template
                $row = $normal;
                // override the value
                $row[$name] = $value;

                $res[] = $row;
            }
        }

        return $res;
    }

    // 一行包含多个错误
    public function buildData2($attributes, $data)
    {
        $res = [];

        // collect the normal values as the first row
        $normal = [];
        foreach ($data as $name => $row) {
            $normal[$name] = $row['normal'];
            unset($row['normal']);
            $data[$name] = $row;
        }
        $res[] = $normal;

        // build empty row as the second row
        $empty = [];
        foreach ($attributes as $attribute) {
            $empty[$attribute] = null;
        }
        $res[] = $empty;

        // max row number of the rest of the data
        $max = 0;
        foreach ($data as $row) {
            $count = count($row);
            if ($count > $max) {
                $max = $count;
            }
        }

        // build list
        for ($i=0; $i<$max; $i++) {

            // build row
            $row = [];
            foreach ($attributes as $attribute) {
                // get the value if exists or set as null
                if (array_key_exists($attribute, $data)) {
                    $value = array_pop($data[$attribute]);
                } else {
                    $value = null;
                }
                $row[$attribute] = $value;
            }

            $res[] = $row;
        }

        return $res;
    }

    public function specialCharString($len)
    {
        $chars = '~!@#$%^&*()-+={}[]:;"\'|\\<>,.?/';
        return substr($chars, 0, $len);
    }

    // 执行验证: 逐行验证
    public function validate($model, $data)
    {
        $errors = [];
        foreach ($data as $index => $row) {
            $model->setAttributes($row);
            if (!$model->validate()) {
                $errors[$index + 1] = $model->getErrors();
            }
        }
        return $errors;
    }

    // 错误报告, 默认是渲染页面
    public function reportErrors($model, $data, $errors)
    {
        foreach ($data as $index => $row) {
            $error = isset($errors[$index + 1]) ? $errors[$index + 1] : [];
            $row['errors'] = json_encode($error, JSON_UNESCAPED_UNICODE);
            $data[$index] = $row;
        }

        $this->render('index', ['model'=>$model, 'data'=>$data]);
    }
}


class DataPresentBase
{
    public function getData()
    {
        $res = [];

        $rawData = $this->getRawData();
        foreach ($rawData as $row) {
            $res[] = $this->buildRow($row);
        }

        return $res;
    }

    public function bulidRow($row)
    {

    }

    public function getRawData()
    {
        return [];
    }
}

class StockData extends DataPresentBase
{
    public function getRawData()
    {
        return [
            'code'=>[
                str_repeat('a', 60), // 长度超过2
                '##', // 特殊字符
            ],
            'name'=>[
                str_repeat('a', 60), // 长度超过52
                '#@$', // 特殊字符
            ],
            'population'=>[
                'a', // 不是整数
                1.2, // 不是整数
                -1, // 小于0
                0, // 等于0

            ],
        ];
    }
}