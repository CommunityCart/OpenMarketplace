<?php
use Migrations\AbstractMigration;

class CreateCountries extends AbstractMigration
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
        $table = $this->table('countries');
        $table->addColumn('name', 'string', [
            'default' => '',
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('symbol','string', [
            'default' => 0,
            'limit' => 5,
            'null' => false,
        ]);
        $table->create();
    }
}
