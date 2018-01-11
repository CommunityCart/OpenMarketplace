<?php
use Migrations\AbstractMigration;

class AddDatesToOrders extends AbstractMigration
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
        $table = $this->table('orders');
        $table->addColumn('accepted', 'datetime', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('shipped', 'datetime', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('finalized', 'datetime', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('rated', 'datetime', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}
