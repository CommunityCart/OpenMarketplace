<?php
use Migrations\AbstractMigration;

class AddShippingDetailsToOrders extends AbstractMigration
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
        $table->addColumn('shipping_details', 'text', [
            'null' => true,
        ]);
        $table->update();
    }
}
