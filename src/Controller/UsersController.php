<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Utility\Text;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @property \App\Model\Table\BidsTable $Bids
 * @property \App\Model\Table\PcsTable $Pcs
 */
class UsersController extends AppController
{

    public function block($id = null)
    {
        $this->loadModel('Pcs');
        $this->loadModel('Bids');
        $pcs = $this->Pcs->find('all')->select('id')->where([
            'user_id' => $id
        ]);
        $total = 0;
        foreach ($pcs as $pc) {
            $total += $this->Bids->blockBidsForPc($pc['id']);
        }
        $this->Flash->success(__(Text::insert('For user #:user_id was blocked :bids_count bids.', [
            'user_id' => $id,
            'bids_count' => $total
        ])));
        return $this->redirect(['action' => 'index']);
    }

    public function getInfo($id = null)
    {
        $user = $this->Users->get($id);
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->loadModel('Pcs');
        $this->loadModel('Bids');
        $pcs = $this->Pcs->find('all');
        $products_count = $this->Pcs->find('all')->select(['id']);
        $pcs_count = $this->Pcs->find('all')->select($pcs->func()->count('id'));
        $bids = $this->Bids->find('all');
        $users = $this->Users->find('all')
            ->select([
                'id',
                'name',
                'contact',
                'addition_date',
                'note',
                'pcs_count' => $pcs_count->where([
                    'user_id' => $pcs_count->newExpr('Users__id')
                ]),
                'products_count' => $bids->select($bids->func()->count('product_id'))->where([
                    'pc_id IN' => $products_count->where([
                        'user_id' => $products_count->newExpr('Users__id')
                    ]),
                    'is_active' => true
                ])
            ]);
        $this->set('users', $users);
        $this->set('_serialize', ['users']);
        $this->set('isMobile', $this->RequestHandler->isMobile());
        $this->set('username', $this->Auth->user('login'));
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, [
                'name' => $this->request->data('user_name'),
                'contact' => $this->request->data('user_contact'),
                'addition_date' => Time::now(),
                'note' => $this->request->data('user_note'),
            ]);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Save method
     *
     * @param string|null $id User id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function save($id = null)
    {
        $user = $this->Users->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, [
                'name' => $this->request->data['user_name'],
                'contact' => $this->request->data['user_contact'],
                'note' => $this->request->data['user_note']
            ]);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
            return $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
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
}
