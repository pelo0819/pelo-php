<?php

class Router
{
    protected $routes;

    public function __construct($definition)
    {
        $this->routes = $this->complieRoutes($definition);
    }

    // Application.registerRoutes()で定義した
    // #route1
    // '/account' 
    //      => array('controller' => 'account', 'action' => 'index'),
    // #route2
    // '/account/:action' 
    //      => array('controller' => 'account'),
    // #route3
    // '/user/:user_name'
    //      => array('controller' => 'status', 'action' => 'user'),
    // #route4
    // '/user/:user_name/status/:id'
    //      => array('controller' => 'status', 'action' => 'show'),
    // が引数($definition)で入ってくる
    public function complieRoutes($definition)
    {
        $routes = array();

        foreach($definition as $url => $params)
        {
            // /で区切る 型はリスト
            $tokens = explode('/', ltrim($url, '/'));
            foreach($tokens as $i => $token)
            {
                if(0 === strpos($token, ':'))
                {
                    $name = substr($token, 1);
                    $token = '(?P<' . $name .'>[^/]+)';
                }
                $tokens[$i] = $token;
            }
            $pattern = '/' . implode('/', $tokens);
            $routes[$pattern] = $params;
        }
        // route1はそのまま、
        // route2は
        // '/account/(?P<action>[^/]+)' 
        //      => array('controller' => 'account')
        // になる
        return $routes;
    }

    // complieRoutes()のコメント箇所のroute4なら、
    // 引数: '/user/pelo/status/55'
    // 戻り値: array(
    //          controller => status,
    //          action     =>show,
    //          user_name  => pelo,     
    //          1          => pelo,
    //          id         => 5,
    //          2          => 5)
    public function resolve($path_info)
    {
        // $path_info の先頭が/でなければつける
        if('/' !== substr($path_info, 0, 1))
        {
            $path_info = '/' . $path_info;
        }

        foreach ($this->routes as $pattern => $params)
        {
            if(preg_match('#^'. $pattern . '$#', $path_info, $matches))
            {
                $params = array_merge($params, $matches);
                return $params;
            }   
        }
        return false;
    }
    
}