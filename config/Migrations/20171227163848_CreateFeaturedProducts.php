<?php
use Migrations\AbstractMigration;

class CreateFeaturedProducts extends AbstractMigration
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
        $table = $this->table('products_featured');
        $table->addColumn('product_id', 'integer', [
            'null' => false,
        ]);
        $table->create();
    }
}
