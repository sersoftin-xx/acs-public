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
    public function index()
    {
        $logs = $this->Logs->find('all', [
            'order' => ['id' => 'DESC']
        ])->limit(30);
        $this->set(compact('logs'));
        $this->set('username', $this->Auth->user('login'));
        $this->viewBuilder()->layout('admin');
    }

    public function clear()
    {
        if ($this->Logs->deleteAll('1=1')) {
            $this->Flash->success('Clearing success!');
        } else {
            $this->Flash->error('Clearing field!');
        }
        $this->redirect(['action' => 'index']);
    }
}
