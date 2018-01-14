<?php
use Migrations\AbstractMigration;

class AddCryptoTotalToOrders extends AbstractMigration
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
        $table->addColumn('order_total_dollars', 'float', [
            'default' => 0,
            'null' => true,
        ]);
        $table->addColumn('order_total_crypto', 'string', [
            'default' => 0,
            'null' => true,
        ]);
        $table->update();
    }
}
