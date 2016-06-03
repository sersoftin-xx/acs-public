<?php
namespace App\Controller\ClientApi;

use Cake\Utility\Text;

/**
 * @property \App\Model\Table\ProductsTable Products
 */
class ProductsController extends AppController
{
    public function index()
    {
        $this->request->allowMethod('get');
        $products = $this->Products->find('all', [
            'fields' => [
                'id',
                'name',
                'addition_date',
                'description'
            ]
        ]);
        $this->set(compact('products'));
    }

    public function info($id = null)
    {
        $this->request->allowMethod('get');
        $product = $this->Products->get($id);
        $this->set(compact('product'));
    }
}
