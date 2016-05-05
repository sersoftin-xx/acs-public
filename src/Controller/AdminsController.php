<?php
namespace App\Controller;

/**
 * Admins Controller
 *
 * @property \App\Model\Table\AdminsTable $Admins
 */
class AdminsController extends AppController
{

    public function login()
    {
        $this->set('wrong_password', false);
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                $this->redirect($this->Auth->redirectUrl());
            }
            $this->set('wrong_password', true);
        }
        $this->viewBuilder()->layout('login');
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }
}
