<?php
namespace App\Controller\Api;

/**
 * Pcs Controller
 *
 * @property \App\Model\Table\PcsTable $Pcs
 * @property \App\Model\Table\ClientsTable $Clients
 * @property \App\Model\Table\BidsTable $Bids
 */
class PcsController extends AppController
{
    public function edit($id = null)
    {
        $this->request->allowMethod('post');

        $pc = $this->Pcs->get($id);
        $pc = $this->Pcs->patchEntity($pc, $this->request->data, [
            'fieldList' => [
                'client_id', 'name', 'comment'
            ]
        ]);
        if ($this->Pcs->save($pc)) {
            $this->set(compact('pc'));
        } else {
            $this->set('errors', $pc->errors());
        }
    }

    public function delete($id = null)
    {
        $this->request->allowMethod('delete');

        $pc = $this->Pcs->get($id);

        if (!$this->Pcs->delete($pc)) {
            $this->set('errors', $pc->errors());
        }
    }
}
