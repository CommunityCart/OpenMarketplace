<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InvitesClaimedTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InvitesClaimedTable Test Case
 */
class InvitesClaimedTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\InvitesClaimedTable
     */
    public $InvitesClaimed;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.invites_claimed',
        'app.invites',
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
        'app.orders',
        'app.wallet_transactions',
        'app.wallets',
        'app.currencies',
        'app.user_transactions',
        'app.disputes',
        'app.reviews',
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
        $config = TableRegistry::exists('InvitesClaimed') ? [] : ['className' => InvitesClaimedTable::class];
        $this->InvitesClaimed = TableRegistry::get('InvitesClaimed', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->InvitesClaimed);

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
