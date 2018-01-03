<?php
use Migrations\AbstractMigration;

class CreateShippingOptions extends AbstractMigration
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
        $table = $this->table('shipping_options');
        $table->addColumn('vendor_id', 'integer', [
            'null' => false,
        ]);
        $table->addColumn('shipping_name', 'string', [
            'null' => false,
            'limit' => 64
        ]);
        $table->addColumn('shipping_carrier', 'string', [
            'null' => false,
            'limit' => 64
        ]);
        $table->addColumn('shipping_cost', 'string', [
            'null' => false,
            'limit' => 64
        ]);
        $table->create();
    }
}
