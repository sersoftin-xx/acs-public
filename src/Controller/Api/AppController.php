<?php
namespace App\Controller\Api;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;

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

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');

        $this->loadComponent('Auth', Configure::read('api_auth'));
        $this->loadComponent('Acl');

    }

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
        return $this->Acl->check($user, $this->request);
    }
}
