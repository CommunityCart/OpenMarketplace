<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InvitesFinalized Entity
 *
 * @property int $id
 * @property int $order_id
 * @property float $commission
 * @property \Cake\I18n\FrozenTime $finalized
 * @property int $invite_id
 *
 * @property \App\Model\Entity\Order $order
 */
class InvitesFinalized extends Entity
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
        'order_id' => true,
        'commission' => true,
        'finalized' => true,
        'invite_id' => true,
        'order' => true
    ];
}
