<?php
namespace App\Controller;

use Cake\I18n\Time;
use Cake\Utility\Text;

/**
 * Clients Controller
 *
 * @property \App\Model\Table\ClientsTable $Clients
 * @property \App\Model\Table\BidsTable $Bids
 * @property \App\Model\Table\PcsTable $Pcs
 */
class ClientsController extends AppController
{
    public function block($id = null)
    {
        $this->loadModel('Pcs');
        $this->loadModel('Bids');
        $pcs = $this->Pcs->find('all')->select('id')->where([
            'client_id' => $id
        ]);
        $total = 0;
        foreach ($pcs as $pc) {
            $total += $this->Bids->blockBidsForPc($pc['id']);
        }
        $this->log(Text::insert('Пользователь :user_name (:user_ip). Для клиента #:client_id было заблокировано :bids_count заявок.', [
            'user_name' => $this->Auth->user('name'),
            'user_ip' => $this->request->clientIp(),
            'client_id' => $id,
            'bids_count' => $total
        ]), 'notice', [
            'scope' => [
                'activations'
            ]
        ]);
        $this->Flash->success(Text::insert('Для клиента #:client_id было заблокировано :bids_count заявок.', [
            'client_id' => $id,
            'bids_count' => $total
        ]));
        return $this->redirect(['action' => 'index']);
    }

    public function getInfo($id = null)
    {
        $this->log(Text::insert('Пользователь :user_name (:user_ip) запросил запросил информацию о клиенте #:client_id.', [
            'user_name' => $this->Auth->user('name'),
            'user_ip' => $this->request->clientIp(),
            'client_id' => $id
        ]), 'info', [
            'scope' => [
                'requests'
            ]
        ]);
        $client = $this->Clients->get($id);
        $this->set('client', $client);
        $this->set('_serialize', ['client']);
    }

    public function index()
    {
        $this->log(Text::insert('Пользователь :user_name (:user_ip) запросил список клиентов.', [
            'user_name' => $this->Auth->user('name'),
            'user_ip' => $this->request->clientIp(),
        ]), 'info', [
            'scope' => [
                'requests'
            ]
        ]);
        $this->loadModel('Pcs');
        $this->loadModel('Bids');
        $pcs = $this->Pcs->find('all');
        $products_count = $this->Pcs->find('all')->select(['id']);
        $pcs_count = $this->Pcs->find('all')->select($pcs->func()->count('id'));
        $bids = $this->Bids->find('all');
        $clients = $this->Clients->find('all')
            ->select([
                'id',
                'name',
                'contact',
                'addition_date',
                'note',
                'pcs_count' => $pcs_count->where([
                    'client_id' => $pcs_count->newExpr('Clients__id')
                ]),
                'products_count' => $bids->select($bids->func()->count('product_id'))->where([
                    'pc_id IN' => $products_count->where([
                        'client_id' => $products_count->newExpr('Clients__id')
                    ]),
                    'is_active' => true
                ])
            ]);
        $this->set('clients', $clients);
        $this->set('isMobile', $this->RequestHandler->isMobile());
        $this->set('username', $this->Auth->user('login'));
    }

