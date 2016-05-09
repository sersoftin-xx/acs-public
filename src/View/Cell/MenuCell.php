<?php
namespace App\View\Cell;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\View\Cell;

/**
 * Menu cell
 * @property  \App\Model\Table\BidsTable Bids
 * @property  \App\Model\Table\ClientsTable Clients
 * @property  \App\Model\Table\PcsTable Pcs
 * @property  \App\Model\Table\ProductsTable Products
 */
class MenuCell extends Cell
{
    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Default display method.
     *
     * @param $type
     */
    public function display($type)
    {
        $counters = [];
        foreach (Configure::read($type) as $menuItem) {
            $counters[$menuItem['name']] = TableRegistry::get($menuItem['controller'])
                ->find($menuItem['finder'])->count();
        }

//        $this->loadModel('Bids');
//        $this->loadModel('Clients');
//        $this->loadModel('Pcs');
//        $this->loadModel('Products');

        $this->set('counters', $counters);

//        $this->set('counters', [
//            'active_bids' => $this->Bids->find('active')->count(),
//            'new_bids' => $this->Bids->find('recent')->count(),
//            'clients' => $this->Clients->find('all')->count(),
//            'pcs' => $this->Pcs->find('all')->count(),
//            'products' => $this->Products->find('all')->count()
//        ]);
        $this->set('type', $type);
    }
}
