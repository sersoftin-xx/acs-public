<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Pc Entity.
 *
 * @property int $id
 * @property int $client_id
 * @property \App\Model\Entity\Client $client
 * @property string $name
 * @property string $unique_key
 * @property \Cake\I18n\Time $addition_date
 * @property string $comment
 * @property \App\Model\Entity\Bid[] $bids
 */
class Pc extends Entity
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
}
