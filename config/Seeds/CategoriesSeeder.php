<?php

use Phinx\Seed\AbstractSeed;

class CategoriesSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [
            ['product_category_id' => '0', 'category_name' => 'Product Categories']
        ];

        $table = $this->table('product_categories');
        $table->insert($data)->save();
    }
}
