<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Product Entity.
 *
 * @property int $id
 * @property string $name
 * @property string $product_file
 * @property string $download_name
 * @property int $version
 * @property bool $hidden
 * @property \Cake\I18n\Time $addition_date
 * @property \Cake\I18n\Time $update_date
 * @property string $description
 * @property \App\Model\Entity\Bid[] $bids
 */
class Product extends Entity
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
        'is_hidden'
    ];

    protected function _getIsHidden()
    {
        return $this->_properties['hidden'] ? 'Да' : 'Нет';
    }
}
