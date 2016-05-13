<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Utility\Text;

/**
 * Application Controller
 *
 * @property \App\Controller\Component\AclComponent Acl
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        Time::setToStringFormat([\IntlDateFormatter::MEDIUM, \IntlDateFormatter::SHORT]);

        $this->loadComponent('Auth', Configure::read('auth'));
        $this->loadComponent('Acl');

        $this->viewBuilder()->layout('user');
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }

    public function isAuthorized($user = null)
    {
        if ($this->Acl->check($user, $this->request)) {
            return true;
        }
        $operation = $this->Acl->getOperationName($this->request);
        $this->log(Text::insert('Пользователь :auth_user_name (:auth_user_ip) попытался выполнить запрещенную для его группы команду: :operation_name.', [
            'auth_user_name' => $this->Auth->user('name'),
            'auth_user_ip' => $this->request->clientIp(),
            'operation_name' => $operation
        ]), 'alert', [
            'scope' => [
                'auth'
            ]
        ]);
        $this->Flash->error("Вашей группе запрещен досутп к операции $operation");
        return false;
    }
}
