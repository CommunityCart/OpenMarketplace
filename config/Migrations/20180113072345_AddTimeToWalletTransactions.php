<?php
use Migrations\AbstractMigration;

class AddTimeToWalletTransactions extends AbstractMigration
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
        $table = $this->table('wallet_transactions');
        $table->addColumn('transaction_time', 'string', [
            'default' => 0,
            'null' => true,
        ]);
        $table->update();
    }
}
