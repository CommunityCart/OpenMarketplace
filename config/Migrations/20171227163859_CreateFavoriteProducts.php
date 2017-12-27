<?php
use Migrations\AbstractMigration;

class CreateFavoriteProducts extends AbstractMigration
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
        $table = $this->table('products_favorite');
        $table->addColumn('product_id', 'integer', [
            'null' => false,
        ]);
        $table->addColumn('user_id', 'string', [
            'null' => false,
        ]);
        $table->create();
    }
}
