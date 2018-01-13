<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WalletTransactionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WalletTransactionsTable Test Case
 */
class WalletTransactionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WalletTransactionsTable
     */
    public $WalletTransactions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.wallet_transactions',
        'app.wallets',
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
        'app.disputes',
        'app.reviews',
        'app.product_countries',
        'app.product_images',
        'app.products_favorite',
        'app.products_featured',
        'app.currencies',
        'app.user_transactions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('WalletTransactions') ? [] : ['className' => WalletTransactionsTable::class];
        $this->WalletTransactions = TableRegistry::get('WalletTransactions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->WalletTransactions);

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
