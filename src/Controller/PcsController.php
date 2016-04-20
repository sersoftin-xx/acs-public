<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Text;

/**
 * Pcs Controller
 *
 * @property \App\Model\Table\PcsTable $Pcs
 * @property \App\Model\Table\UsersTable $Users
 * @property \App\Model\Table\BidsTable $Bids
 */
class PcsController extends AppController
{

    public function user($id = null)
    {
        $this->loadModel('Users');
        $this->loadModel('Bids');

        $bids = $this->Bids->find('all');
        $pcs = $this->Pcs->find('all', ['contain' => ['Users']])
            ->select([
                'id',
                'user_id',
                'Users.name',
                'name',
                'unique_key',
                'addition_date',
                'comment',
                'products_count' => $bids->select($bids->func()->count('id'))->where([
                    'pc_id' => $bids->newExpr('Pcs__id'),
                    'is_active' => true
                ])
            ])->where([
                'user_id' => $id
            ]);
        $this->set('users', $this->Users->find('all')->select(['id', 'name']));
        $this->set('pcs', $pcs);
        $this->render('index');
    }

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
        $pc = $this->Pcs->get($id);
        $this->set('pc', $pc);
        $this->set('_serialize', ['pc']);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->loadModel('Users');
        $this->loadModel('Bids');

        $bids = $this->Bids->find('all');
        $pcs = $this->Pcs->find('all', ['contain' => ['Users']])
            ->select([
                'id',
                'user_id',
                'Users.name',
                'name',
                'unique_key',
                'addition_date',
                'comment',
                'products_count' => $bids->select($bids->func()->count('id'))->where([
                    'pc_id' => $bids->newExpr('Pcs__id'),
                    'is_active' => true
                ])
            ]);
        $this->set('users', $this->Users->find('all')->select(['id', 'name']));
        $this->set('pcs', $pcs);
    }

    /**
     * Save method
     *
     * @param string|null $id Pc id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function save($id = null)
    {
        $pc = $this->Pcs->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pc = $this->Pcs->patchEntity($pc, [
                'user_id' => $this->request->data('pc_user_id'),
                'name' => $this->request->data('pc_name'),
                'comment' => $this->request->data('pc_comment')
            ]);
            if ($this->Pcs->save($pc)) {
                $this->Flash->success(__('The pc has been saved.'));
            } else {
                $this->Flash->error(__('The pc could not be saved. Please, try again.'));
            }
            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Pc id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
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
