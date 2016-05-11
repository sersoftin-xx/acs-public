<?php
namespace App\Controller;

use Cake\I18n\Time;

/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 */
class ProductsController extends AppController
{

    /**
     * @param null $id
     */
    public function getInfo($id = null)
    {
        $product = $this->Products->get($id);
        $this->set('product', $product);
        $this->set('_serialize', ['product']);
    }

    public function download($id = null)
    {
        $product = $this->Products->get($id);
        $this->response->file(
            $product['product_file'], [
                'download' => true,
                'name' => $product['download_name']
            ]
        );
        return $this->response;
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->viewBuilder()->layout('admin');
        $this->set('products', $this->Products->find('all'));
        $this->set('username', $this->Auth->user('login'));
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
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
                    $this->Flash->success(__('The product has been saved.'));
                } else {
                    $this->Flash->error(__('The product could not be saved. Please, try again.'));
                }
                $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Failed to upload the product file. Try again.'));
            $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Save method
     *
     * @param string|null $id Product id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
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
                $this->Flash->success(__('The product has been saved.'));
            } else {
                $this->Flash->error(__('The product could not be saved. Please, try again.'));
            }
            $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Update method
     *
     * @param string|null $id Product id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
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
                    $this->Flash->success(__('The product has been updated.'));
                } else {
                    $this->Flash->error(__('The product could not be updated. Please, try again.'));
                }
                $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Failed to upload the product file. Try again.'));
            }
            $this->redirect(['action' => 'index']);
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Product id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $product = $this->Products->get($id);
        if ($this->Products->delete($product)) {
            $this->Flash->success(__('The product has been deleted.'));
        } else {
            $this->Flash->error(__('The product could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
