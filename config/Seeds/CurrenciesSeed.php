<?php
use Migrations\AbstractSeed;

/**
 * Currencies seed.
 */
class CurrenciesSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'US Dollar', 'symbol' => 'USD'],
            ['name' => 'Euro', 'symbol' => 'EUR'],
            ['name' => 'Canadian Dollar', 'symbol' => 'CAD'],
            ['name' => 'Cash Money Coin', 'symbol' => 'CMC'],
        ];

        $table = $this->table('currencies');
        $table->insert($data)->save();
    }
}
