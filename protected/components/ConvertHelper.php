<?php

/**
 * ConverHelper
 * @package application.components
 */
class ConvertHelper
{
    const CHOICE_JSON = 1;
    const CHOICE_ARRAY = 2;
    const CHOICE_LIKEARRAY = 3;
    const CHOICE_POSTMAN = 4;
    const CHOICE_LIST = 5;

    /**
     * Conver the given data base on the choice.
     *
     * Always convert the given string to the array data to keep the converting process simple.
     *
     * The order of the converting:
     *
     * json
     *   ->array
     *   ->likearray
     *   ->postman
     *   ->list
     *
     * array
     *   ->json
     *   ->likearray
     *   ->postman
     *   ->list
     *
     * likearray
     *   ->json
     *   ->array
     *   ->postman
     *   ->list
     *
     * postman
     *   ->json
     *   ->array
     *   ->likearray
     *   ->list
     *
     * list
     *   ->json
     *   ->array
     *   ->likearray
     *   ->postman
     *
     * @param $data
     * @return array
     * @throws Exception
     */
    public function convert($data)
    {
        $json = trim($data['json']);
        $array = trim($data['array']);
        $likearray = trim($data['likearray']);
        $postman = trim($data['postman']);
        $list = trim($data['list']);
        $choice = $data['choice'];

        switch ($choice) {
            case self::CHOICE_JSON:
                $array_data = $this->jsonToArrayData($json);
                $array      = $this->arrayDataToArray($array_data);
                $likearray  = $this->arrayDataToLikearray($array_data);
                $postman    = $this->arrayDataToPostman($array_data);
                $list       = $this->arrayDataToList($array_data);
                break;
            case self::CHOICE_ARRAY:
                $array_data = $this->arrayToArrayData($array);
                $json       = $this->arrayDataToJson($array_data);
                $likearray  = $this->arrayDataToLikearray($array_data);
                $postman    = $this->arrayDataToPostman($array_data);
                $list       = $this->arrayDataToList($array_data);
                break;
            case self::CHOICE_LIKEARRAY:
                $array_data = $this->likearrayToArrayData($likearray);
                $json       = $this->arrayDataToJson($array_data);
                $array      = $this->arrayDataToArray($array_data);
                $postman    = $this->arrayDataToPostman($array_data);
                $list       = $this->arrayDataToList($array_data);
                break;
            case self::CHOICE_POSTMAN:
                $array_data = $this->postmanToArrayData($postman);
                $json       = $this->arrayDataToJson($array_data);
                $array      = $this->arrayDataToArray($array_data);
                $likearray  = $this->arrayDataToLikearray($array_data);
                $list       = $this->arrayDataToList($array_data);
                break;
            case self::CHOICE_LIST:
                $array_data = $this->listToArrayData($list);
                $json       = $this->arrayDataToJson($array_data);
                $array      = $this->arrayDataToArray($array_data);
                $likearray  = $this->arrayDataToLikearray($array_data);
                $postman    = $this->arrayDataToPostman($array_data);
                break;
            default:
                throw new Exception('Choice is not supprted.');
        }

        return ['json'=>$json, 'array'=>$array, 'likearray'=>$likearray, 'postman'=>$postman, 'list'=>$list, 'choice'=>$choice];
    }

    /**
     * Convert a json string to an array.
     * @param string $string
     * @return array
     */
    public function jsonToArrayData($string)
    {
        return json_decode($string, true);
    }

    /**
     * Convert an array string to an array.
     * @param string $string
     * @return array
     */
    public function arrayToArrayData($string)
    {
        return \D::eval($string);
    }

    /**
     * Convert a likearray string to an array.
     * @param string $string
     * @return array
     */
    public function likearrayToArrayData($string)
    {
        $data = [];
        \D::unlikearray($string, $data);
        return $data;
    }

    /**
     * Convert a postman string to an array.
     * @param string $string
     * @return array
     */
    public function postmanToArrayData($string)
    {
        $data = [];
        \D::unpostman($string, $data);
        return $data;
    }

    /**
     * Convert a list string to an array.
     * @param string $string
     * @return array
     */
    public function listToArrayData($string)
    {
        $data = explode("\n", $string);

        foreach ($data as &$item)
        {
            $item = trim($item);
        }

        return $data;
    }

    /**
     * Convert an array to a json string.
     * @param array $array_data
     * @return string
     */
    public function arrayDataToJson($array_data)
    {
        return json_encode($array_data, JSON_UNESCAPED_UNICODE & JSON_UNESCAPED_SLASHES);
    }

    /**
     * Convert an array to an array string.
     * @param array $array_data
     * @return string
     */
    public function arrayDataToArray($array_data)
    {
        $res = CVarDumper::dumpAsString($array_data);
        $res = substr($res, 6);
        $res = substr($res, 0, -3);
        $res = '[' . $res . '];';
        return $res;
    }

    /**
     * Convert an array to a likearray string.
     * @param array $array_data
     * @return string
     */
    public function arrayDataToLikearray($array_data)
    {
        $res = '';
        \D::likearray($array_data, $res);
        return $res;
    }

    /**
     * Convert an array to a postman string.
     * @param array $array_data
     * @return string
     */
    public function arrayDataToPostman($array_data)
    {
        $res = '';
        \D::postman($array_data, $res);
        return $res;
    }

    /**
     * Convert an array to a postman string.
     * @param array $array_data
     * @return string
     */
    public function arrayDataToList($array_data)
    {
        $res = '';
        $res = implode("\n", $array_data);
        return $res;
    }
}