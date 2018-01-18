<?php
use Migrations\AbstractMigration;

class AddViewedToUsers extends AbstractMigration
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
        $table->addColumn('viewed_shopping_cart', 'integer', [
            'default' => 0,
            'null' => false
        ]);
        $table->addColumn('viewed_wallet', 'integer', [
            'default' => 0,
            'null' => false
        ]);
        $table->addColumn('viewed_disputes', 'integer', [
            'default' => 0,
            'null' => false
        ]);
        $table->addColumn('viewed_invites', 'integer', [
            'default' => 0,
            'null' => false
        ]);
        $table->addColumn('viewed_featured', 'integer', [
            'default' => 0,
            'null' => false
        ]);
        $table->addColumn('viewed_favorited', 'integer', [
            'default' => 0,
            'null' => false
        ]);
        $table->update();

        $table = $this->table('vendors');
        $table->addColumn('viewed_incoming', 'integer', [
            'default' => 0,
            'null' => false
        ]);
        $table->addColumn('viewed_finalized', 'integer', [
            'default' => 0,
            'null' => false
        ]);
        $table->addColumn('viewed_disputed', 'integer', [
            'default' => 0,
            'null' => false
        ]);
        $table->update();
    }
}
