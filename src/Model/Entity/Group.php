<?php
namespace App\Model\Entity;

use Cake\I18n\Time;
use Cake\ORM\Entity;

/**
 * Group Entity.
 *
 * @property int $id
 * @property string $name
 * @property array $permissions
 * @property \Cake\I18n\Time $addition_date
 * @property \Cake\I18n\Time $edit_date
 * @property \App\Model\Entity\User[] $users
 */
class Group extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    /**
     * @param Time $date
     * @return string
     */
    protected function _getEditDate($date)
    {
        if ($date == null)
            return "Not modified";
        return $date;
    }
}
