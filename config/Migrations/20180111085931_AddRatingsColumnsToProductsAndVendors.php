<?php
use Migrations\AbstractMigration;

class AddRatingsColumnsToProductsAndVendors extends AbstractMigration
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
        $table->addColumn('total_stars', 'integer', [
            'default' => 0,
            'null' => true,
        ]);
        $table->addColumn('total_reviews', 'integer', [
            'default' => 0,
            'null' => true,
        ]);
        $table->update();

        $table = $this->table('vendors');
        $table->addColumn('total_stars', 'integer', [
            'default' => 0,
            'null' => true,
        ]);
        $table->addColumn('total_reviews', 'integer', [
            'default' => 0,
            'null' => true,
        ]);
        $table->update();
    }
}
