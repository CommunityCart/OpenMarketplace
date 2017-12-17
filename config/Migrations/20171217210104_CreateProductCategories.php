<?php
use Migrations\AbstractMigration;

class CreateProductCategories extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('product_categories');
        $table->addColumn('product_category_id', 'integer', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('category_name','string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->create();
    }
}
