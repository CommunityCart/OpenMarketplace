<?php
use Migrations\AbstractMigration;

class CreateExchangeRates extends AbstractMigration
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
        $table = $this->table('exchange_rates');
        $table->addColumn('one_unit_of_symbol', 'string', [
            'null' => false,
        ]);
        $table->addColumn('is_equal_to', 'float', [
            'null' => false,
        ]);
        $table->addColumn('in_symbol', 'string', [
            'null' => false,
        ]);
        $table->create();
    }
}
