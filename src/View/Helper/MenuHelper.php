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

    public function renderMenu($type, $counters)
    {
        $menuArray = Configure::read($type);
        $menu = '';
        foreach ($menuArray as $menuItem) {
            $itemName = $menuItem['name'];
            $itemIcon = $menuItem['icon'];
            $itemCaption = $menuItem['caption'];
            $itemHasBadge = $menuItem['hasBadge'];
            $itemBadge = $menuItem['classes']['badge'];
            $itemController = $menuItem['controller'];
            $itemIsActive = (($this->request->params['controller'] === $itemController) && ($this->request->params['action'] === $menuItem['action']));

            if ($itemIcon != null) {
                $itemIcon = $this->Html->tag('span', '', ['class' => $itemIcon]);
            }

            if ($itemHasBadge) {
                $itemBadge = $this->Html->tag('span', $counters[$itemName], ['class' => 'badge' . ($itemBadge != null ? ' ' . $itemBadge : '')]);
            } else {
                $itemBadge = '';
            }
            $menuLink = $this->Html->link(
                $itemIcon . ' ' . $itemCaption . ' ' . $itemBadge,
                ['controller' => $menuItem['controller'], 'action' => $menuItem['action']], ['escape' => false]);
            $menuElement = $this->Html->tag('li', $menuLink, ['class' => $itemIsActive ? 'active ' . $menuItem['classes']['li'] : $menuItem['classes']['li'], 'role' => 'presentation']);
            $menu .= $menuElement;
        }
        return $menu;
    }
}
