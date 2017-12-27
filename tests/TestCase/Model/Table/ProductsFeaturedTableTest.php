<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductsFeaturedTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProductsFeaturedTable Test Case
 */
class ProductsFeaturedTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductsFeaturedTable
     */
    public $ProductsFeatured;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.products_featured',
        'app.products',
        'app.vendors',
        'app.users',
        'app.social_accounts',
        'app.users_subscriptions',
        'app.messages',
        'app.message_messages',
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
        $config = TableRegistry::exists('ProductsFeatured') ? [] : ['className' => ProductsFeaturedTable::class];
        $this->ProductsFeatured = TableRegistry::get('ProductsFeatured', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProductsFeatured);

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
