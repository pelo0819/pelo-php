<?php

abstract class Controller
{
    protected $controller_name;
    protected $action_name;
    protected $application;
    protected $request;
    protected $response;
    protected $session;
    protected $db_manager;

    public function __construct($application)
    {
        $class_name = get_class($this);
        $len_controller = strlen('Controller');
        
        // 自分のクラス名からControllerをのぞく
        $this->controller_name = strtolower(substr($class_name, 0, -$len_controller));

        $this->application = $application;
        $this->request = $application->getRequest();
        $this->response = $application->getResponse();
        $this->session = $application->getSession();
        $this->db_manager = $application->getDBManager();
    }

    public function run($action, $params = array())
    {
        $this->action_name = $action;

        $action_method = $action . 'Action';

        if(!method_exists($this, $action_method))
        {
            $this->forward404();
        }

        $content = $this->$action_method($params);
        return $content;
    }

    protected function render($variables = array(), $templates = null, $layout = 'layout')
    {
        $defaults = array(
            'request' => $this->request,
            'base_url' => $this->request->getBaseUrl(),
        );

        $view = new View($this->application->getViewDir(), $defaults);

        if(is_null($templates))
        {
            $templates = $this->action_name;
        }

        $path = $this->controller_name . '/' .$templates;
        return $view->render($path, $variables, $layout);
    }

    /*
    ワンタイムトークンを生成する
    */
    protected function generateCsrfToken($form_name)
    {
        $key = 'csrf_tokens/' . $form_name;
        $tokens = $this->session->get($key, array());
        if(count($tokens) >= 10)
        {
            array_shift($tokens);
        }

        $token = sha1($form_name . session_id() . microtime());
        $tokens[] = $token;

        $this->session->set($key, $tokens);
        return $token;
    }

    protected function checkCsrfToken($form_name, $token)
    {
        $key = 'csrf_tokens/' . $form_name;
        $tokens = $this->session->get($key, array());

        if(false !== ($pos = array_search($token, $tokens, true)))
        {
            unset($tokens[$pos]);
            $this->session->set($key, $tokens);
            return true;
        }
    }

    protected function forward404()
    {
        throw new HttpNotFoundException('Forwarded 404 page from '
                . $this->controller_name. '/' . $this->action_name);   
    }

    protected function redirect($url)
    {
        $pattern = '#https?://#';
        if(!preg_match($pattern, $url))
        {
            $protocol = $this->request->isSsl() ? 'https://' : 'http://';
            $host = $this->request->getHost();
            $base_url = $this->request->getBaseUrl();

            $url = $protocol . $host . $base_url . $url;
        }

        $this->response->setStatusCode(302, 'Found');
        $this->response->setHttpHeader('Location', $url);
    }

}