<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Vendor Entity
 *
 * @property int $id
 * @property string $user_id
 * @property string $title
 * @property string $tos
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $last_active
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Message[] $messages
 * @property \App\Model\Entity\Product[] $products
 */
class Vendor extends Entity
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
        'title' => true,
        'tos' => true,
        'created' => true,
        'modified' => true,
        'last_active' => true,
        'user' => true,
        'messages' => true,
        'products' => true
    ];
}
