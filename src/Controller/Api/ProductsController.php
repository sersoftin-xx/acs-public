<?php
namespace App\Controller\Api;

use App\Model\Entity\Product;
use App\Model\Table\ProductsTable;
use Cake\I18n\Time;
use Cake\Utility\Text;

/**
 * @property \App\Model\Table\ProductsTable Products
 */
class ProductsController extends AppController
{
    public function add()
    {
        $this->request->allowMethod('post');

        $product = new Product([
            'name' => $this->request->data('name'),
            'addition_date' => Time::now(),
            'description' => $this->request->data('description')
        ]);
        if ($this->Products->save($product)) {
            $this->set(compact('product'));
        } else {
            $this->set('errors', $product->errors());
        }
    }

    public function edit($id = null)
    {
        $this->request->allowMethod('post');

        $product = $this->Products->get($id);
        $this->Products->patchEntity($product, $this->request->data, [
            'fieldList' => [
                'name', 'description'
            ]
        ]);
        if ($this->Products->save($product)) {
            $this->set(compact('product'));
        } else {
            $this->set('errors', $product->errors());
        }
    }

    public function delete($id = null)
    {
        $this->request->allowMethod('delete');

        $product = $this->Products->get($id);

        if (!$this->Products->delete($product)) {
            $this->set('errors', $product->errors());
        }
    }
}
