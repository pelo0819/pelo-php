<?php

// アプリケーションを管理するクラス
abstract class Application
{
    protected $debug = false;

    protected $router;
    protected $request;
    protected $response;
    
    public function __construct($debug = false)
    {

        $this->router = new Router($this->registerRoutes());
        $this->request = new Request();

    }

    protected function setDebugMode($debug)
    {

    }


    protected function initialize()
    {

    }

    protected function configure()
    {

    }

    // 一番大事な関数
    public function run()
    {
        $params = $this->router->resolve($this->request->getPathInfo());
    }

    abstract public function getRootDir();
    abstract protected function registerRoutes();

    public function isDebugMode()
    {

    }

    public function getRequest()
    {

    }

    public function getResponse()
    {

    }

    public function getControllerDir()
    {

    }

    public function getViewDir()
    {

    }

    public function getModelDir()
    {

    }

    public function getWebDir()
    {
        
    }

}