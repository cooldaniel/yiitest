<?php

/**
 * 站点列表生成器.
 *
 * 自动读取控制器的actionxxx方法，生成对应的url列表，并且可以根据路由标识为是否选中状态，
 * 这样，在渲染表单的时候，就可以根据这个标识和路由提交到后台生成选中配置.
 *
 * Class SiteListHelper
 */
class SiteListHelper
{
    /**
     * 获取站点url列表.
     * @param $checkedList
     * @return array
     */
    public function getSiteUrlList($checkedList)
    {
        $files = $this->getControllerFiles();
        $data = $this->getFunctionListFromFile($files);
        $this->formatFunctionList($data);
        $this->generateSiteUrlList($data, $checkedList);

        return $data;
    }

    /**
     * 获取控制器php文件.
     * @return array
     */
    public function getControllerFiles()
    {
        return CFileHelper::findFiles(Yii::app()->getControllerPath());
    }

    /**
     * 读取action方法列表，按文件名分组.
     * @param $files
     * @return array
     */
    public function getFunctionListFromFile($files)
    {
        $result = [];
        foreach ($files as $file) {

            // 文件名
            $name = pathinfo($file, PATHINFO_FILENAME);

            // action列表
            $content = file_get_contents($file);
            preg_match_all('/function action[A-Z][\w\d]+/', $content, $m);

            $result[$name] = $m[0];
        }
        return $result;
    }

    /**
     * 对分组列表格式化
     * @param $data
     */
    public function formatFunctionList(&$data)
    {
        foreach ($data as $name => $group) {

            // 去掉Controller后缀
            $nameNew = substr($name, 0, -10);

            // 去掉funcion action前缀
            foreach ($group as &$item) {
                $item = substr($item, 15);
            }

            // 用新名字索引
            $data[$nameNew] = $group;
            unset($data[$name]);
        }
    }

    /**
     * 生成站点url列表.
     * @param $data
     * @param $checkedList
     */
    public function generateSiteUrlList(&$data, $checkedList)
    {
        foreach ($data as $name => &$group) {
            foreach ($group as &$item) {
                $route = strtolower($name.'/'.$item);
                $item = [
                    'text'=>$item,
                    'url'=>Yii::app()->createUrl($route),
                    'checked'=>in_array($route, $checkedList),
                    'route'=>$route, // 路由信息用来标识一个url项
                ];
            }
        }
    }

    /**
     * 过滤未选中列表.
     * @param $data
     */
    public function filterUncheckedList(&$data)
    {
        foreach ($data as $name => &$group) {
            foreach ($group as $index => &$item) {

                // 未选中则删除
                if (!$item['checked']) {
                    unset($group[$index]);
                }
            }

            // 分组为空则删除
            if (!count($group)) {
                unset($data[$name]);
            }
        }
    }

    /**
     * 保存已选列表.
     * @param $checkedList
     */
    public function saveCheckedList($checkedList)
    {
        $content = '<?php $checkedList = ' . var_export($checkedList, true) . ';';
        file_put_contents($this->getcheckedListSaveFile(), $content);
    }

    /**
     * 获取已选列表.
     * @return array
     */
    public function getCheckedList()
    {
        $checkedList = [];

        $file = $this->getcheckedListSaveFile();
        if (file_exists($file)) {
            include $file;
        }

        return $checkedList;
    }

    /**
     * 已选列表保存的文件名.
     * @return string
     */
    public function getcheckedListSaveFile()
    {
        return Yii::app()->getRuntimePath() . '/siteurlcheckedlist.db';
    }
}