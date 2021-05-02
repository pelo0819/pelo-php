<?php

// アプリケーションを管理するクラス
abstract class Application
{
    protected $is_debug = false;

    protected $router;
    protected $request;
    protected $response;
    protected $session;
    
    public function __construct($is_debug = false)
    {
        $this->is_debug = $is_debug;
        $this->setDebugMode($is_debug);
        $this->initialize();
    }

    protected function setDebugMode($is_debug)
    {
        if($is_debug)
        {
            $this->is_debug = true;
            ini_set('display_errors', 1);
            error_reporting(-1);
        }
        else
        {
            $this->is_debug = false;
            ini_set('display_errors', 0);
        }
    }


    protected function initialize()
    {
        $this->router = new Router($this->registerRoutes());
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();

        $this->log();
    }

    protected function configure(){}

    // 一番大事な関数
    // リクエスト(URL)から解析したcontrollerとactionに応じたメソッドを呼び出し、レスポンスを返す
    public function run()
    {
        try
        {
            $params = $this->router->resolve($this->request->getPathInfo());
            if($params === false)
            {
                throw new HttpNotFoundException('No route found for ' . $this->request->getPathInfo());
            }

            $controller = $params['controller'];
            $action = $params['action'];

            $this->runAction($controller, $action, $params);


        }
        catch(HttpNotFoundException $e)
        {
            $this->render404Page($e);
        }

        $this->response->send();

    }

    // $controller_nameからcontrollerクラスをインスタンス化して
    // レスポンスの中身をセットする関数
    public function runAction($controller_name, $action, $params = array())
    {
        // $controller_name の一番最初の文字を大文字にする
        $controller_class = ucfirst($controller_name). 'Controller';

        $controller = $this->findController($controller_class);

        if($controller === false)
        {
            throw new HttpNotFoundException($controller_class . ' controller is not found.');
        }

        $content = $controller->run($action, $params);
        $this->response->setContent($content);
    }

    // 引数で与えたコントローラークラス名のインスタンスを取得する
    protected function findController($controller_class)
    {
        if(!class_exists($controller_class))
        {
            $controller_file = $this->getControllerDir() . '/' . $controller_class . '.php';
            if(!is_readable($controller_file))
            {
                return false;
            }
            else
            {
                require_once $controller_file;

                if(!class_exists($controller_class))
                {
                    return false;
                }
            }
            return new $controller_class($this);
        }   
    }

    abstract public function getRootDir();
    abstract protected function registerRoutes();

    public function isDebugMode()
    {
        return $this->is_debug;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function getSession()
    {
        return $this->session;
    }

    public function getControllerDir()
    {
        return $this->getRootDir() . '/controllers';
    }

    public function getViewDir()
    {
        return $this->getRootDir() . '/views';
    }

    public function getModelDir()
    {

    }

    public function getWebDir()
    {
        return $this->getRootDir() . '/web';
    }

    protected function render404Page($e)
    {
        $this->response->setStatusCode(404, 'Not Found');
        $msg = $this->isDebugMode() ? $e->getMessage() : 'Page not found.';
        $msg = htmlspecialchars($msg, ENT_QUOTES, 'UTF-8');

        $this->response->setContent(<<<EOF
<!DOCTYPE html PBULIC "-//W3C//DTD XHTML 1.0 Transition//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>404</title>
</head>
<body>
    {$msg}
</body>
</html>
EOF
        );
    }

    private function log()
    {
        echo 'baseUrl: ' . $this->request->getBaseUrl() . '<br />';
        echo 'pathInfo: ' . $this->request->getPathInfo() . '<br />';
    }

}