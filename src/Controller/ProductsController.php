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
    public function getList()
    {
        $this->log(Text::insert('Запрос списка продуктов с :ip.', [
            'ip' => $this->request->clientIp(),
        ]), 'info', [
            'scope' => [
                'requests'
            ]
        ]);
        $products = $this->Products->find('all', [
            'conditions' => [
                'hidden' => false,
            ],
            'fields' => [
                'id', 'name'
            ]
        ]);
        $this->set([
            'products' => $products
        ]);
        $this->set('_serialize', ['products']);
    }

    public function getVersion($id = null)
    {
        $this->log(Text::insert('Запрос версии продукта :product_id с ip :ip', [
            'ip' => $this->request->clientIp(),
            'product_id' => $id
        ]), 'info', [
            'scope' => [
                'requests'
            ]
        ]);
        $product = $this->Products->find('all', [
            'conditions' => [
                'id' => $id
            ],
            'fields' => [
                'id',
                'name',
                'version'
            ]
        ]);
        $this->set('product', $product);
        $this->set('_serialize', ['product']);
    }

    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['download', 'getList', 'getVersion']);
    }

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

    public function download($id = null)
    {
        $product = $this->Products->get($id);
        $this->log(Text::insert('Какой-то клиент :client_ip загружает продукт #:product_id (product_name).', [
            'auth_user_name' => $this->Auth->user('name'),
            'auth_user_ip' => $this->request->clientIp(),
            'product_id' => $id,
            'product_name' => $product['name']
        ]), 'info', [
            'scope' => [
                'requests'
            ]
        ]);
        $this->response->file(
            $product['product_file'], [
                'download' => true,
                'name' => $product['download_name']
            ]
        );
        return $this->response;
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
            if (is_uploaded_file($this->request->data('product_file')['tmp_name'])) {
                $product_data = [
                    'name' => $this->request->data('product_name'),
                    'product_file_upload' => $this->request->data('product_file'),
                    'download_name' => $this->request->data('product_download_name'),
                    'hidden' => isset($this->request->data['product_hidden']),
                    'version' => 1,
                    'addition_date' => Time::now(),
                    'update_date' => Time::now(),
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
            $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip). При загрузке файла продукта #:product_id (:product_name) произошла ошибка.', [
                'auth_user_name' => $this->Auth->user('name'),
                'auth_user_ip' => $this->request->clientIp(),
                'product_id' => $product['id'],
                'product_name' => $product['name']
            ]), 'error', [
                'scope' => [
                    'changes'
                ]
            ]);
            $this->Flash->error(Text::insert('При загрузке файла продукта #:product_id (:product_name) произошла ошибка.', [
                'product_id' => $product['id'],
                'product_name' => $product['name']
            ]));
            $this->redirect(['action' => 'index']);
        }
    }

    public function save($id = null)
    {
        $product = $this->Products->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $product_data = [
                'name' => $this->request->data('product_name'),
                'hidden' => isset($this->request->data['product_hidden']),
                'download_name' => $this->request->data('product_download_name'),
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

    public function update($id = null)
    {
        $product = $this->Products->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            if (is_uploaded_file($this->request->data('product_file')['tmp_name'])) {
                $product_data = [
                    'product_file_upload' => $this->request->data['product_file'],
                    'update_date' => Time::now(),
                    'version' => $product['version'] + 1
                ];
                $product = $this->Products->patchEntity($product, $product_data);
                if ($this->Products->save($product)) {
                    $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip). Продукт #:product_id (:product_name) был обновлен успешно.', [
                        'auth_user_name' => $this->Auth->user('name'),
                        'auth_user_ip' => $this->request->clientIp(),
                        'product_id' => $id,
                        'product_name' => $product['name']
                    ]), 'notice', [
                        'scope' => [
                            'changes'
                        ]
                    ]);
                    $this->Flash->success(Text::insert('Продукт #:product_id (:product_name) был обновлен успешно.', [
                        'product_id' => $id,
                        'product_name' => $product['name']
                    ]));
                } else {
                    $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip). При обновлении продукта #:product_id (:product_name) произошла ошибка. Пожалуйста, попробуйте позже.', [
                        'auth_user_name' => $this->Auth->user('name'),
                        'auth_user_ip' => $this->request->clientIp(),
                        'product_id' => $id,
                        'product_name' => $product['name']
                    ]), 'error', [
                        'scope' => [
                            'changes'
                        ]
                    ]);
                    $this->Flash->error(Text::insert('При обновлении продукта #:product_id (:product_name) произошла ошибка. Пожалуйста, попробуйте позже.', [
                        'product_id' => $id,
                        'product_name' => $product['name']
                    ]));
                }
                $this->redirect(['action' => 'index']);
            } else {
                $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip). При загрузке файла для продукта #:product_id (:product_name) произошла ошибка. Пожалуйста, попробуйте позже.', [
                    'auth_user_name' => $this->Auth->user('name'),
                    'auth_user_ip' => $this->request->clientIp(),
                    'product_id' => $id,
                    'product_name' => $product['name']
                ]), 'error', [
                    'scope' => [
                        'changes'
                    ]
                ]);
                $this->Flash->error(Text::insert('При загрузке файла для продукта #:product_id (:product_name) произошла ошибка. Пожалуйста, попробуйте позже.', [
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
