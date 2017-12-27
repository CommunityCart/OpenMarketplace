<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductsFavoriteTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProductsFavoriteTable Test Case
 */
class ProductsFavoriteTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductsFavoriteTable
     */
    public $ProductsFavorite;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.products_favorite',
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
        'app.product_images',
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
        $config = TableRegistry::exists('ProductsFavorite') ? [] : ['className' => ProductsFavoriteTable::class];
        $this->ProductsFavorite = TableRegistry::get('ProductsFavorite', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProductsFavorite);

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
