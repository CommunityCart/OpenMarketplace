<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InvitesClaimed Entity
 *
 * @property int $id
 * @property int $invite_id
 * @property string $user_id
 * @property int $upgraded_to_vendor
 * @property int $vendor_id
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\Invite $invite
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Vendor $vendor
 */
class InvitesClaimed extends Entity
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
        'invite_id' => true,
        'user_id' => true,
        'upgraded_to_vendor' => true,
        'vendor_id' => true,
        'created' => true,
        'invite' => true,
        'user' => true,
        'vendor' => true
    ];
}
