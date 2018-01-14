<?php
use Migrations\AbstractMigration;

class CreateInvites extends AbstractMigration
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
        $table = $this->table('invites');
        $table->addColumn('user_id', 'string', [
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('code', 'string', [
            'limit' => 64,
            'null' => false,
        ]);
        $table->addColumn('count_left', 'integer', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('count_claimed', 'integer', [
            'default' => 0,
            'null' => false,
        ]);
        $table->create();

        $table = $this->table('invites_claimed');
        $table->addColumn('invite_id', 'integer', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('user_id', 'string', [
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('upgraded_to_vendor', 'integer', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('vendor_id', 'integer', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'null' => false,
        ]);
        $table->create();
    }
}
