<?php
use Migrations\AbstractMigration;

class CreateProductCountries extends AbstractMigration
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
        $table = $this->table('product_countries');
        $table->addColumn('product_id', 'integer', [
            'null' => false,
        ]);
        $table->addColumn('country_id','integer', [
            'null' => false,
        ]);

        $table->create();
    }
}
