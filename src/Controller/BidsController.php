<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

/**
 * Bids Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @property \App\Model\Table\ProductsTable $Products
 * @property \App\Model\Table\BidsTable $Bids
 * @property \App\Model\Table\PcsTable $Pcs
 */
class BidsController extends AppController
{

    public function pc($id = null)
    {
        $this->loadModel('Users');
        $this->loadModel('Pcs');
        $this->loadModel('Products');
        $products = $this->Products->find('all');
        $users = $this->Users->find('all');
        $pcs = $this->Pcs->find('all');
        $this->set('bids', $this->Bids->find('active', [
            'contain' => ['Pcs', 'Products']
        ])->select([
            'id',
            'Products.id',
            'Products.name',
            'Pcs.id',
            'Pcs.name',
            'Pcs.user_id',
            'username' => $users->select(['name'])->where([
                'id' => $pcs->newExpr('user_id')
            ]),
            'activation_date',
            'expiration_date'
        ])->where([
            'pc_id' => $id
        ]));
        $this->set('products', $products);
        $this->set('_serialize', ['bids']);
        $this->render('index');
    }

    public function user($id = null)
    {
        $this->loadModel('Users');
        $this->loadModel('Products');
        $products = $this->Products->find('all');
        $users = $this->Users->find('all');
        $bids = $this->Bids->find('active', [
            'contain' => ['Pcs', 'Products']
        ])->select([
            'id',
            'Products.id',
            'Products.name',
            'Pcs.id',
            'Pcs.name',
            'Pcs.user_id',
            'username' => $users->select(['name'])->where([
                'id' => $id
            ]),
            'activation_date',
            'expiration_date'
        ]);
        debug($bids);
        $this->set('bids', $bids);
        $this->set('products', $products);
        $this->set('_serialize', ['bids']);
        $this->render('index');
    }


    public function product($id = null)
    {
        $this->loadModel('Users');
        $this->loadModel('Pcs');
        $this->loadModel('Products');
        $products = $this->Products->find('all');
        $users = $this->Users->find('all');
        $pcs = $this->Pcs->find('all');
        $this->set('bids', $this->Bids->find('active', [
            'contain' => ['Pcs', 'Products']
        ])->select([
            'id',
            'Products.id',
            'Products.name',
            'Pcs.id',
            'Pcs.name',
            'Pcs.user_id',
            'username' => $users->select('name')->where([
                'id' => $pcs->newExpr('user_id')
            ]),
            'activation_date',
            'expiration_date'
        ])->where([
            'product_id' => $id
        ]));
        $this->set('products', $products);
        $this->set('_serialize', ['bids']);
        $this->render('index');
    }

    public function getInfo($id = null)
    {
        $bid = $this->Bids->get($id);
        $this->set('bid', $bid);
        $this->set('_serialize', ['bid']);
    }

    public function block($id = null)
    {
        $bid = $this->Bids->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bid = $this->Bids->patchEntity($bid, [
                'is_active' => false
            ]);
            if ($this->Bids->save($bid)) {
                $this->Flash->success(__('The bid has been blocked.'));
            } else {
                $this->Flash->error(__('The bid could not be blocked. Please, try again.'));
            }
        }
        return $this->redirect(['action' => 'index']);
    }

    public function reject($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $bid = $this->Bids->get($id);
        $bids = $this->Bids->find('all', [
            'conditions' => [
                'pc_id' => $bid['pc_id']
            ]
        ]);
        $bids_count = $bids->count();
        if ($this->Bids->delete($bid)) {
            if ($bids_count === 1) {
                $this->loadModel('Pcs');
                $pc = $this->Pcs->get($bid['pc_id']);
                if ($this->Pcs->delete($pc)) {
                    $this->Flash->success(__('PC for this bid has been deleted.'));
                } else {
                    $this->Flash->error(__('PC for this bid could not be deleted. Please, try again.'));
                }
            }
            $this->Flash->success(__('The bid has been rejected.'));
        } else {
            $this->Flash->error(__('The bid could not be rejected. Please, try again.'));
        }
        return $this->redirect(['action' => 'recent']);
    }

    public function accept($id = null)
    {
        $bid = $this->Bids->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bid = $this->Bids->patchEntity($bid, [
                'is_active' => true,
                'activation_date' => Time::now(),
                'expiration_date' => Time::parse($this->request->data('bid_expiration_date'))
            ]);
            if ($this->Bids->save($bid)) {
                $this->Flash->success(__('The bid has been accepted.'));
            } else {
                $this->Flash->error(__('The bid could not be accepted. Please, try again.'));
            }
        }
        return $this->redirect(['action' => 'recent']);
    }

    /**
     * Recent method
     *
     * @return void
     */
    public function recent()
    {
        $this->set('recent_bids', $this->Bids->find('recent', [
            'contain' => ['Products', 'Pcs']
        ]));
        $this->set('_serialize', ['recent_bids']);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->loadModel('Users');
        $this->loadModel('Pcs');
        $this->loadModel('Products');
        $products = $this->Products->find('all');
        $users = $this->Users->find('all');
        $pcs = $this->Pcs->find('all');
        $this->set('bids', $this->Bids->find('active', [
            'contain' => ['Pcs', 'Products']
        ])->select([
            'id',
            'Products.id',
            'Products.name',
            'Pcs.id',
            'Pcs.name',
            'Pcs.user_id',
            'username' => $users->select(['name'])->where([
                'id' => $pcs->newExpr('user_id')
            ]),
            'activation_date',
            'expiration_date'
        ]));
        $this->set('products', $products);
        $this->set('_serialize', ['bids']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $bid = $this->Bids->newEntity();
        if ($this->request->is('post')) {
            $bid = $this->Bids->patchEntity($bid, $this->request->data);
            if ($this->Bids->save($bid)) {
                $this->Flash->success(__('The bid has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The bid could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('bid'));
        $this->set('_serialize', ['bid']);
    }

    /**
     * Save method
     *
     * @param string|null $id Bid id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function save($id = null)
    {
        $bid = $this->Bids->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bid = $this->Bids->patchEntity($bid, [
                'product_id' => $this->request->data('active_bid_product_id'),
                'expiration_date' => Time::parse($this->request->data('active_bid_expiration_date'))
            ]);
            if ($this->Bids->save($bid)) {
                $this->Flash->success(__('The bid has been saved.'));
            } else {
                $this->Flash->error(__('The bid could not be saved. Please, try again.'));
            }
            return $this->redirect(['action' => 'index']);
        }
    }
}
