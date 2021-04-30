<?php

class Router
{
    protected $routes;

    public function __construct($definition)
    {
        $this->routes = $this->complieRoutes($definition);
    }

    // '/account' 
    //      => array('controller' => 'account', 'action' => 'index'),
    // '/account/:action' 
    //      => array('controller' => 'account')
    // が引数($definition)で入っている
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

        return $routes;
    }


    public function resolve($path_info)
    {

    }
    
}