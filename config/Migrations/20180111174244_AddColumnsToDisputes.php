<?php
use Migrations\AbstractMigration;

class AddColumnsToDisputes extends AbstractMigration
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
        $table->addColumn('never_arrived', 'integer', [
            'default' => 0,
            'null' => true,
        ]);
        $table->addColumn('wrong_product', 'integer', [
            'default' => 0,
            'null' => true,
        ]);
        $table->addColumn('bad_quality', 'integer', [
            'default' => 0,
            'null' => true,
        ]);
        $table->addColumn('other', 'integer', [
            'default' => 0,
            'null' => true,
        ]);
        $table->update();
    }
}
