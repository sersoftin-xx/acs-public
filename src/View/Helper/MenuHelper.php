<?php
namespace App\View\Helper;

use Cake\Core\Configure;
use Cake\View\Helper;

/**
 * Menu helper
 * @property \Cake\View\Helper\HtmlHelper Html
 */
class MenuHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public $helpers = ['Html'];

    public function renderMenu($counters)
    {
        $menuArray = Configure::read('menu');
        $menu = '';
        foreach ($menuArray as $menuItem) {
            $menu .= $this->Html->tag('li', $this->Html->link(
                $this->Html->tag('span', '', ['class' => $menuItem['icon']]) . $menuItem['caption'] . ' ' .
                $this->Html->tag('span', $counters[$menuItem['name']], ['class' => ($counters[$menuItem['name']] > 0) ? 'badge ' . $menuItem['classes']['badge'] : 'badge']),
                ['controller' => $menuItem['controller'], 'action' => $menuItem['action']], ['escape' => false]),
                ['class' => (($this->request->params['controller'] == $menuItem['controller']) && ($this->request->params['action'] == $menuItem['action'])) ? $menuItem['classes']['li'] . ' active' : $menuItem['classes']['li'], 'role' => 'presentation']);
        }
        return $menu;
    }
}
