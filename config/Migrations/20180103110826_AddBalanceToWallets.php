<?php
use Migrations\AbstractMigration;

class AddBalanceToWallets extends AbstractMigration
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
        $table = $this->table('wallets');
        $table->addColumn('wallet_balance','float', [
            'default' => 0,
            'null' => false,
        ]);
        $table->update();
    }
}
