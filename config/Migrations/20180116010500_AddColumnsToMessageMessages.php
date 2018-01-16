<?php
use Migrations\AbstractMigration;

class AddColumnsToMessageMessages extends AbstractMigration
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
        $table = $this->table('message_messages');
        $table->addColumn('from_user', 'integer', [
            'default' => 0,
            'null' => false
        ]);
        $table->addColumn('from_vendor', 'integer', [
            'default' => 0,
            'null' => false
        ]);
        $table->update();
    }
}
