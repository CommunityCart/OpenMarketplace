<?php

namespace App\Utility;

use App\Utility\Tables;

class Products
{
    // TODO: Find places where we did not use this and replace with this.
    public static function getProduct($product_id)
    {
        $productsTable = Tables::getProductsTable();

        $product = $productsTable->find('all')->where(['id' => $product_id])->first();

        return $product;
    }
}