    public function add()
    {
        $client = $this->Clients->newEntity();
        if ($this->request->is('post')) {
            $client = $this->Clients->patchEntity($client, [
                'name' => $this->request->data('client_name'),
                'contact' => $this->request->data('client_contact'),
                'addition_date' => Time::now(),
                'note' => $this->request->data('client_note'),
            ]);
            if ($this->Clients->save($client)) {
                $this->log(Text::insert('Пользователь :user_name (:user_ip). Клиент #:client_id (:client_name) был добавлен успешно.', [
                    'user_name' => $this->Auth->user('name'),
                    'user_ip' => $this->request->clientIp(),
                    'client_id' => $client['id'],
                    'client_name' => $client['name']
                ]), 'notice', [
                    'scope' => [
                        'changes'
                    ]
                ]);
                $this->Flash->success(Text::insert('Клиент #:client_id (:client_name) был добавлен успешно.', [
                    'client_id' => $client['id'],
                    'client_name' => $client['name']
                ]));
            } else {
                $this->log(Text::insert('Пользователь :user_name (:user_ip). При добавлении клиента #:client_id (:client_name) произошла ошибка. Пожалуйста, попробуйте позже.', [
                    'user_name' => $this->Auth->user('name'),
                    'user_ip' => $this->request->clientIp(),
                    'client_id' => $client['id'],
                    'client_name' => $client['name']
                ]), 'error', [
                    'scope' => [
                        'changes'
                    ]
                ]);
                $this->Flash->error(Text::insert('При добавлении клиента #:client_id (:client_name) произошла ошибка. Пожалуйста, попробуйте позже.', [
                    'client_id' => $client['id'],
                    'client_name' => $client['name']
                ]));
            }
            $this->redirect(['action' => 'index']);
        }
    }

    public function save($id = null)
    {
        $client = $this->Clients->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $client = $this->Clients->patchEntity($client, [
                'name' => $this->request->data['client_name'],
                'contact' => $this->request->data['client_contact'],
                'note' => $this->request->data['client_note']
            ]);
            if ($this->Clients->save($client)) {
                $this->log(Text::insert('Пользователь :user_name (:user_ip). Клиент #:client_id (:client_name) был сохранен успешно.', [
                    'user_name' => $this->Auth->user('name'),
                    'user_ip' => $this->request->clientIp(),
                    'client_id' => $id,
                    'client_name' => $client['name']
                ]), 'notice', [
                    'scope' => [
                        'changes'
                    ]
                ]);
                $this->Flash->success(Text::insert('Клиент #:client_id (:client_name) был сохранен успешно.', [
                    'client_id' => $id,
                    'client_name' => $client['name']
                ]));
            } else {
                $this->log(Text::insert('Пользователь :user_name (:user_ip). При сохранении клиента #:client_id (:client_name) произошла ошибка. Пожалуйста, попробуйте позже.', [
                    'user_name' => $this->Auth->user('name'),
                    'user_ip' => $this->request->clientIp(),
                    'client_id' => $id,
                    'client_name' => $client['name']
                ]), 'error', [
                    'scope' => [
                        'changes'
                    ]
                ]);
                $this->Flash->error(Text::insert('При сохранении клиента #:client_id (:client_name) произошла ошибка. Пожалуйста, попробуйте позже.', [
                    'client_id' => $id,
                    'client_name' => $client['name']
                ]));
            }
            $this->redirect(['action' => 'index']);
        }
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $client = $this->Clients->get($id);
        if ($this->Clients->delete($client)) {
            $this->log(Text::insert('Пользователь :user_name (:user_ip). Клиент #:client_id (:client_name) был успешно удален со всеми заявками.', [
                'user_name' => $this->Auth->user('name'),
                'user_ip' => $this->request->clientIp(),
                'client_id' => $id,
                'client_name' => $client['name']
            ]), 'notice', [
                'scope' => [
                    'erases'
                ]
            ]);
            $this->Flash->success(Text::insert('Клиент #:client_id (:client_name) был успешно удален со всеми заявками.', [
                'client_id' => $id,
                'client_name' => $client['name']
            ]));
        } else {
            $this->log(Text::insert('Пользователь :user_name (:user_ip). Клиент #:client_id (:client_name) не может быть удален сейчас. Пожалуйста, попробуйте позже.', [
                'user_name' => $this->Auth->user('name'),
                'user_ip' => $this->request->clientIp(),
                'client_id' => $id,
                'client_name' => $client['name']
            ]), 'error', [
                'scope' => [
                    'erases'
                ]
            ]);
            $this->Flash->error(Text::insert('Клиент #:client_id (:client_name) не может быть удален сейчас. Пожалуйста, попробуйте позже.', [
                'client_id' => $id,
                'client_name' => $client['name']
            ]));
        }
        return $this->redirect(['action' => 'index']);
    }
}
