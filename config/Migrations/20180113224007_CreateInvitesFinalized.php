<?php
use Migrations\AbstractMigration;

class CreateInvitesFinalized extends AbstractMigration
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
        $table = $this->table('invites_finalized');
        $table->addColumn('order_id', 'integer', [
            'null' => false,
        ]);
        $table->addColumn('commission', 'float', [
            'null' => false,
        ]);
        $table->addColumn('finalized', 'datetime', [
            'null' => false,
        ]);
        $table->create();
    }
}
