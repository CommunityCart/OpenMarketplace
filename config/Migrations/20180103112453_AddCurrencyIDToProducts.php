<?php
use Migrations\AbstractMigration;

class AddCurrencyIDToProducts extends AbstractMigration
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
        $table->addColumn('currency_id','integer', [
            'default' => null,
            'null' => false,
        ]);
        $table->update();
    }
}
