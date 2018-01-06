<?php
use Migrations\AbstractMigration;

class AddRatingToProduct extends AbstractMigration
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
        $table->addColumn('rating', 'float', [
            'default' => 0,
            'null' => false,
        ]);
        $table->update();
    }
}
