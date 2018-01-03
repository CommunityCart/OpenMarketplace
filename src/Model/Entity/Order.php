<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Order Entity
 *
 * @property int $id
 * @property string $user_id
 * @property int $product_id
 * @property int $wallet_transaction_id
 * @property \Cake\I18n\FrozenTime $created
 * @property int $status
 * @property int $shipping_option_id
 * @property int $quantity
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Product $product
 * @property \App\Model\Entity\WalletTransaction $wallet_transaction
 * @property \App\Model\Entity\Dispute[] $disputes
 * @property \App\Model\Entity\Review[] $reviews
 */
class Order extends Entity
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
        'product_id' => true,
        'wallet_transaction_id' => true,
        'created' => true,
        'status' => true,
        'shipping_option_id' => true,
        'quantity' => true,
        'user' => true,
        'product' => true,
        'wallet_transaction' => true,
        'disputes' => true,
        'reviews' => true
    ];
}
