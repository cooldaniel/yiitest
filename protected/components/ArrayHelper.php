<?php

/**
 * 数组操作辅助方法.
 */
class ArrayHelper
{
    /**
     * 随机码允许字符：数字、小写字母、大写字母、大小写字母均可、数字字母均可
     */
    const RAND_SN_TYPE_NUMBER = 1;
    const RAND_SN_TYPE_LOWER = 2;
    const RAND_SN_TYPE_UPPER = 3;
    const RAND_SN_TYPE_LETTER = 4;
    const RAND_SN_TYPE_MISC = 5;

    /**
     * 获取列表行某个字段名对应的值.
     * @param array $list 数据行，每行都含有$field字段名.
     * @param string $field 字段名.
     * @param bool $filterEmpty true表示过滤掉空字符串项，false表示不过滤，默认是false.
     * @param bool $unique true表示对结果去重，false表示不去重，默认是true.
     * @return array 返回字段值数组，找不到对应字段名就返回空数组.
     */
    public static function getListRowField($list, $field, $filterEmpty=false, $unique=true)
    {
        $res = [];
        // 不使用isset($list[0][$field])判断，因为$list可能是关联数组
        if (is_array($list) && count($list)){
            $first = pos($list);
            if (is_array($first) && array_key_exists($field, $first)){
                foreach ($list as $row){
                    $value = trim($row[$field]);
                    if ($value != '' || !$filterEmpty){
                        $res[] = $value;
                    }
                }
                if ($unique){
                    $res = array_unique($res);
                }
            }
        }
        return $res;
    }

    /**
     * 从列表获取某个字段等于指定值的行.
     * @param $list 列表.
     * @param $field 字段名，找到这个字段名，再比对$value.
     * @param $value $field字段需要匹配的值.
     * @return array|mixed 返回$list中$field字段值等于$value的行.找不到就返回空数组.
     */
    public static function getRowFromListByField($list, $field, $value)
    {
        $res = [];
        // 不使用isset($list[0][$field])判断，因为$list可能是关联数组
        if (is_array($list) && count($list)){
            $first = pos($list);
            if (isset($first[$field])){
                foreach ($list as $row){
                    if (strcmp(trim($row[$field]), trim($value)) == 0){
                        $res = $row;
                        break;
                    }
                }
            }
        }
        return $res;
    }

    /**
     * 给数组附加一列.
     * @param $field 键名.
     * @param $value 键值数组，$data有多少行，就应该有多少个值.
     * @param $data 目标数组.
     * @return mixed
     * @throws \Exception
     */
    public static function appendField($field, $value, $data)
    {
        if (count($value) != count($data)){
            throw new \Exception('参数2的个数必须和参数2的个数相等');
        }

        foreach ($data as $index => &$row){
            $row[$field] = $value[$index];
        }

        return $data;
    }

    /**
     * 以第一个元素为key，第二个元素为value，将列表行转为"key=>value"数组.
     * @param $list 列表行.
     * @return array
     */
    public static function wrapListRowAsLine($list)
    {
        $res = [];
        if (is_array($list) && count($list)){
            foreach ($list as $row){
                $key = pos($row);
                $value = next($row);
                $res[$key] = $value;
            }
        }
        return $res;
    }

    /**
     * 验证是否整数或整数列表.
     * @param $list 整数、整数数组或者用逗号分隔的整数字符串.
     * @return bool
     */
    public static function validateIntList($list)
    {
        if (!is_array($list)){
            $list = explode(',', $list);
        }
        $intPattern = '/^\s*[+-]?\d+\s*$/';
        $foundInvalidItem = false;
        foreach ($list as $id){
            if (!preg_match($intPattern, $id)){
                $foundInvalidItem = true;
                break;
            }
        }
        return !$foundInvalidItem;
    }

    /**
     * 验证元素是否在列表中.
     * @param $id 元素.
     * @param $list 列表.
     * @return bool
     */
    public static function validateInsideList($id, $list)
    {
        if (!is_array($list)){
            $list = explode(',', $list);
        }
        return in_array($id, $list);
    }

    /**
     * 过滤文本多维数组的NULL或者空字符串项.
     * @param $data 文本多维数组.
     * @param $filter_null true表示过滤掉值为NULL的项，false表示不过滤，默认是false.
     * @return array 返回过滤后的数组.
     */
    public static function filterEmptyRow($data, $filter_null=false)
    {
        if (is_array($data) && count($data)){
            foreach ($data as $index => $row){
                if (is_array($row)){
                    $data[$index] = self::filterEmptyRow($row, $filter_null);
                    continue;
                }

                if (is_string($row) && trim($row) === ''){
                    unset($data[$index]);
                }

                if ($filter_null && $row === null){
                    unset($data[$index]);
                }
            }
        }
        return $data;
    }

