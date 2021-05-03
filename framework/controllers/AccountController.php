<?php

class AccountController extends Controller
{
    private $name_signup_token = 'account/signup';

    public function signupAction()
    {
        return $this->render(array(
            'user_name' => '',
            'password' => '',
            '_token' => $this->generateCsrfToken($this->name_signup_token),
        ));
    }

    /*
     ユーザ登録処理、views/account/signup.php見るといいことあるかも
    */
    public function registerAction()
    {
        if(!$this->request->isPost())
        {
            $this->forward404();
        }

        $token = $this->request->getPost('_token');
        // ワンタイムトークンを通らなかったら、signupにリダイレクト
        if(!$this->checkCsrfToken($this->name_signup_token, $token))
        {
            $this->redirect($this->name_signup_token);
        }

        $user_name = $this->request->getPost('user_name');
        $password = $this->request->getPost('password');

        $errors = array();

        $repo_name = 'User';
        if(!strlen($user_name))
        {
            $errors[] = 'please enter any user name.';
        }
        else if(!preg_match('#^\w{3,20}$#', $user_name))
        {
            $errors[] = 'please enter user name within 3 to 20 characters.';
        }
        else if(!$this->db_manager->get($repo_name)->isUniqueUserName($user_name))
        {
            $errors[] = 'this username is already used.';
        }

        if(!strlen($password))
        {
            $errors[] = 'please enter any password.';
        }
        else if(4 > strlen($password) || strlen($password) > 30)
        {
            $errors[] = 'please enter password within 4 to 30';
        }


        if(count($errors) === 0)
        {
            $this->db_manager->get($repo_name)->insert($user_name, $password);
            $this->session->setAuthenticated(true);
            $user = $this->db_manager->get($repo_name)->fetchByUserName($user_name);
            $this->session->set('user', $user);
            return $this->redirect('/');
        }

        return $this->render(array(
            'user_name' => $user_name,
            'password' => $password,
            'errors' => $errors,
            '_token' => $this->generateCsrfToken('account/signup'),
        ), 'signup');
    }
}