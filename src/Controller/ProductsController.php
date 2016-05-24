<?php
namespace App\Controller;

use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Utility\Text;

/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 */
class ProductsController extends AppController
{
    public function getInfo($id = null)
    {
        $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip) запросил запросил информацию о продукте #:product_id.', [
            'auth_user_name' => $this->Auth->user('name'),
            'auth_user_ip' => $this->request->clientIp(),
            'product_id' => $id
        ]), 'info', [
            'scope' => [
                'requests'
            ]
        ]);
        $product = $this->Products->get($id);
        $this->set('product', $product);
        $this->set('_serialize', ['product']);
    }

    public function index()
    {
        $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip) запросил список продуктов.', [
            'auth_user_name' => $this->Auth->user('name'),
            'auth_user_ip' => $this->request->clientIp(),
        ]), 'info', [
            'scope' => [
                'requests'
            ]
        ]);
        $this->viewBuilder()->layout('admin');
        $this->set('products', $this->Products->find('all'));
        $this->set('username', $this->Auth->user('name'));
        $this->set('isMobile', $this->RequestHandler->isMobile());
    }

    public function add()
    {
        $product = $this->Products->newEntity();
        if ($this->request->is('post')) {
            $product_data = [
                'name' => $this->request->data('product_name'),
                'addition_date' => Time::now(),
                'description' => $this->request->data('product_description'),
            ];
            $product = $this->Products->patchEntity($product, $product_data);
            if ($this->Products->save($product)) {
                $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip). Продукт #:product_id (:product_name) был добавлен успешно.', [
                    'auth_user_name' => $this->Auth->user('name'),
                    'auth_user_ip' => $this->request->clientIp(),
                    'product_id' => $product['id'],
                    'product_name' => $product['name']
                ]), 'notice', [
                    'scope' => [
                        'changes'
                    ]
                ]);
                $this->Flash->success(Text::insert('Продукт #:product_id (:product_name) был добавлен успешно.', [
                    'product_id' => $product['id'],
                    'product_name' => $product['name']
                ]));
            } else {
                $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip). При добавлении продукта #:product_id (:product_name) произошла ошибка. Пожалуйста, попробуйте позже.', [
                    'auth_user_name' => $this->Auth->user('name'),
                    'auth_user_ip' => $this->request->clientIp(),
                    'product_id' => $product['id'],
                    'product_name' => $product['name']
                ]), 'error', [
                    'scope' => [
                        'changes'
                    ]
                ]);
                $this->Flash->error(Text::insert('При добавлении продукта #:product_id (:product_name) произошла ошибка. Пожалуйста, попробуйте позже.', [
                    'product_id' => $product['id'],
                    'product_name' => $product['name']
                ]));
            }
            $this->redirect(['action' => 'index']);
        }
        $this->redirect(['action' => 'index']);
    }

    public function save($id = null)
    {
        $product = $this->Products->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $product_data = [
                'name' => $this->request->data('product_name'),
                'description' => $this->request->data('product_description')
            ];
            $product = $this->Products->patchEntity($product, $product_data);
            if ($this->Products->save($product)) {
                $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip). Продукт #:product_id (:product_name) был сохранен успешно.', [
                    'auth_user_name' => $this->Auth->user('name'),
                    'auth_user_ip' => $this->request->clientIp(),
                    'product_id' => $id,
                    'product_name' => $product['name']
                ]), 'notice', [
                    'scope' => [
                        'changes'
                    ]
                ]);
                $this->Flash->success(Text::insert('Продукт #:product_id (:product_name) был сохранен успешно.', [
                    'product_id' => $id,
                    'product_name' => $product['name']
                ]));
            } else {
                $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip). При сохранении продукта #:product_id (:product_name) произошла ошибка. Пожалуйста, попробуйте позже.', [
                    'auth_user_name' => $this->Auth->user('name'),
                    'auth_user_ip' => $this->request->clientIp(),
                    'product_id' => $id,
                    'product_name' => $product['name']
                ]), 'error', [
                    'scope' => [
                        'changes'
                    ]
                ]);
                $this->Flash->error(Text::insert('При сохранении продукта #:product_id (:product_name) произошла ошибка. Пожалуйста, попробуйте позже.', [
                    'product_id' => $id,
                    'product_name' => $product['name']
                ]));
            }
            $this->redirect(['action' => 'index']);
        }
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $product = $this->Products->get($id);
        if ($this->Products->delete($product)) {
            $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip). Продукт #:product_id (:product_name) был успешно удален.', [
                'auth_user_name' => $this->Auth->user('name'),
                'auth_user_ip' => $this->request->clientIp(),
                'product_id' => $id,
                'product_name' => $product['name']
            ]), 'notice', [
                'scope' => [
                    'erases'
                ]
            ]);
            $this->Flash->success(Text::insert('Продукт #:product_id (:product_name) был успешно удален.', [
                'product_id' => $id,
                'product_name' => $product['name']
            ]));
        } else {
            $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip). Продукт #:product_id (:product_name) не может быть удален сейчас. Пожалуйста, попробуйте позже.', [
                'auth_user_name' => $this->Auth->user('name'),
                'auth_user_ip' => $this->request->clientIp(),
                'product_id' => $id,
                'product_name' => $product['name']
            ]), 'error', [
                'scope' => [
                    'erases'
                ]
            ]);
            $this->Flash->error(Text::insert('Продукт #:product_id (:product_name) не может быть удален сейчас. Пожалуйста, попробуйте позже.', [
                'product_id' => $id,
                'product_name' => $product['name']
            ]));
        }
        return $this->redirect(['action' => 'index']);
    }
}
