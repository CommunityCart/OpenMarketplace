<?php
use Migrations\AbstractMigration;

class CreateWallets extends AbstractMigration
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
        $table->addColumn('user_id', 'integer', [
            'null' => false,
        ]);
        $table->addColumn('currency_id','integer', [
            'null' => false,
        ]);
        $table->addColumn('address', 'text', [
            'null' => false,
        ]);
        $table->addColumn('private_key','text', [
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => true,
        ]);
        $table->create();
    }
}
