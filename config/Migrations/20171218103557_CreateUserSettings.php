<?php
use Migrations\AbstractMigration;

class CreateUserSettings extends AbstractMigration
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
        $table = $this->table('user_settings');
        $table->addColumn('pgp', 'text', [
            'null' => false,
        ]);
        $table->addColumn('login_method','integer', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('preferred_currency','integer', [
            'default' => 0,
            'null' => false,
        ]);
        $table->addColumn('avatar_b64','text', [
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => true,
        ]);
        $table->create();
    }
}
