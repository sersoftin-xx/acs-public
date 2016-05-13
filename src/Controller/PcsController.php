<?php
namespace App\Controller;

use Cake\Utility\Text;

/**
 * Pcs Controller
 *
 * @property \App\Model\Table\PcsTable $Pcs
 * @property \App\Model\Table\ClientsTable $Clients
 * @property \App\Model\Table\BidsTable $Bids
 */
class PcsController extends AppController
{
    public function block($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $this->loadModel('Bids');
        $bids_count = $this->Bids->blockBidsForPc($id);
        $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip). Для компьютера #:pc_id было заблокировано :bids_count заявок.', [
            'auth_user_name' => $this->Auth->user('name'),
            'auth_user_ip' => $this->request->clientIp(),
            'pc_id' => $id,
            'bids_count' => $bids_count
        ]), 'notice', [
            'scope' => [
                'activations'
            ]
        ]);
        $this->Flash->success(Text::insert('Для компьютера #:pc_id было заблокировано :bids_count заявок.', [
            'pc_id' => $id,
            'bids_count' => $bids_count
        ]));
        return $this->redirect(['action' => 'index']);
    }

    public function getInfo($id = null)
    {
        $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip) запросил запросил информацию о компьютере #:pc_id.', [
            'auth_user_name' => $this->Auth->user('name'),
            'auth_user_ip' => $this->request->clientIp(),
            'pc_id' => $id
        ]), 'info', [
            'scope' => [
                'requests'
            ]
        ]);
        $pc = $this->Pcs->get($id);
        $this->set('pc', $pc);
        $this->set('_serialize', ['pc']);
    }

    public function index()
    {
        $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip) запросил список компьютеров.', [
            'auth_user_name' => $this->Auth->user('name'),
            'auth_user_ip' => $this->request->clientIp(),
        ]), 'info', [
            'scope' => [
                'requests'
            ]
        ]);
        $this->loadModel('Clients');
        $this->loadModel('Bids');

        $bids = $this->Bids->find('all');
        $pcs = $this->Pcs->find('all', ['contain' => ['Clients']])
            ->select([
                'id',
                'client_id',
                'Clients.name',
                'name',
                'unique_key',
                'addition_date',
                'comment',
                'products_count' => $bids->select($bids->func()->count('id'))->where([
                    'pc_id' => $bids->newExpr('Pcs__id'),
                    'is_active' => true
                ])
            ]);
        $this->set('clients', $this->Clients->find('all')->select(['id', 'name']));
        $this->set('pcs', $pcs);
        $this->set('isMobile', $this->RequestHandler->isMobile());
        $this->set('username', $this->Auth->user('login'));
    }

    public function save($id = null)
    {
        $pc = $this->Pcs->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pc = $this->Pcs->patchEntity($pc, [
                'client_id' => $this->request->data('pc_client_id'),
                'name' => $this->request->data('pc_name'),
                'comment' => $this->request->data('pc_comment')
            ]);
            if ($this->Pcs->save($pc)) {
                $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip). Компьютер #:pc_id (:pc_name) был сохранен успешно.', [
                    'auth_user_name' => $this->Auth->user('name'),
                    'auth_user_ip' => $this->request->clientIp(),
                    'pc_id' => $id,
                    'pc_name' => $pc['name']
                ]), 'notice', [
                    'scope' => [
                        'changes'
                    ]
                ]);
                $this->Flash->success(Text::insert('Компьютер #:pc_id (:pc_name) был сохранен успешно.', [
                    'pc_id' => $id,
                    'pc_name' => $pc['name']
                ]));
            } else {
                $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip). При сохранении компьютера #:pc_id (:pc_name) произошла ошибка. Пожалуйста, попробуйте позже.', [
                    'auth_user_name' => $this->Auth->user('name'),
                    'auth_user_ip' => $this->request->clientIp(),
                    'pc_id' => $id,
                    'pc_name' => $pc['name']
                ]), 'error', [
                    'scope' => [
                        'changes'
                    ]
                ]);
                $this->Flash->error(Text::insert('При сохранении компьютера #:pc_id (:pc_name) произошла ошибка. Пожалуйста, попробуйте позже.', [
                    'pc_id' => $id,
                    'pc_name' => $pc['name']
                ]));
            }
            $this->redirect(['action' => 'index']);
        }
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pc = $this->Pcs->get($id);
        if ($this->Pcs->delete($pc)) {
            $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip). Компьютер #:pc_id (:pc_name) был успешно удален.', [
                'auth_user_name' => $this->Auth->user('name'),
                'auth_user_ip' => $this->request->clientIp(),
                'pc_id' => $id,
                'pc_name' => $pc['name']
            ]), 'notice', [
                'scope' => [
                    'erases'
                ]
            ]);
            $this->Flash->success(Text::insert('Компьютер #:pc_id (:pc_name) был успешно удален.', [
                'pc_id' => $id,
                'pc_name' => $pc['name']
            ]));
        } else {
            $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip). Компьютер #:pc_id (:pc_name) не может быть удален сейчас. Пожалуйста, попробуйте позже.', [
                'auth_user_name' => $this->Auth->user('name'),
                'auth_user_ip' => $this->request->clientIp(),
                'pc_id' => $id,
                'pc_name' => $pc['name']
            ]), 'error', [
                'scope' => [
                    'erases'
                ]
            ]);
            $this->Flash->error(Text::insert('Компьютер #:pc_id (:pc_name) не может быть удален сейчас. Пожалуйста, попробуйте позже.', [
                'pc_id' => $id,
                'pc_name' => $pc['name']
            ]));
        }
        return $this->redirect(['action' => 'index']);
    }
}
