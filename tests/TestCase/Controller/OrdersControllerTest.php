<?php
namespace App\Test\TestCase\Controller;

use App\Controller\OrdersController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\OrdersController Test Case
 */
class OrdersControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.orders',
        'app.users',
        'app.social_accounts',
        'app.users_subscriptions',
        'app.products',
        'app.vendors',
        'app.messages',
        'app.message_messages',
        'app.shipping_options',
        'app.product_categories',
        'app.countries',
        'app.product_countries',
        'app.product_images',
        'app.products_favorite',
        'app.products_featured',
        'app.wallet_transactions',
        'app.disputes',
        'app.reviews'
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
