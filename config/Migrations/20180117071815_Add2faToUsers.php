<?php
use Migrations\AbstractMigration;

class Add2faToUsers extends AbstractMigration
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
        $table = $this->table('users');
        $table->addColumn('2fa', 'integer', [
            'default' => 0,
            'null' => false,
        ]);
        $table->update();
    }
}
