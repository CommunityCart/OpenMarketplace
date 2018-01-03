<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShippingOption Entity
 *
 * @property int $id
 * @property int $vendor_id
 * @property string $shipping_name
 * @property string $shipping_carrier
 * @property string $shipping_cost
 *
 * @property \App\Model\Entity\Vendor $vendor
 */
class ShippingOption extends Entity
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
        'vendor_id' => true,
        'shipping_name' => true,
        'shipping_carrier' => true,
        'shipping_cost' => true,
        'vendor' => true
    ];
}
