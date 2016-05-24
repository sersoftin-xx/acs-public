<?php
namespace App\Controller\Api;

use App\Model\Entity\Client;
use Cake\I18n\Time;
use Cake\Utility\Text;

/**
 * Clients Controller
 *
 * @property \App\Model\Table\ClientsTable $Clients
 * @property \App\Model\Table\BidsTable $Bids
 * @property \App\Model\Table\PcsTable $Pcs
 */
class ClientsController extends AppController
{
    public function add()
    {
        $this->request->allowMethod('post');

        $client = new Client($this->request->data());
        if ($this->Clients->save($client)) {
            $this->set(compact('client'));
        } else {
            $this->set('errors', $client->errors());
        }
    }

    public function edit($id = null)
    {
        $this->request->allowMethod('post');

        $client = $this->Clients->get($id);
        $client = $this->Clients->patchEntity($client, $this->request->data, [
            'fieldList' => [
                'name', 'contact', 'note'
            ]
        ]);

        if ($this->Clients->save($client)) {
            $this->set(compact('client'));
        } else {
            $this->set('errors', $client->errors());
        }
    }

    public function delete($id = null)
    {
        $this->request->allowMethod('delete');

        $client = $this->Clients->get($id);
        if (!$this->Clients->delete($client)) {
            $this->set('errors', $client->errors());
        }
    }
}
