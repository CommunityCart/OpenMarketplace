<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Product Entity
 *
 * @property int $id
 * @property int $vendor_id
 * @property string $title
 * @property string $body
 * @property float $cost
 * @property int $product_category_id
 * @property int $country_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Vendor $vendor
 * @property \App\Model\Entity\ProductCategory $product_category
 * @property \App\Model\Entity\Country $country
 * @property \App\Model\Entity\Order[] $orders
 * @property \App\Model\Entity\ProductCountry[] $product_countries
 * @property \App\Model\Entity\ProductImage[] $product_images
 */
class Product extends Entity
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
        'title' => true,
        'body' => true,
        'cost' => true,
        'product_category_id' => true,
        'country_id' => true,
        'created' => true,
        'modified' => true,
        'vendor' => true,
        'product_category' => true,
        'country' => true,
        'orders' => true,
        'product_countries' => true,
        'product_images' => true
    ];
}
