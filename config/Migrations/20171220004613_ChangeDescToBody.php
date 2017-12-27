<?php
use Migrations\AbstractMigration;

class ChangeDescToBody extends AbstractMigration
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
        $table = $this->table('products');
        $table->renameColumn('desc','body');
        $table->update();
    }
}
