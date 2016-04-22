<?php
namespace App\View\Cell;

use Cake\View\Cell;

/**
 * Menu cell
 */
class MenuCell extends Cell
{
    /**
     *
     * @property \App\Model\Table\UsersTable $Users
     * @property \App\Model\Table\PcsTable $Pcs
     * @property \App\Model\Table\ProductsTable $Products
     * @property \App\Model\Table\BidsTable $Bids
     *
     */


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
     * @return void
     */
    public function display()
    {
        $this->loadModel('Bids');
        $this->loadModel('Users');
        $this->loadModel('Pcs');
        $this->loadModel('Products');

        $this->set('counters', [
            'active_bids' => $this->Bids->find('active')->count(),
            'new_bids' => $this->Bids->find('recent')->count(),
            'users' => $this->Users->find('all')->count(),
            'pcs' => $this->Pcs->find('all')->count(),
            'products' => $this->Products->find('all')->count()
        ]);
    }
}
