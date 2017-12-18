<?php
use Migrations\AbstractMigration;

class CreateUserWithdrawals extends AbstractMigration
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
        $table = $this->table('user_transactions');
        $table->addColumn('user_id','integer', [
            'null' => false,
        ]);
        $table->addColumn('wallet_transaction_id','integer', [
            'null' => false,
        ]);
        $table->addColumn('is_withdrawal','integer', [
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
