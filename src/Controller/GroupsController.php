<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\Utility\Text;

/**
 * Groups Controller
 *
 * @property \App\Model\Table\GroupsTable $Groups
 */
class GroupsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->log(Text::insert('Пользователь :user_name (:user_ip) запросил список групп.', [
            'user_name' => $this->Auth->user('name'),
            'user_ip' => $this->request->clientIp(),
        ]), 'info', [
            'scope' => [
                'requests'
            ]
        ]);
        $groups = $this->Groups->find('all');
        $permissions = Configure::read('permissions');
        $this->set(compact('groups'));
        $this->set(compact('permissions'));
        $this->set('isMobile', $this->RequestHandler->isMobile());
        $this->set('username', $this->Auth->user('login'));
        $this->viewBuilder()->layout('admin');
    }

    public function getInfo($id = null)
    {
        $this->log(Text::insert('Пользователь :user_name (:user_ip) запросил запросил информацию о группе #:group_id.', [
            'user_name' => $this->Auth->user('name'),
            'user_ip' => $this->request->clientIp(),
            'group_id' => $id
        ]), 'info', [
            'scope' => [
                'requests'
            ]
        ]);
        $group = $this->Groups->get($id);
        $this->set('group', $group);
        $this->set('_serialize', ['group', 'permissions']);
    }

    public function add()
    {
        $group = $this->Groups->newEntity();
        if ($this->request->is('post')) {
            $group = $this->Groups->patchEntity($group, [
                'name' => $this->request->data('group_name'),
                'permissions' => $this->request->data('group_permissions'),
                'addition_date' => Time::now()
            ]);
            if ($this->Groups->save($group)) {
                $this->log(Text::insert('Пользователь :user_name (:user_ip). Группа #:group_id (:group_name) была добавлена успешно.', [
                    'user_name' => $this->Auth->user('name'),
                    'user_ip' => $this->request->clientIp(),
                    'group_id' => $group['id'],
                    'group_name' => $group['name']
                ]), 'notice', [
                    'scope' => [
                        'changes'
                    ]
                ]);
                $this->Flash->success(Text::insert('Группа #:group_id (:group_name) была добавлена успешно.', [
                    'group_id' => $group['id'],
                    'group_name' => $group['name']
                ]));
            } else {
                $this->log(Text::insert('Пользователь :user_name (:user_ip). При добавлении группы #:group_id (:group_name) произошла ошибка. Пожалуйста, попробуйте позже.', [
                    'user_name' => $this->Auth->user('name'),
                    'user_ip' => $this->request->clientIp(),
                    'group_id' => $group['id'],
                    'group_name' => $group['name']
                ]), 'error', [
                    'scope' => [
                        'changes'
                    ]
                ]);
                $this->Flash->error(Text::insert('При добавлении группы #:group_id (:group_name) произошла ошибка. Пожалуйста, попробуйте позже.', [
                    'group_id' => $group['id'],
                    'group_name' => $group['name']
                ]));
            }
            $this->redirect(['action' => 'index']);
        }
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $group = $this->Groups->get($id);
        if ($this->Groups->delete($group)) {
            $this->log(Text::insert('Пользователь :user_name (:user_ip). Группа #:group_id (:group_name) была успешно удалена.', [
                'user_name' => $this->Auth->user('name'),
                'user_ip' => $this->request->clientIp(),
                'group_id' => $id,
                'group_name' => $group['name']
            ]), 'notice', [
                'scope' => [
                    'erases'
                ]
            ]);
            $this->Flash->success(Text::insert('Группа #:group_id (:group_name) была успешно удалена.', [
                'group_id' => $id,
                'group_name' => $group['name']
            ]));
        } else {
            $this->log(Text::insert('Пользователь :user_name (:user_ip). Группа #:group_id (:group_name) не может быть удалена сейчас. Пожалуйста, попробуйте позже.', [
                'user_name' => $this->Auth->user('name'),
                'user_ip' => $this->request->clientIp(),
                'group_id' => $id,
                'group_name' => $group['name']
            ]), 'error', [
                'scope' => [
                    'erases'
                ]
            ]);
            $this->Flash->error(Text::insert('Группа #:group_id (:group_name) не может быть удалена сейчас. Пожалуйста, попробуйте позже.', [
                'group_id' => $id,
                'group_name' => $group['name']
            ]));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function save($id = null)
    {
        $group = $this->Groups->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $group = $this->Groups->patchEntity($group, [
                'name' => $this->request->data('group_name'),
                'permissions' => $this->request->data('group_permissions'),
                'edit_date' => Time::now()
            ]);
            if ($this->Groups->save($group)) {
                $this->log(Text::insert('Пользователь :user_name (:user_ip). Группа #:group_id (:group_name) была сохранена успешно.', [
                    'user_name' => $this->Auth->user('name'),
                    'user_ip' => $this->request->clientIp(),
                    'group_id' => $id,
                    'group_name' => $group['name']
                ]), 'notice', [
                    'scope' => [
                        'changes'
                    ]
                ]);
                $this->Flash->success(Text::insert('Группа #:group_id (:group_name) была сохранена успешно.', [
                    'group_id' => $id,
                    'group_name' => $group['name']
                ]));
            } else {
                $this->log(Text::insert('Пользователь :user_name (:user_ip). При сохранении группы #:group_id (:group_name) произошла ошибка. Пожалуйста, попробуйте позже.', [
                    'user_name' => $this->Auth->user('name'),
                    'user_ip' => $this->request->clientIp(),
                    'group_id' => $id,
                    'group_name' => $group['name']
                ]), 'error', [
                    'scope' => [
                        'changes'
                    ]
                ]);
                $this->Flash->error(Text::insert('При сохранении группы #:group_id (:group_name) произошла ошибка. Пожалуйста, попробуйте позже.', [
                    'group_id' => $id,
                    'group_name' => $group['name']
                ]));
            }
            $this->redirect(['action' => 'index']);
        }
    }
}
