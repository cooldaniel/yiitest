<?php
/**
 * cls_http_query类文件.
 * 
 * cls_http_query类用于发送http请求.
 * 
 * @author daniel
 * @date 2015/11/18
 */
class cls_http_query
{
    /**
     * @const string curl会话初始化失败.
     */
    const INIT_FAILED = 'curl init failed';
    /**
     * @const string curl查询执行失败.
     */
    const EXEC_FAILED = 'curl exec failed';
    /**
     * @const string 返回结果不是json.
     */
    const NOT_JSON = 'not json response';
    
    /**
     * 使用curl执行http查询.
     * @param string $url 查询url.
     * @param array $params 查询参数列表.
     * @param boolean $post 是否post请求，true表示是，false表示否.
     * @return mixed 错误时返回预定义常亮结果{@see self::INIT_FAILED/self::EXEC_FAILED/self::NOT_JSON},
     * 成功时返回结果数组.
     */
    public function curl_query($url, $params=array(), $post=false)
    {
        // 要求参数必须是数组格式
        if (!is_array($params))
        {
            exit('Error: The $params arguments must be an array.');
        }
        
        $ch = curl_init();
        if ($ch)
        {
            // 设置post请求
            if ($post)
            {
                curl_setopt($ch, CURLOPT_POST, 1);
            }
            
            // query params            
            $params_string = http_build_query($params);
            if ($post)
            {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
            }
            else
            {
                $url .= '?' . $params_string;
            }

            // set options
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            
            // exec and close
            $res = curl_exec($ch);

            //D::pd($params_string, $res, $post);
            if ($res)
            {
                $data = @json_decode($res, true);
                if (is_array($data))
                {
                    curl_close($ch);
                    return $data;
                }
                else
                {
                    $error_message = "cls_http_query::query() occured an error: \nError: " . self::NOT_JSON . "\nResponse: {$res}\nParams: " . 
                                      CVarDumper::dumpAsString(array('url'=>$url, 'params'=>$params, 'post'=>$post));
                    Yii::log($error_message, CLogger::LEVEL_ERROR, 'application.httpquery');
                    curl_close($ch);
                    return self::NOT_JSON;
                }
            }
            else
            {
                $error_message = "cls_http_query::query() occured an error: \nError: " . self::EXEC_FAILED . "\nParams: " . 
                                  CVarDumper::dumpAsString(array('url'=>$url, 'params'=>$params, 'post'=>$post, 'res'=>$res, 'curl_error'=>curl_error($ch)));
                Yii::log($error_message, CLogger::LEVEL_ERROR, 'application.httpquery');
                curl_close($ch);
                return self::EXEC_FAILED;
            }
        }
        else
        {
            $error_message = "cls_http_query::query() occured an error: \nError: " . self::INIT_FAILED . "\nParams: " . 
                              CVarDumper::dumpAsString(array('url'=>$url, 'params'=>$params, 'post'=>$post, 'ch'=>$ch));
            Yii::log($error_message, CLogger::LEVEL_ERROR, 'application.httpquery');
            return self::INIT_FAILED;
        }
    }
    
    /**
     * 使用fsockopen函数执行http查询.
     * @param string $url 查询url.
     * @param array $params 查询参数列表.
     * @return mixed 返回结果：
     *     0：fsockopen打开连接失败.
     *     array：查询成功，返回结果数组.
     */
    public function fsock_query($url, $params)
    {
        $row = parse_url($url);
        $host = $row['host'];
        $port = $row['port'] ? $row['port']:80;
        $file = $row['path'];
        $post = '';
        while (list($k,$v) = each($params))
        {
            $post .= rawurlencode($k)."=".rawurlencode($v)."&";
        }
        $post = substr( $post , 0 , -1 );
        $len = strlen($post);

        $fp = @fsockopen( $host ,$port, $errno, $errstr, 10);
        if (!$fp) {
            return 0;
        } else {
            $receive = '';
            $out = "POST $file HTTP/1.1\r\n";
            $out .= "Host: $host\r\n";
            $out .= "Content-type: application/x-www-form-urlencoded\r\n";
            $out .= "Connection: Close\r\n";
            $out .= "Content-Length: $len\r\n\r\n";
            $out .= $post;
            fwrite($fp, $out);
            while (!feof($fp))
            {
                $receive .= fgets($fp, 128);
            }
            fclose($fp);

            $receive = explode("\r\n\r\n",$receive);
            unset($receive[0]);

            return implode('', $receive);
        }
    }
}