<?php
namespace App\Controller\Api;

use Cake\Core\Configure;
use Cake\I18n\Time;

/**
 * Bids Controller
 *
 * @property \App\Model\Table\BidsTable $Bids
 */
class BidsController extends AppController
{
    public function accept($id = null)
    {
        $this->request->allowMethod('post');

        $bid = $this->Bids->get($id);
        $bid = $this->Bids->patchEntity($bid, [
            'is_active' => true,
            'activation_date' => Time::now(),
            'expiration_date' => Time::parse($this->request->data('expiration_date')),
        ]);
        if ($this->Bids->save($bid)) {
            $this->set(compact('bid'));
        } else {
            $this->set('errors', $bid->errors());
        }
    }

    public function block($id = null)
    {
        $this->request->allowMethod('post');

        $bid = $this->Bids->get($id);
        $bid = $this->Bids->patchEntity($bid, [
            'is_active' => false
        ]);
        if ($this->Bids->save($bid)) {
            $this->set(compact('bid'));
        } else {
            $this->set('errors', $bid->errors());
        }
    }

    public function reject($id = null)
    {
        $this->request->allowMethod('post');

        $bid = $this->Bids->get($id);

        if (!$this->Bids->delete($bid)) {
            $this->set('errors', $bid->errors());
        }
    }
}