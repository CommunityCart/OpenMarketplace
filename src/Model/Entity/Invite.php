<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Invite Entity
 *
 * @property int $id
 * @property string $user_id
 * @property string $code
 * @property int $count_left
 * @property int $count_claimed
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\InvitesClaimed[] $invites_claimed
 */
class Invite extends Entity
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
        'user_id' => true,
        'code' => true,
        'count_left' => true,
        'count_claimed' => true,
        'user' => true,
        'invites_claimed' => true
    ];
}
