<?php
use Migrations\AbstractMigration;

class CreateVendors extends AbstractMigration
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
        $table = $this->table('vendors');
        $table->addColumn('user_id', 'integer', [
            'null' => false,
        ]);
        $table->addColumn('title','string', [
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('tos', 'text', [
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('last_active', 'datetime', [
            'default' => null,
            'null' => true,
        ]);
        $table->create();
    }
}
