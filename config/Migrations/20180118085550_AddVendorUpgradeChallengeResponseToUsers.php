<?php
use Migrations\AbstractMigration;

class AddVendorUpgradeChallengeResponseToUsers extends AbstractMigration
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
        $table->addColumn('vendor_challenge', 'text', [
            'null' => true
        ]);
        $table->addColumn('vendor_challenge_response', 'string', [
            'default' => '',
            'limit' => 16,
            'null' => true
        ]);
        $table->update();
    }
}
