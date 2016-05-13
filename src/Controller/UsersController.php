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
                $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip). Пользователь #:user_id (:user_name) был добавлен успешно.', [
                    'auth_user_name' => $this->Auth->user('name'),
                    'auth_user_ip' => $this->request->clientIp(),
                    'user_id' => $user['id'],
                    'user_name' => $user['name']
                ]), 'notice', [
                    'scope' => [
                        'changes'
                    ]
                ]);
                $this->Flash->success(Text::insert('Пользователь #:user_id (:user_name) был добавлен успешно.', [
                    'user_id' => $user['id'],
                    'user_name' => $user['name']
                ]));
            } else {
                $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip). При добавлении пользователя #:user_id (:user_name) произошла ошибка. Пожалуйста, попробуйте позже.', [
                    'auth_user_name' => $this->Auth->user('name'),
                    'auth_user_ip' => $this->request->clientIp(),
                    'user_id' => $user['id'],
                    'user_name' => $user['name']
                ]), 'error', [
                    'scope' => [
                        'changes'
                    ]
                ]);
                $this->Flash->error(Text::insert('При добавлении пользователя #:user_id (:user_name) произошла ошибка. Пожалуйста, попробуйте позже.', [
                    'user_id' => $user['id'],
                    'user_name' => $user['name']
                ]));
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
                $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip). Пользователь #:user_id (:user_name) был сохранен успешно.', [
                    'auth_user_name' => $this->Auth->user('name'),
                    'auth_user_ip' => $this->request->clientIp(),
                    'user_id' => $id,
                    'user_name' => $user['name']
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
                $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip). При сохранении пользователя #:user_id (:user_name) произошла ошибка. Пожалуйста, попробуйте позже.', [
                    'auth_user_name' => $this->Auth->user('name'),
                    'auth_user_ip' => $this->request->clientIp(),
                    'user_id' => $id,
                    'user_name' => $user['name']
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
                $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip). Пароль пользователя #:user_id (:user_name) был сброшен успешно.', [
                    'auth_user_name' => $this->Auth->user('name'),
                    'auth_user_ip' => $this->request->clientIp(),
                    'user_id' => $id,
                    'user_name' => $user['name']
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
                $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip). При сбросе пароля пользователя #:user_id (:user_name) произошла ошибка. Пожалуйста, попробуйте позже.', [
                    'auth_user_name' => $this->Auth->user('name'),
                    'auth_user_ip' => $this->request->clientIp(),
                    'user_id' => $id,
                    'user_name' => $user['name']
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
            $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip). Пользователь #:user_id (:user_name) был успешно удален.', [
                'auth_user_name' => $this->Auth->user('name'),
                'auth_user_ip' => $this->request->clientIp(),
                'user_id' => $id,
                'user_name' => $user['name']
            ]), 'notice', [
                'scope' => [
                    'erases'
                ]
            ]);
            $this->Flash->success(Text::insert('Пользователь #:user_id (:user_name) был успешно удален.', [
                'user_id' => $id,
                'user_name' => $user['name']
            ]));
        } else {
            $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip). Пользователь #:user_id (:user_name) не может быть удален сейчас. Пожалуйста, попробуйте позже.', [
                'auth_user_name' => $this->Auth->user('name'),
                'auth_user_ip' => $this->request->clientIp(),
                'user_id' => $id,
                'user_name' => $user['name']
            ]), 'error', [
                'scope' => [
                    'erases'
                ]
            ]);
            $this->Flash->error(Text::insert('Пользователь #:user_id (:user_name) не может быть удален сейчас. Пожалуйста, попробуйте позже.', [
                'user_id' => $id,
                'user_name' => $user['name']
            ]));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function getInfo($id = null)
    {
        $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip) запросил запросил информацию о пользователе #:user_id.', [
            'auth_user_name' => $this->Auth->user('name'),
            'auth_user_ip' => $this->request->clientIp(),
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
        $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip) запросил список пользователей.', [
            'auth_user_name' => $this->Auth->user('name'),
            'auth_user_ip' => $this->request->clientIp(),
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
        $this->set('username', $this->Auth->user('name'));
        $this->viewBuilder()->layout('admin');
    }

    public function login()
    {
        $this->set('wrong_password', false);
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip) вошел в систему.', [
                    'auth_user_name' => $this->Auth->user('name'),
                    'auth_user_ip' => $this->request->clientIp(),
                ]), 'notice', [
                    'scope' => [
                        'auth'
                    ]
                ]);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->log(Text::insert('Пользователь с логином :user_login (:auth_user_ip) не смог войти в систему. Неправильный логин или пароль.', [
                'user_login' => $this->request->data('login'),
                'auth_user_ip' => $this->request->clientIp(),
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
        $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip) вышел из системы.', [
            'auth_user_name' => $this->Auth->user('name'),
            'auth_user_ip' => $this->request->clientIp(),
        ]), 'notice', [
            'scope' => [
                'auth'
            ]
        ]);
        return $this->redirect($this->Auth->logout());
    }
}
