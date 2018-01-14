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
 * @property string $shipping_details
 * @property \Cake\I18n\FrozenTime $accepted
 * @property \Cake\I18n\FrozenTime $shipped
 * @property \Cake\I18n\FrozenTime $finalized
 * @property \Cake\I18n\FrozenTime $rated
 * @property int $finalize_early
 * @property int $paid_vendor
 * @property int $paid_commission_vendor
 * @property int $paid_commission_user
 * @property string $paid_commission_admins
 * @property int $paid_commission_superadmin
 * @property float $order_total_dollars
 * @property string $order_total_crypto
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Product $product
 * @property \App\Model\Entity\WalletTransaction $wallet_transaction
 * @property \App\Model\Entity\ShippingOption $shipping_option
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
        'shipping_details' => true,
        'accepted' => true,
        'shipped' => true,
        'finalized' => true,
        'rated' => true,
        'finalize_early' => true,
        'paid_vendor' => true,
        'paid_commission_vendor' => true,
        'paid_commission_user' => true,
        'paid_commission_admins' => true,
        'paid_commission_superadmin' => true,
        'order_total_dollars' => true,
        'order_total_crypto' => true,
        'user' => true,
        'product' => true,
        'wallet_transaction' => true,
        'shipping_option' => true,
        'disputes' => true,
        'reviews' => true
    ];
}
