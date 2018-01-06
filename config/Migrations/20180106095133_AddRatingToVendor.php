<?php
use Migrations\AbstractMigration;

class AddRatingToVendor extends AbstractMigration
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
        $table = $this->table('vendors');
        $table->addColumn('rating', 'float', [
            'default' => 0,
            'null' => false,
        ]);
        $table->update();
    }
}
