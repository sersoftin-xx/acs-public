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
        $this->Flash->success(__(Text::insert('For PC #:pc_id was blocked :bids_count bids.', [
            'pc_id' => $id,
            'bids_count' => $bids_count
        ])));
        return $this->redirect(['action' => 'index']);
    }

    public function getInfo($id = null)
    {
        $this->log(Text::insert('Пользователь :user_name (:client_ip) запросил запросил информацию о компьютере #:pc_id.', [
            'user_name' => $this->Auth->user('name'),
            'client_ip' => $this->request->clientIp(),
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
        $this->log(Text::insert('Пользователь :user_name (:client_ip) запросил список компьютеров.', [
            'user_name' => $this->Auth->user('name'),
            'client_ip' => $this->request->clientIp(),
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
                $this->Flash->success(__('The pc has been saved.'));
            } else {
                $this->Flash->error(__('The pc could not be saved. Please, try again.'));
            }
            $this->redirect(['action' => 'index']);
        }
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pc = $this->Pcs->get($id);
        if ($this->Pcs->delete($pc)) {
            $this->Flash->success(__('The pc has been deleted.'));
        } else {
            $this->Flash->error(__('The pc could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