    /**
     * 验证数组是否符合指定维数.
     * @param $data 数组.
     * @param int $dimension 维数，必须是大于0的整数.默认是1.
     * @param bool $allow_object true表示允许数组元素是对象，false表示不允许，默认是false.
     * @return bool 返回true表示符合，false表示不符合.
     */
    public static function validateArrayDimension($data, $dimension=1, $allow_object=false)
    {
        if (!is_int($dimension) || $dimension < 0){
            return false;
        }

        if (is_array($data)){

            // 如果数组为空，则只能是一维数组
            if (count($data) == 0){
                return $dimension == 1;
            }

            // 非空数组校验
            foreach ($data as $item){
                if ($dimension == 1){
                    // 不应该是数组
                    if (is_array($item)){
                        return false;
                    }

                    // 是否允许数组元素是对象
                    if (is_object($item) && !$allow_object){
                        return false;
                    }
                }else{
                    // 应该是数组
                    if (!is_array($item)){
                        return false;
                    }else{
                        // 下一维验证错误
                        $next = self::validateArrayDimension($item, $dimension - 1, $allow_object);
                        if ($next === false){
                            return false;
                        }
                    }
                }
            }

            return true;
        }else{
            return false;
        }
    }

    /**
     * 生成迭代矩阵二维数组.
     * @param $data 原始二维数组
     * @return mixed 返回矩阵二维数组
     * @throws \Exception $data参数必须是二维数组，否则抛出异常.
     */
    public static function matrix($data, $keys=[])
    {
        if (!self::validateArrayDimension($data, 2)){
            throw new \Exception('参数1必须是二维数组');
        }

        if (!self::validateArrayDimension($keys)){
            throw new \Exception('参数2必须是一维数组');
        }

        // 默认使用$data的键名
        if (count($keys) == 0){
            $keys = array_keys($data);
        }

        // 给定的键名和实际数据必须相等（上一步初始化后要重新计数）
        if (count($keys) != count($data)){
            throw new \Exception('参数1的元素个数必须和参数2的元素个数相等');
        }

        self::matrixIterate($res, $data, $keys);
        return $res;
    }

    /**
     * 迭代生成矩阵二维数组时使用的字符串拼接和分割分隔符.
     * @var string
     */
    public static $matrixSeparator = '{{#}}';

    /**
     * 迭代生成矩阵二维数组.
     * @param $res 保存结果的数组.
     * @param $data 原始二维数组.
     * @param array $keys 给结果二维数组的一维数组分配的键值.
     */
    public static function matrixIterate(&$res, $data, $keys=[])
    {
        $count = count($data);
        $count_res = count($res);

        if ($count_res > 0 && $count == 0){
            // $res不为空表示$data至少两项而且已处理，当$count为0时，表示迭代结束
            // 迭代结束后拆成数组方式
            foreach ($res as &$item){
                foreach ($item as &$text){
                    $values = explode(self::$matrixSeparator, $text);
                    $text = array_combine($keys, $values);
                }
            }
            $res = pos($res);
        }elseif ($count_res == 0 && ($count == 0 || $count == 1)){
            // $res为空且$data少于两项时，直接返回原数组
            $res = $data;
        }else{
            // 迭代矩阵
            if ($count_res == 0){
                // 开始时从$data取第一项
                $first = array_shift($data);
            }else{
                // 后续将$res做第一项
                $first =array_shift($res);
            }
            // 总是从$data取第二项
            $second = array_shift($data);

            $d = [];
            if (count($first) && count($second)){
                // 第一项和第二项都不为空，构造矩阵
                foreach ($first as $v1) {
                    foreach ($second as $v2){
                        $d[] = $v1.self::$matrixSeparator.$v2;
                    }
                }
            }else{
                // 第一项或第二项为空，直接返回不为空的数组
                if (count($first)){
                    $d = $first;
                }else{
                    $d = $second;
                }
            }
            $res[] = $d;

            // next
            self::matrixIterate($res, $data, $keys);
        }
    }

    /**
     * 生成INSERT类型SQL.
     * @param $data 二维数组.
     * @param $table 数据表名字.
     * @return string 返回生成的SQL.
     * @throws \Exception 参数不合法时抛出异常.
     */
    public static function createInsertSql($data, $table)
    {
        if (!self::validateArrayDimension($data, 2)){
            throw new \Exception('参数1必须是二维数组');
        }

        $columns = array_keys(pos($data));
        $columns_list = '`' . implode('`,`', $columns) . '`';
        $sql = 'INSERT INTO `'.$table.'`('.$columns_list.') VALUES'."\n";
        foreach ($data as $row){
            $sql .= "('" . implode("','", $row) . "'),\n";
        }
        $sql = rtrim($sql, ",\n");
        $sql .= ';';
        return $sql;
    }

    /**
     * 生成随机码列表.
     * @param $count 期望个数.
     * @param int $length 随机码长度，必须大于$prefix字符个数.
     * @param int $type 随机码允许的字符类别.
     * @param string $prefix 随机码前缀，默认是空字符串.
     * @return array 返回一维数组，每个数组元素是一个随机码.
     * @throws \Exception 无法生成$count个随机码时抛出异常.
     */
    public static function createRandSnList($count, $length=1, $type=self::RAND_SN_TYPE_NUMBER, $prefix='')
    {
        $res = [];

        // 最大尝试次
        $max_try = $count * 2;

        $try = 1;
        for ($i=0; $i<$count; $i++){
            $sn = self::createRandSn($length, $type, $prefix);

            if (array_search($sn, $res) !== false){
                // 重复则恢复计数器重新生成
                $i--;
            }else{
                $res[] = $sn;
            }

            // 超过最大尝试次数则退出
            if ($try >= $max_try){
                break;
            }
            $try++;
        }

        if (count($res) != $count){
            throw new \Exception('无法生成指定数量的随机编码列表，请重试');
        }

        return $res;
    }

