<?php

/**
 *
 * @package application.controllers
 */
class StructController extends Controller
{
    public $res;

    public function actionIndex()
    {
        $data = $this->cc(1, 5);
        D::pd($data);
    }

    public function cc($amount, $coins)
    {
        $item = [];

        $item['text'] = "cc $amount $coins";
        $item['offset_multi'] = $coins;

        $coins_next = $coins - 1;
        $amount_next = $amount - $this->coin($coins);
        if ($coins_next >= 0)
        {
            $item['left'] = $this->cc($amount, $coins_next);
        }
        if ($amount_next >= 0)
        {
            $item['right'] = $this->cc($amount_next, $coins);
        }

        return $item;
    }

    public function coin($coin)
    {
        $list = [1=>1, 2=>5, 3=>10, 4=>25, 5=>50];
        if ($coin > 0)
        {
            return $list[$coin];
        }
        else
        {
            return -1;
        }
    }

    public function actionAckermann()
    {
        $max = 6;
        for ($x=0; $x<=$max; $x++)
        {
            echo str_repeat($x, 50) . "\n";
            for ($y=0; $y<=$max; $y++)
            {
                $this->ackermann($x, $y);
                echo "\n";
            }
        }

        /*
        // 数据增长如下所示（左为x轴，上为y轴）
        // 以x轴为基点，做y轴变换
        x\y:0 1 2 3 4 5 6
         0: 0 2 4 6 8 10 12
         1: 0 2 4 8 16 32 64
         2: 0 2 4 16 65536 (A 1 65536) (A 1 (A 1 65536))
         3: 0 2 4 65536 (A 2 65536) (A 2 (A 2 65536)) (A 2 (A 2 (A 2 65536)))
         4: 0 2 4 (A 2 65536) (A 3 (A 2 65536)) (A 3 (A 3 (A 2 65536))) (A 3 (A 3 (A 3 (A 2 65536))))
         5: 0 2 4 (A 3 (A 2 65536)) (A 4 (A 3 (A 2 65536))) (A 4 (A 4 (A 3 (A 2 65536)))) (A 4 (A 4 (A 4 (A 3 (A 2 65536)))))
         6: 0 2 4 (A 4 (A 3 (A 2 65536))) (A 5 (A 4 (A 3 (A 2 65536)))) (A 5 (A 5 (A 4 (A 3 (A 2 65536))))) (A 5 (A 5 (A 5 (A 4 (A 3 (A 2 65536))))))
        */
    }

    public function ackermann($x, $y, $prefix='', $suffix='', $first=true)
    {
        // 初始运算时打印计算式
        if ($first)
        {
            echo "(A $x $y)\n";
            $first = false;
        }

        $end = false;
        if ($y == 0)
        {
            $num = 0;
            $end = true;
        }
        elseif ($y == 1)
        {
            $num = 2;
            $end = true;
        }
        elseif ($x == 0)
        {
            $num = 2 * $y;
            $end = true;
        }

        if ($end)
        {
            // 停止展开
            $str = $prefix . $num . $suffix . "\n";
            echo $str;
            return $num;
        }
        else
        {
            // 继续展开
            $x_next = $x - 1;
            $y_next = $y - 1;
            $prefix_new = $prefix . "(A {$x_next} ";
            $suffix_new = $suffix . ")";
            $str = $prefix_new . "(A {$x} {$y_next})" . $suffix_new . "\n";
            echo $str;

            // 调试：为了防止因为运行资源错误导致无法取得完整输出，对大于2^16的y不做递归.需要进一步测试时可删除该调试条件.
            if ($y > 65535)
            {
                return;
            }

            return $this->ackermann($x_next, $this->ackermann($x, $y_next, $prefix_new, $suffix_new, $first), $prefix, $suffix, $first);
        }
    }

    /**
     * 数组map/walk等测试.
     */
    public function actionMap()
    {
        // filter
        $data = range(1, 10);
        $filter = array_filter($data, function ($value){
            return ($value % 2) == 0;
        });
        D::pd($filter);

        // map - 平行应用于多个数组
        $data = range(1, 10);
        $map = array_map(function ($a, $b, $c){
            return $a + $b + $c;
        }, $data, $data, $data);
        D::pd($map);

        // map - 创建数组的数组
        $a = array(1, 2, 3, 4, 5);
        $b = array("one", "two", "three", "four", "five");
        $c = array("uno", "dos", "tres", "cuatro", "cinco");
        $map = array_map(null, $a, $b, $c);
        D::pd($map);

        // walk
        $data = range(1, 10);
        $walk = array_walk($data, function (&$value, $index, $factor){
            $value *= $factor;
        }, 3);
        D::pd($walk, $data);

        // walk recursive
        $data = [range(1, 10), [range(2, 5), [range(2, 5), 5]], 9];
        $walk = array_walk_recursive($data, function (&$value, $index, $factor){
            $value *= $factor;
        }, 3);
        D::pd($walk, $data);
    }

    public function actionArray()
    {
        // array column
        $data = [
            ['name'=>'material', 'value'=>'111'],
            ['name'=>'size', 'value'=>'222'],
        ];
        \D::pd(array_column($data, 'name'));
        \D::pd(array_column($data, 'value', 'name'));
        \D::pd(array_column($data, null, 'name'));
    }

    public function actionBigRequest()
    {
        $max = 100 * 10000;

        \D::beginProfile('100');
        $data = [
            ['name'=>'daniel', 'age'=>111],
            ['name'=>'tom', 'age'=>222],
        ];
        for ($i=0; $i<$max; $i++) {
            $this->bigRequestCall($data);
            //call_user_func([$this, 'bigRequestCall'], ['data'=>$data]);
        }
        \D::endProfile('100');
    }

    public function bigRequestCall($data)
    {
//        $names = ['name', 'age'];
//        foreach ($data as $index => $row){
////            $name = $row['name'];
////            $row['name'] = $name;
////            $age = $row['age'];
////            $row['age'] = $age;
//            foreach ($names as $name) {
//                $row[$name] = $row[$name];
//            }
//
//
//            $data[$index] = $row;
//        }
    }
}