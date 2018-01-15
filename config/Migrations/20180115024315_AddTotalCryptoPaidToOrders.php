<?php
use Migrations\AbstractMigration;

class AddTotalCryptoPaidToOrders extends AbstractMigration
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
        $table->addColumn('order_total_crypto_paid', 'string', [
            'default' => 0,
            'null' => false
        ]);
        $table->update();
    }
}
