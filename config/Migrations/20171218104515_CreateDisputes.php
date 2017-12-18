<?php
use Migrations\AbstractMigration;

class CreateDisputes extends AbstractMigration
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
        $table->addColumn('order_id', 'integer', [
            'null' => false,
        ]);
        $table->addColumn('comment', 'text', [
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => true,
        ]);
        $table->create();
    }
}
