<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Logs Controller
 *
 * @property \App\Model\Table\LogsTable $Logs
 */
class LogsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $logs = $this->paginate($this->Logs);

        $this->set(compact('logs'));
        $this->set('_serialize', ['logs']);
    }

    /**
     * View method
     *
     * @param string|null $id Log id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $log = $this->Logs->get($id, [
            'contain' => []
        ]);

        $this->set('log', $log);
        $this->set('_serialize', ['log']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $log = $this->Logs->newEntity();
        if ($this->request->is('post')) {
            $log = $this->Logs->patchEntity($log, $this->request->data);
            if ($this->Logs->save($log)) {
                $this->Flash->success(__('The log has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The log could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('log'));
        $this->set('_serialize', ['log']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Log id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $log = $this->Logs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $log = $this->Logs->patchEntity($log, $this->request->data);
            if ($this->Logs->save($log)) {
                $this->Flash->success(__('The log has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The log could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('log'));
        $this->set('_serialize', ['log']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Log id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $log = $this->Logs->get($id);
        if ($this->Logs->delete($log)) {
            $this->Flash->success(__('The log has been deleted.'));
        } else {
            $this->Flash->error(__('The log could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
