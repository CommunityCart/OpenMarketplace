<?php
use Migrations\AbstractMigration;

class AddInviteIdToInvitesFinalized extends AbstractMigration
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
        $table->addColumn('invite_id', 'integer', [
            'null' => false,
        ]);
        $table->update();
    }
}
