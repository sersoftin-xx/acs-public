<?php
namespace App\Model\Entity;

use Cake\I18n\Time;
use Cake\ORM\Entity;

/**
 * Bid Entity.
 *
 * @property int $id
 * @property int $product_id
 * @property \App\Model\Entity\Product $product
 * @property int $pc_id
 * @property \App\Model\Entity\Pc $pc
 * @property \Cake\I18n\Time $application_date
 * @property bool $is_active
 * @property \Cake\I18n\Time $activation_date
 * @property \Cake\I18n\Time $expiration_date
 */
class Bid extends Entity
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

    protected $_virtual = [
        'is_expired'
    ];

    protected function _getIsExpired()
    {
        return $this->expiration_date < Time::now();
    }
}
