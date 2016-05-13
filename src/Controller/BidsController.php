<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\Utility\Text;

/**
 * Bids Controller
 *
 * @property \App\Model\Table\ClientsTable $Clients
 * @property \App\Model\Table\ProductsTable $Products
 * @property \App\Model\Table\BidsTable $Bids
 * @property \App\Model\Table\PcsTable $Pcs
 */
class BidsController extends AppController
{

    public function getInfo($id = null)
    {
        $this->log(Text::insert('Пользователь :user_name (:user_ip) запросил запросил информацию о заявке #:bid_id.', [
            'user_name' => $this->Auth->user('name'),
            'user_ip' => $this->request->clientIp(),
            'bid_id' => $id
        ]), 'info', [
            'scope' => [
                'requests'
            ]
        ]);
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
                $this->log(Text::insert('Пользователь :user_name (:user_ip). Заявка (#:bid_id) была заблокирована успешно.', [
                    'user_name' => $this->Auth->user('name'),
                    'user_ip' => $this->request->clientIp(),
                    'bid_id' => $id
                ]), 'notice', [
                    'scope' => [
                        'activations'
                    ]
                ]);
                $this->Flash->success(Text::insert('Заявка (#:bid_id) была заблокирована успешно.', [
                    'bid_id' => $id
                ]));
            } else {
                $this->log(Text::insert('Пользователь :user_name (:user_ip). Заявка (#:bid_id) не может быть заблокирована. Пожалуйста, попробуйте позже.', [
                    'user_name' => $this->Auth->user('name'),
                    'user_ip' => $this->request->clientIp(),
                    'bid_id' => $id
                ]), 'error', [
                    'scope' => [
                        'activations'
                    ]
                ]);
                $this->Flash->error(Text::insert('Заявка (#:bid_id) не может быть заблокирована. Пожалуйста, попробуйте позже.', [
                    'bid_id' => $id
                ]));
            }
        }
        return $this->redirect(['action' => 'active']);
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
                    $this->log(Text::insert('Пользователь :user_name (:user_ip). Компьютер (:pc_id) для этой заявки (#:bid_id) был удален.', [
                        'user_name' => $this->Auth->user('name'),
                        'user_ip' => $this->request->clientIp(),
                        'pc_id' => $bid['pc_id'],
                        'bid_id' => $id
                    ]), 'notice', [
                        'scope' => [
                            'erases'
                        ]
                    ]);
                    $this->Flash->success(Text::insert('Компьютер (:pc_id) для этой заявки (#:bid_id) был удален.', [
                        'pc_id' => $bid['pc_id'],
                        'bid_id' => $id
                    ]));
                } else {
                    $this->log(Text::insert('Пользователь :user_name (:user_ip). Компьютер (:pc_id) для этой заявки (#:bid_id) не мможет быть удален.', [
                        'user_name' => $this->Auth->user('name'),
                        'user_ip' => $this->request->clientIp(),
                        'pc_id' => $bid['pc_id'],
                        'bid_id' => $id
                    ]), 'error', [
                        'scope' => [
                            'erases'
                        ]
                    ]);
                    $this->Flash->error(Text::insert('Компьютер (:pc_id) для этой заявки (#:bid_id) не мможет быть удален.', [
                        'pc_id' => $bid['pc_id'],
                        'bid_id' => $id
                    ]));
                }
            }
            $this->log(Text::insert('Пользователь :user_name (:user_ip). Заявка (#:bid_id) была отклонена успешно.', [
                'user_name' => $this->Auth->user('name'),
                'user_ip' => $this->request->clientIp(),
                'bid_id' => $id
            ]), 'notice', [
                'scope' => [
                    'erases'
                ]
            ]);
            $this->Flash->success(Text::insert('Заявка (#:bid_id) была отклонена успешно.', [
                'bid_id' => $id
            ]));
        } else {
            $this->log(Text::insert('Пользователь :user_name (:user_ip). Заявка (#:bid_id) не может быть отклонена. Пожалуйста, попробуйте позже.', [
                'user_name' => $this->Auth->user('name'),
                'user_ip' => $this->request->clientIp(),
                'bid_id' => $id
            ]), 'error', [
                'scope' => [
                    'erases'
                ]
            ]);
            $this->Flash->error(Text::insert('Заявка (#:bid_id) не может быть отклонена. Пожалуйста, попробуйте позже.', [
                'bid_id' => $id
            ]));
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
                'expiration_date' => Time::parse($this->request->data('bid_expiration_date')),
            ]);
            if ($this->Bids->save($bid)) {
                $this->log(Text::insert('Пользователь :user_name (:user_ip). Заявка (#:bid_id) была принята успешно.', [
                    'user_name' => $this->Auth->user('name'),
                    'user_ip' => $this->request->clientIp(),
                    'bid_id' => $id
                ]), 'notice', [
                    'scope' => [
                        'activations'
                    ]
                ]);
                $this->Flash->success(Text::insert('Заявка (#:bid_id) была принята успешно.', [
                    'bid_id' => $id
                ]));
            } else {
                $this->log(Text::insert('Пользователь :user_name (:user_ip). Заявка (#:bid_id) не может быть принята. Пожалуйста, попробуйте позже.', [
                    'user_name' => $this->Auth->user('name'),
                    'user_ip' => $this->request->clientIp(),
                    'bid_id' => $id
                ]), 'error', [
                    'scope' => [
                        'activations'
                    ]
                ]);
                $this->Flash->error(Text::insert('Заявка (#:bid_id) не может быть принята. Пожалуйста, попробуйте позже.', [
                    'bid_id' => $id
                ]));
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
        $this->log(Text::insert('Пользователь :user_name (:user_ip) запросил список неактивированных заявок.', [
            'user_name' => $this->Auth->user('name'),
            'user_ip' => $this->request->clientIp()
        ]), 'info', [
            'scope' => [
                'requests'
            ]
        ]);
        $this->set('recent_bids', $this->Bids->find('recent', [
            'contain' => ['Products', 'Pcs']
        ])->orderDesc('Bids.id'));
        $this->set('isMobile', $this->RequestHandler->isMobile());
        $this->set('username', $this->Auth->user('login'));
    }

    /**
     * Index method
     *
     * @return void
     */
    public function active()
    {
        $this->log(Text::insert('Пользователь :user_name (:user_ip) запросил список активированных заявок.', [
            'user_name' => $this->Auth->user('name'),
            'user_ip' => $this->request->clientIp()
        ]), 'info', [
            'scope' => [
                'requests'
            ]
        ]);

        $this->loadModel('Clients');
        $this->loadModel('Pcs');
        $this->loadModel('Products');
        $products = $this->Products->find('all')->select([
            'id',
            'name'
        ]);
        $clients = $this->Clients->find('all');
        $pcs = $this->Pcs->find('all');
        $bids = $this->Bids->find('active', [
            'contain' => ['Pcs', 'Products']
        ])->select([
            'id',
            'Products.id',
            'Products.name',
            'Pcs.id',
            'Pcs.name',
            'Pcs.client_id',
            'client_name' => $clients->select(['name'])->where([
                'id' => $pcs->newExpr('client_id')
            ]),
            'activation_date',
            'expiration_date'
        ])->orderDesc('Bids.id');
        $pcs = $this->Pcs->find('all');
        $clients = $this->Clients->find('all');
        $this->set('clients', $clients);
        $this->set('pcs', $pcs);
        $this->set('bids', $bids);
        $this->set('products', $products);
        $this->set('username', $this->Auth->user('login'));
    }

    public function save($id = null)
    {
        $bid = $this->Bids->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $bid = $this->Bids->patchEntity($bid, [
                'product_id' => $this->request->data('active_bid_product_id'),
                'expiration_date' => Time::parse($this->request->data('active_bid_expiration_date'))
            ]);
            if ($this->Bids->save($bid)) {
                $this->log(Text::insert('Пользователь :user_name (:user_ip). Заявка (#:bid_id) была сохранена успешно.', [
                    'user_name' => $this->Auth->user('name'),
                    'user_ip' => $this->request->clientIp(),
                    'bid_id' => $id
                ]), 'notice', [
                    'scope' => [
                        'changes'
                    ]
                ]);
                $this->Flash->success(Text::insert('Заявка (#:bid_id) была сохранена успешно.', [
                    'bid_id' => $id
                ]));
            } else {
                $this->log(Text::insert('Пользователь :user_name (:user_ip). Заявка (#:bid_id) не может быть сохранена. Пожалуйста, попробуйте позже.', [
                    'user_name' => $this->Auth->user('name'),
                    'user_ip' => $this->request->clientIp(),
                    'bid_id' => $id
                ]), 'error', [
                    'scope' => [
                        'changes'
                    ]
                ]);
                $this->Flash->error(Text::insert('Заявка (#:bid_id) не может быть сохранена. Пожалуйста, попробуйте позже.', [
                    'bid_id' => $id
                ]));
            }
        }
        return $this->redirect(['action' => 'active']);
    }
}
