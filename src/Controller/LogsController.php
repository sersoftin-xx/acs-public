<?php
namespace App\Controller;
use Cake\Utility\Text;

/**
 * Logs Controller
 *
 * @property \App\Model\Table\LogsTable $Logs
 */
class LogsController extends AppController
{
    public function index()
    {
        $this->log(Text::insert('Пользователь :user_name (:client_ip) запросил логи.', [
            'user_name' => $this->Auth->user('name'),
            'client_ip' => $this->request->clientIp(),
        ]), 'info', [
            'scope' => [
                'requests'
            ]
        ]);
        $logs = $this->Logs->find('all', [
            'order' => ['id' => 'DESC']
        ])->limit(30);
        $this->set(compact('logs'));
        $this->set('username', $this->Auth->user('login'));
        $this->viewBuilder()->layout('admin');
    }

    public function clear()
    {
        $this->log(Text::insert('Пользователь :user_name (:client_ip) очистил логи базы данных.', [
            'user_name' => $this->Auth->user('name'),
            'client_ip' => $this->request->clientIp()
        ]), 'info', [
            'scope' => [
                'requests'
            ]
        ]);
        if ($this->Logs->deleteAll('1=1')) {
            $this->Flash->success('Очистка логов завершена успешно.');
        } else {
            $this->Flash->error('Произошла ошибка при очистке логов.');
        }
        $this->redirect(['action' => 'index']);
    }
}
