<?php
use Migrations\AbstractMigration;

class FixUserIdInMessages extends AbstractMigration
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
        $table = $this->table('messages');
        $table->changeColumn('user_id', 'string', [
            'default' => '',
            'limit' => 255,
            'null' => false,
        ]);
        $table->update();
    }
}
