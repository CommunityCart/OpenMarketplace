<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InvitesFinalizedTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InvitesFinalizedTable Test Case
 */
class InvitesFinalizedTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\InvitesFinalizedTable
     */
    public $InvitesFinalized;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.invites_finalized',
        'app.orders',
        'app.users',
        'app.social_accounts',
        'app.users_subscriptions',
        'app.orders',
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
        'app.wallets',
        'app.currencies',
        'app.user_transactions',
        'app.disputes',
        'app.reviews'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('InvitesFinalized') ? [] : ['className' => InvitesFinalizedTable::class];
        $this->InvitesFinalized = TableRegistry::get('InvitesFinalized', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->InvitesFinalized);

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
