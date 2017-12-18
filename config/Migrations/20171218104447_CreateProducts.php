<?php
use Migrations\AbstractMigration;

class CreateProducts extends AbstractMigration
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
        $table = $this->table('products');
        $table->addColumn('vendor_id', 'integer', [
            'null' => false,
        ]);
        $table->addColumn('title','string', [
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('desc', 'text', [
            'null' => false,
        ]);
        $table->addColumn('cost','float', [
            'null' => false,
        ]);
        $table->addColumn('product_category_id', 'integer', [
            'null' => false,
        ]);
        $table->addColumn('country_id', 'integer', [
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => true,
        ]);
        $table->create();
    }
}