    public static function createRandSnListByMicrotime($count, $length=1, $prefix='')
    {
        $prefix_len = strlen($prefix);

        if ($length <= $prefix_len){
            throw new \Exception('参数2必须大于参数1的字符个数');
        }

        // 修正需要的字符长度
        $length = $length - $prefix_len;

        $res = [];
        for ($i=0; $i<$count; $i++){
            $time = microtime(true);
            $time = str_replace('.', '', $time);
            $time = substr($time, -$length);
            $time = str_shuffle($time);
            $time = $prefix.$time;
            $res[] = $time;

            usleep(1);
        }
        $res = array_unique($res);

        if (count($res) != $count){
            throw new \Exception('无法生成指定数量的随机编码列表，请重试');
        }

        return $res;

    }

    /**
     * @param int $length 随机码长度，必须大于$prefix字符个数.
     * @param int $type 随机码允许的字符类别.
     * @param string $prefix 随机码前缀，默认是空字符串.
     * @return string 返回随机码字符串.
     * @throws \Exception 参数不合法时抛出异常.
     */
    public static function createRandSn($length=1, $type=self::RAND_SN_TYPE_NUMBER, $prefix='')
    {
        $prefix_len = count($prefix);

        if ($length <= $prefix_len){
            throw new \Exception('参数2必须大于参数1的字符个数');
        }

        // 修正需要的字符长度
        $length = $length - $prefix_len;

        switch ($type){
            case self::RAND_SN_TYPE_NUMBER:
                $data = range(0, 9);
                break;
            case self::RAND_SN_TYPE_LOWER:
                $data = range('a', 'z');
                break;
            case self::RAND_SN_TYPE_UPPER:
                $data = range('A', 'Z');
                break;
            case self::RAND_SN_TYPE_LETTER:
                $data = array_merge(range('a', 'z'), range('A', 'Z'));
                break;
            case self::RAND_SN_TYPE_MISC:
                $data = array_merge(range('a', 'z'), range('A', 'Z'), range(0, 9));
                break;
            default:
                throw new \Exception('参数2不合法');
                break;
        }

        shuffle($data);
        shuffle($data);
        shuffle($data);

        $text = '';
        for ($i=0; $i<$length; $i++){
            $index = array_rand($data);
            $text .= $data[$index];
        }

        return $prefix . $text;
    }

    /**
     * 替换数组的键名.
     * @param $data 数据数组.
     * @param $key_map 键名映射一维数组，它的元素键名是在$data中的键名，键值则是期望将$data中的对应键名改成该值.
     * @param $strict true表示在$data中找不到$key_map中指定的键名时抛出异常，false表示忽略，默认是false.
     * @throws \Exception
     */
    public static function replaceKeys(&$data, $key_map, $strict=false)
    {
        if (!is_array($data) || !is_array($key_map)){
            throw new \Exception('参数1，参数2，都必须是数组');
        }

        if (count($key_map) && count($data)){
            foreach ($key_map as $from => $to){
                if (strcmp($from, $to) != 0 && array_key_exists($from, $data)){
                    $data[$to] = $data[$from];
                    unset($data[$from]);
                } elseif ($strict){
                    throw new \Exception('在参数1数组中，找不到参数2数组指定的键名'.$from, 10000);
                }
            }

            foreach ($data as &$item){
                if (is_array($item)){
                    self::replaceKeys($item, $key_map, $strict);
                }
            }
        }
    }

    /**
     * 拼接参数并返回
     * @return string
     */
    public static function joinValue()
    {
        $args = func_get_args();
        $args = ArrayHelper::filterEmptyRow($args);
        return implode(',', $args);
    }

    /**
     * 获取两个日期之间的所有日期.
     * @param $start
     * @param $end
     * @param $interval
     * @return array
     */
    public static function getBetweenDaysInterval($start, $end, $interval=1)
    {
        $start_timestamp = strtotime($start);
        $end_timestamp = strtotime($end);

        if (!is_int($interval) || $interval <= 0)
        {
            trigger_error('参数$interval必须是正整数.');
        }

        $interval_timestamp = $interval * 60 * 60 * 24;
        if ($start_timestamp + $interval_timestamp > $end_timestamp)
        {
            trigger_error('参数$start加上$interval不能超过$end参数');
        }

        $res = [];
        while ($start_timestamp <= $end_timestamp)
        {
            $res[] = date('Y-m-d', $start_timestamp);
            $start_timestamp = $start_timestamp + $interval_timestamp;
        }

        return $res;
    }
}