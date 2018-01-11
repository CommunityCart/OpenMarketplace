<?php
use Migrations\AbstractMigration;

class AddColumnsToDisputes2 extends AbstractMigration
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
        $table = $this->table('disputes');
        $table->addColumn('completed', 'integer', [
            'default' => 0,
            'null' => true,
        ]);
        $table->addColumn('refunded', 'integer', [
            'default' => 0,
            'null' => true,
        ]);
        $table->update();
    }
}
