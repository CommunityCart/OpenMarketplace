<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Wallet Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $currency_id
 * @property string $address
 * @property string $private_key
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Currency $currency
 * @property \App\Model\Entity\WalletTransaction[] $wallet_transactions
 */
class Wallet extends Entity
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
        'currency_id' => true,
        'address' => true,
        'private_key' => true,
        'created' => true,
        'user' => true,
        'currency' => true,
        'wallet_transactions' => true
    ];
}
