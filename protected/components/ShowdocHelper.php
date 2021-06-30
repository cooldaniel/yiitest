<?php

/**
 * ShowdocHelper
 * @package application.components
 */
class ShowdocHelper
{
    /**
     * Conver the given data base on the choice.
     *
     * Always convert the given string to the array data to keep the converting process simple.
     *
     * @param $data
     * @return array
     * @throws Exception
     */
    public function run($data)
    {
        // 输入各种格式数据
        $request = trim($data['request']);
        $response = trim($data['response']);

        // 统一转成数组
        $requestDoc = D::apidocRequest($request);
        $responseDoc = D::apidocResponse($response);

        return [
            'request' => $request,
            'response' => $response,
            'requestDoc' => $requestDoc,
            'responseDoc' => $responseDoc,
        ];
    }
}