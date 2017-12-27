<?php
namespace App\Test\TestCase\Controller;

use App\Controller\VendorsController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\VendorsController Test Case
 */
class VendorsControllerTest extends IntegrationTestCase
{

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
