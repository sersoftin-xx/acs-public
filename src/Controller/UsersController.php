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
                $this->log(Text::insert('Пользователь :user_name (:user_ip). Пользователь #:user_id (:user_name2) был сохранен успешно.', [
                    'user_name' => $this->Auth->user('name'),
                    'user_ip' => $this->request->clientIp(),
                    'user_id' => $id,
                    'user_name2' => $user['name']
                ]), 'notice', [
                    'scope' => [
                        'changes'
                    ]
                ]);
                $this->Flash->success(Text::insert('Пользователь #:user_id (:user_name) был сохранен успешно.', [
                    'user_name' => $user['name'],
                    'user_id' => $id
                ]));
            } else {
                $this->log(Text::insert('Пользователь :user_name (:user_ip). При сохранении пользователя #:user_id (:user_name2) произошла ошибка. Пожалуйста, попробуйте позже.', [
                    'user_name' => $this->Auth->user('name'),
                    'user_ip' => $this->request->clientIp(),
                    'user_id' => $id,
                    'user_name2' => $user['name']
                ]), 'error', [
                    'scope' => [
                        'changes'
                    ]
                ]);
                $this->Flash->error(Text::insert('При сохранении пользователя #:user_id (:user_name) произошла ошибка. Пожалуйста, попробуйте позже.', [
                    'user_name' => $user['name'],
                    'user_id' => $id
                ]));
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
                $this->log(Text::insert('Пользователь :user_name (:user_ip). Пароль пользователя #:user_id (:user_name2) был сброшен успешно.', [
                    'user_name' => $this->Auth->user('name'),
                    'user_ip' => $this->request->clientIp(),
                    'user_id' => $id,
                    'user_name2' => $user['name']
                ]), 'notice', [
                    'scope' => [
                        'changes'
                    ]
                ]);
                $this->Flash->success(Text::insert('Пароль пользователя #:user_id (:user_name) был сброшен успешно.', [
                    'user_name' => $user['name'],
                    'user_id' => $id
                ]));
            } else {
                $this->log(Text::insert('Пользователь :user_name (:user_ip). При сбросе пароля пользователя #:user_id (:user_name2) произошла ошибка. Пожалуйста, попробуйте позже.', [
                    'user_name' => $this->Auth->user('name'),
                    'user_ip' => $this->request->clientIp(),
                    'user_id' => $id,
                    'user_name2' => $user['name']
                ]), 'error', [
                    'scope' => [
                        'changes'
                    ]
                ]);
                $this->Flash->error(Text::insert('При сбросе пароля пользователя #:user_id (:user_name) произошла ошибка. Пожалуйста, попробуйте позже.', [
                    'user_name' => $user['name'],
                    'user_id' => $id
                ]));
            }
            $this->redirect(['action' => 'index']);
        }
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->log(Text::insert('Пользователь :user_name (:user_ip). Пользователь #:user_id (:user_name2) был успешно удален.', [
                'user_name' => $this->Auth->user('name'),
                'user_ip' => $this->request->clientIp(),
                'user_id' => $id,
                'user_name2' => $user['name']
            ]), 'notice', [
                'scope' => [
                    'erases'
                ]
            ]);
            $this->Flash->success(Text::insert('Пользователь #:user_id (:user_name2) был успешно удален.', [
                'user_id' => $id,
                'user_name2' => $user['name']
            ]));
        } else {
            $this->log(Text::insert('Пользователь :user_name (:user_ip). Пользователь #:user_id (:user_name2) не может быть удален сейчас. Пожалуйста, попробуйте позже.', [
                'user_name' => $this->Auth->user('name'),
                'user_ip' => $this->request->clientIp(),
                'user_id' => $id,
                'user_name2' => $user['name']
            ]), 'error', [
                'scope' => [
                    'erases'
                ]
            ]);
            $this->Flash->error(Text::insert('Пользователь #:user_id (:user_name2) не может быть удален сейчас. Пожалуйста, попробуйте позже.', [
                'user_id' => $id,
                'user_name2' => $user['name']
            ]));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function getInfo($id = null)
    {
        $this->log(Text::insert('Пользователь :user_name (:user_ip) запросил запросил информацию о пользователе #:user_id.', [
            'user_name' => $this->Auth->user('name'),
            'user_ip' => $this->request->clientIp(),
            'user_id' => $id
        ]), 'info', [
            'scope' => [
                'requests'
            ]
        ]);
        $user = $this->Users->get($id);
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    public function index()
    {
        $this->log(Text::insert('Пользователь :user_name (:user_ip) запросил список пользователей.', [
            'user_name' => $this->Auth->user('name'),
            'user_ip' => $this->request->clientIp(),
        ]), 'info', [
            'scope' => [
                'requests'
            ]
        ]);
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
                $this->log(Text::insert('Пользователь :user_name (:user_ip) вошел в систему.', [
                    'user_name' => $this->Auth->user('name'),
                    'user_ip' => $this->request->clientIp(),
                ]), 'notice', [
                    'scope' => [
                        'auth'
                    ]
                ]);
                $this->redirect($this->Auth->redirectUrl());
            }
            $this->log(Text::insert('Пользователь :user_name (:user_ip) не смог войти в систему. Неправильный логин или пароль.', [
                'user_name' => $this->request->data('login'),
                'user_ip' => $this->request->clientIp(),
            ]), 'alert', [
                'scope' => [
                    'auth'
                ]
            ]);
            $this->set('wrong_password', true);
        }
        $this->viewBuilder()->layout('login');
    }

    public function logout()
    {
        $this->log(Text::insert('Пользователь :user_name (:user_ip) вышел из системы.', [
            'user_name' => $this->Auth->user('name'),
            'user_ip' => $this->request->clientIp(),
        ]), 'notice', [
            'scope' => [
                'auth'
            ]
        ]);
        return $this->redirect($this->Auth->logout());
    }
}
