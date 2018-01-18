<?php
use Migrations\AbstractMigration;

class AddViewedRedToUsers extends AbstractMigration
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
        $table = $this->table('users');
        $table->addColumn('viewed_shopping_cart_red', 'integer', [
            'default' => 0,
            'null' => false
        ]);
        $table->update();
    }
}
