<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VendorsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VendorsTable Test Case
 */
class VendorsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\VendorsTable
     */
    public $Vendors;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.vendors',
        'app.users',
        'app.social_accounts',
        'app.users_subscriptions',
        'app.messages',
        'app.message_messages',
        'app.products',
        'app.product_categories',
        'app.countries',
        'app.orders',
        'app.product_countries',
        'app.product_images'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Vendors') ? [] : ['className' => VendorsTable::class];
        $this->Vendors = TableRegistry::get('Vendors', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Vendors);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
