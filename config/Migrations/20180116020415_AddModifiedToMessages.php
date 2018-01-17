<?php
use Migrations\AbstractMigration;

class AddModifiedToMessages extends AbstractMigration
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
        $table->addColumn('modified', 'datetime', [
            'null' => true
        ]);
        $table->update();
    }
}
