<?php
namespace App\Controller\Api;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Event\Event;


class AppController extends Controller
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }
}
