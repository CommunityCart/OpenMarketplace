<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ShippingOptionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ShippingOptionsTable Test Case
 */
class ShippingOptionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ShippingOptionsTable
     */
    public $ShippingOptions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.shipping_options',
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
        'app.product_images',
        'app.products_favorite',
        'app.products_featured'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ShippingOptions') ? [] : ['className' => ShippingOptionsTable::class];
        $this->ShippingOptions = TableRegistry::get('ShippingOptions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ShippingOptions);

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
