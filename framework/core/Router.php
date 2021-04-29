<?php

class Router
{
    protected $routes;

    public function __construct($definition)
    {
        $this->routes = $this->complieRoutes($definition);
    }


    public function complieRoutes($definition)
    {

    }


    public function resolve($path_info)
    {

    }
    
}