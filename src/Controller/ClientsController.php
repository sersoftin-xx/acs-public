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
        $this->Flash->success(__(Text::insert('For client #:client_id was blocked :bids_count bids.', [
            'client_id' => $id,
            'bids_count' => $total
        ])));
        return $this->redirect(['action' => 'index']);
    }

    public function getInfo($id = null)
    {
        $this->log(Text::insert('Пользователь :user_name (:client_ip) запросил запросил информацию о клиенте #:client_id.', [
            'user_name' => $this->Auth->user('name'),
            'client_ip' => $this->request->clientIp(),
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
        $this->log(Text::insert('Пользователь :user_name (:client_ip) запросил список клиентов.', [
            'user_name' => $this->Auth->user('name'),
            'client_ip' => $this->request->clientIp(),
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
                $this->Flash->success(__('The client has been saved.'));
            } else {
                $this->Flash->error(__('The client could not be saved. Please, try again.'));
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
                $this->Flash->success(__('The client has been saved.'));
            } else {
                $this->Flash->error(__('The client could not be saved. Please, try again.'));
            }
            $this->redirect(['action' => 'index']);
        }
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $client = $this->Clients->get($id);
        if ($this->Clients->delete($client)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
