<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductCategory Entity
 *
 * @property int $id
 * @property int $product_category_id
 * @property string $category_name
 *
 * @property \App\Model\Entity\ProductCategory[] $product_categories
 * @property \App\Model\Entity\Product[] $products
 */
class ProductCategory extends Entity
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
        'product_category_id' => true,
        'category_name' => true,
        'product_categories' => true,
        'products' => true
    ];
}
