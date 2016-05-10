<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\I18n\Time;

/**
 * Groups Controller
 *
 * @property \App\Model\Table\GroupsTable $Groups
 */
class GroupsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $groups = $this->Groups->find('all');
        $permissions = Configure::read('permissions');
        $this->set(compact('groups'));
        $this->set(compact('permissions'));
        $this->set('isMobile', $this->RequestHandler->isMobile());
        $this->set('username', $this->Auth->user('login'));
        $this->viewBuilder()->layout('admin');
    }

    public function getInfo($id = null)
    {
        $group = $this->Groups->get($id);
        $this->set('group', $group);
        $this->set('_serialize', ['group']);
    }

    public function add()
    {
        $group = $this->Groups->newEntity();
        if ($this->request->is('post')) {
            $group = $this->Groups->patchEntity($group, [
                'name' => $this->request->data('group_name'),
                'permissions' => $this->request->data('group_permissions'),
                'addition_date' => Time::now()
            ]);
            if ($this->Groups->save($group)) {
                $this->Flash->success(__('The user has been saved.'));
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
            $this->redirect(['action' => 'index']);
        }
    }
}
