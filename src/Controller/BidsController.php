<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\I18n\Date;

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
        $products = $this->Products->find('all')->select([
            'id',
            'name'
        ]);
        $users = $this->Users->find('all');
        $pcs = $this->Pcs->find('all');
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
                'id' => $pcs->newExpr('user_id')
            ]),
            'activation_date',
            'expiration_date'
        ]);
        if (isset($this->request->data['search_form_pc_id'])
            && !empty($this->request->data['search_form_pc_id'])
            && $this->request->data['search_form_pc_id'] != '0'
        ) {
            $bids->where([
                'pc_id' => $this->request->data['search_form_pc_id']
            ]);
        }
        if (isset($this->request->data['search_form_product_id'])
            && !empty($this->request->data['search_form_product_id'])
            && $this->request->data['search_form_product_id'] != '0'
        ) {
            $bids->where([
                'product_id' => $this->request->data['search_form_product_id']
            ]);
        }
        if (isset($this->request->data['search_form_user_id'])
            && !empty($this->request->data['search_form_user_id'])
            && $this->request->data['search_form_user_id'] != '0'
        ) {
            $bids->where([
                'Pcs.user_id' => $this->request->data['search_form_user_id']
            ]);
        }

        if (isset($this->request->data['search_form_use_activation_date'])
            && !empty($this->request->data['search_form_use_activation_date']
            && $this->request->data['search_form_use_activation_date'] === 'on')) {
            $from = new Date($this->request->data['search_form_activation_date_from']);
            $to = new Date($this->request->data['search_form_activation_date_to']);
            $bids->where(
                function ($exp) use ($from, $to) {
                    return $exp->between('activation_date', $from, $to);
                }
            );
        }
//        if (isset($this->request->data['activation_date'])) {
//            $bids->where([
//                'activation_date' => Time::createFromFormat('dd.MM.yyyy HH:ii:ss', $this->request->data['activation_date'])
//            ]);
//        }
//        if (isset($this->request->data['expiration_date'])) {
//            $bids->where([
//                'expiration_date' => $this->request->data['expiration_date']
//            ]);
//        }
        $pcs = $this->Pcs->find('all');
        $users = $this->Users->find('all');
        $this->set('users', $users);
        $this->set('pcs', $pcs);
        $this->set('bids', $bids);
        $this->set('products', $products);
        $this->render('index');
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
