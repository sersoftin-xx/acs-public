<?php
namespace App\Controller;

use Cake\I18n\Time;
use Cake\Utility\Text;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable Users
 * @property \App\Model\Table\GroupsTable Groups
 */
class UsersController extends AppController
{
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, [
                'name' => $this->request->data('user_name'),
                'login' => $this->request->data('user_login'),
                'password' => $this->request->data('user_password'),
                'group_id' => $this->request->data('user_group_id'),
                'addition_date' => Time::now()
            ]);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
            $this->redirect(['action' => 'index']);
        }
    }

    public function save($id = null)
    {
        $user = $this->Users->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, [
                'name' => $this->request->data('user_name'),
                'login' => $this->request->data('user_login'),
                'group_id' => $this->request->data('user_group_id'),
                'edit_date' => Time::now()
            ]);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
            $this->redirect(['action' => 'index']);
        }
    }

    public function resetPassword($id = null)
    {
        $user = $this->Users->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, [
                'password' => $this->request->data('user_password'),
                'edit_date' => Time::now()
            ]);
            if ($this->Users->save($user)) {
                $this->Flash->success('User password has been reset');
            } else {
                $this->Flash->error('New user password could not be saved. Please, try again.');
            }
            $this->redirect(['action' => 'index']);
        }
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function getInfo($id = null)
    {
        $user = $this->Users->get($id);
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    public function index()
    {
        $message = Text::insert('User :user_name(:client_ip) load users list. ', [
            'user_name' => $this->Auth->user('name'),
            'client_ip' => $this->request->clientIp()
        ]);
        $this->log($message, 'info', ['scope' => ['activations']]);
        $users = $this->Users->find('all', [
            'contain' => ['Groups']
        ]);
        $this->loadModel('Groups');
        $groups = $this->Groups->find('all');
        $this->set(compact('users'));
        $this->set(compact('groups'));
        $this->set('isMobile', $this->RequestHandler->isMobile());
        $this->set('username', $this->Auth->user('login'));
        $this->viewBuilder()->layout('admin');
    }

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
