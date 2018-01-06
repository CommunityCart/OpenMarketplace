<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * WalletTransaction Entity
 *
 * @property int $id
 * @property int $wallet_id
 * @property string $transaction_hash
 * @property string $transaction_details
 * @property float $balance
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\Wallet $wallet
 * @property \App\Model\Entity\Order[] $orders
 * @property \App\Model\Entity\UserTransaction[] $user_transactions
 */
class WalletTransaction extends Entity
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
        'wallet_id' => true,
        'transaction_hash' => true,
        'transaction_details' => true,
        'balance' => true,
        'created' => true,
        'wallet' => true,
        'orders' => true,
        'user_transactions' => true
    ];
}
