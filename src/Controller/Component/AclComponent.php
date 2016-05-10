<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Network\Request;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;

/**
 * Acl component
 */
class AclComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function getOperationName(Request $request)
    {
        $controller = $request->params['controller'];
        $action = $request->params['action'];
        return "$controller/$action";
    }

    public function check($user, Request $request)
    {
        $groups = TableRegistry::get('Groups');
        $user_group = $groups->get($user['group_id']);
        $operation = $this->getOperationName($request);
        return in_array($operation, $user_group->permissions);
    }
}
