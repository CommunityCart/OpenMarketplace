<?php
use Migrations\AbstractSeed;

/**
 * Countries2 seed.
 */
class Countries2Seed extends AbstractSeed
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
            ['name' => 'World Wide', 'symbol' => 'WW']
        ];

        $table = $this->table('countries');
        $table->insert($data)->save();
    }
}
