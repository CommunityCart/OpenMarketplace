<?php
use Migrations\AbstractMigration;

class AddReadColumnsToMessages extends AbstractMigration
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
        $table->addColumn('user_read', 'integer', [
            'default' => 0,
            'null' => false
        ]);
        $table->addColumn('vendor_read', 'integer', [
            'default' => 0,
            'null' => false
        ]);
        $table->update();
    }
}
