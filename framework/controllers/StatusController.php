<?php

class StatusController extends Controller
{
    public function indexAction()
    {
        $user = $this->session->get('user');
        $statues = $this->db_manager->get('Status')->fetchAllPersonalArchivesByUserId($user['id']);

        return $this->render(array(
            'statuses' => $statues,
            'body' => '',
            '_token' => $this->generateCsrfToken('status/post'),
        ));
    }

    public function postAction()
    {
        
    }
}