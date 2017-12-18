<?php
use Migrations\AbstractMigration;

class CreateWalletTransactions extends AbstractMigration
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
        $table->addColumn('wallet_id', 'integer', [
            'null' => false,
        ]);
        $table->addColumn('transaction_hash','string', [
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('transaction_details', 'text', [
            'null' => false,
        ]);
        $table->addColumn('balance','float', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => true,
        ]);
        $table->create();
    }
}
