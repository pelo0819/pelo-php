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
        if($params === false)
        {

        }

        $controller = $params['controller'];
        $action = $params['action'];

        $this->runAction($controller, $action, $params);

    }

    public function runAction($controller_name, $acton, $params = array())
    {
        // $controller_name の一番最初の文字を大文字にする
        $controller_class = ucfirst($controller_name). 'Controller';


    }

    protected function findController($controller_class)
    {
        
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