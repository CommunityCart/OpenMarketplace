<?php
use Migrations\AbstractMigration;

class ChangeBalanceToStringToWalletTransactions extends AbstractMigration
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
        $table->changeColumn('balance', 'string', [
            'default' => 0,
            'null' => true,
        ]);
        $table->update();
    }
}
