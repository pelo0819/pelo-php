<?php

class Request
{
    public function getRequestUri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    // ベースURLを取得する
    // http://192.168.2.2/test/index.php/ppp だったら
    // /test/index.phpがベースURL
    public function getBaseUrl()
    {
        // /test/index.php
        $script_name = $_SERVER['SCRIPT_NAME'];
        
        // /test/index.php/ppp
        $request_uri = $this->getRequestUri();

        // /test
        $dir_name = dirname($script_name);

        if(0 === strpos($request_uri, $script_name))
        {
            return $script_name;
        }
        else if(0 === strpos($request_uri, $dir_name))
        {
            return rtrim($dir_name, '/');
        }

        return '';
    }

    // パスinfoを取得する関数
    // http://192.168.2.2/test/yada/index.php/ppp だったら
    // /pppがパスinfo
    public function getPathInfo()
    {
        $base_url = $this->getBaseUrl();
        $request_uri = $this->getRequestUri();

        if(false !== ($pos = strpos($request_uri, '?')))
        {
            $request_uri = substr($request_uri, 0, $pos);
        }

        $path_info = (string)substr($request_uri, strlen($base_url));
        return $path_info;
    }
}