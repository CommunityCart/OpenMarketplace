<?php
use Migrations\AbstractMigration;

class AddPaidToOrders extends AbstractMigration
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
        $table->addColumn('paid_vendor', 'integer', [
            'default' => 0,
            'null' => true,
        ]);
        $table->addColumn('paid_commission_vendor', 'integer', [
            'default' => 0,
            'null' => true,
        ]);
        $table->addColumn('paid_commission_user', 'integer', [
            'default' => 0,
            'null' => true,
        ]);
        $table->addColumn('paid_commission_admins', 'string', [
            'default' => 0,
            'limit' => 512,
            'null' => true,
        ]);
        $table->addColumn('paid_commission_superadmin', 'integer', [
            'default' => 0,
            'null' => true,
        ]);
        $table->update();
    }
}
