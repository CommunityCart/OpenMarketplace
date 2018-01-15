<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use App\Utility\Sidebar;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Controller\Component\AuthComponent;
use Cake\ORM\Table;
use App\Utility\Litecoin;
use Cake\Cache\Cache;
use Cake\Utility\Security;
use App\Utility\Math;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('CakeDC/Users.UsersAuth');
        $this->loadComponent('Security');
        $this->loadComponent('Csrf');

        $this->Auth->configShallow('loginRedirect', '/dashboard?collapse=false');
        $this->Auth->configShallow('logoutRedirect', '/login');
        $this->Auth->allow(['register', 'requestResetPassword', 'captcha', 'logout']);

        $this->viewBuilder()->setTheme('AdminLTE');

        $this->viewBuilder()->setClassName('AdminLTE.AdminLTE');
    }

    public function beforeRender(Event $event)
    {
        $this->doWallet();

        $collapse = $this->getCollapse();

        $this->set('menus', $this->buildMenus($collapse));

        return parent::beforeRender($event);
    }

    private function doWallet()
    {
        if(!isset($this->Auth) || $this->Auth->user('id') === null) {

            return;
        }

        $this->loadModel('Wallets');
        $this->loadModel('WalletTransactions');

        $wallets = $this->Wallets->find('all')->where(['user_id' => $this->Auth->user('id')])->all();

        $litecoin = new Litecoin();

        $account = $this->Auth->user('id');

        if($account == '3dcd5245-6bd1-4685-a539-c51742042d71')
        {
            $account = 'hello';
        }

        if(!isset($wallets) || count($wallets) == 0) {

            $firstWallet = $litecoin->generateNewDepositAddress($account);
            $privateKeyUnencrypted = $litecoin->getPrivateKeyByAddress($firstWallet);
            // $privateKey = Security::encrypt($privateKeyUnencrypted, Configure::read('cryptokey'));

            $newWallet = $this->Wallets->newEntity([
                'user_id' => $this->Auth->user('id'),
                'currency_id' => 4,
                'address' => $firstWallet,
                'private_key' => $privateKeyUnencrypted,
                'wallet_balance' => 0,
                'created' => new \DateTime('now')
            ]);

            $this->Wallets->save($newWallet);
        }
        else {

            $usersTable = \App\Utility\Wallet::getUsersTable();

            $user = $usersTable->find('all')->where(['id' => $this->Auth->user('id')])->first();

            $user->set('balance', number_format($litecoin->checkAccountForBalance($account), 8));
            $usersTable->save($user);

            $cacheTimestamp = Cache::read($this->Auth->user('id') . '.wallet_balances', 'memcache');

            if(isset($cacheTimestamp) && $cacheTimestamp != false) {

                $now = new \DateTime('now');
                $diff = $now->diff($cacheTimestamp);
            }
            else {

                $cacheTimestamp = new \DateTime('now');
                $now = new \DateTime('now');
                $diff = $now->diff($cacheTimestamp);
            }

            if($cacheTimestamp == '' || (($diff->i * 60) + $diff->s) > 300) {

                foreach ($wallets as $wallet) {

                    $response = $litecoin->checkAddressForDeposit($wallet->get('address'));

                    $wallet->set('wallet_balance', number_format($response, 8));

                    $this->Wallets->save($wallet);
                }

                Cache::write($this->Auth->user('id') . '.wallet_balances', new \DateTime('now'), 'memcache');
            }
            else {

                return;
            }
        }

        $lastWallet = $this->Wallets->find('all')->where(['user_id' => $this->Auth->user('id')])->last();

        if($lastWallet->get('wallet_balance') > 0) {

            $nextWallet = $litecoin->generateNewDepositAddress($account);
            $privateKeyUnencrypted = $litecoin->getPrivateKeyByAddress($nextWallet);
            // $privateKey = Security::encrypt($privateKeyUnencrypted, Configure::read('cryptokey'));

            $newNextWallet = $this->Wallets->newEntity([
                'user_id' => $this->Auth->user('id'),
                'currency_id' => 4,
                'address' => $nextWallet,
                'private_key' => $privateKeyUnencrypted,
                'wallet_balance' => 0,
                'created' => new \DateTime('now')
            ]);

            $this->Wallets->save($newNextWallet);
        }

        $accountTransactions = $litecoin->getTransactionsByAccount($account);

        foreach($accountTransactions as $accountTransaction) {

            if(isset($accountTransaction['address'])) {

                $wallet = $this->Wallets->find('all')->where(['address' => $accountTransaction['address']])->first();
            }
            else {

                $wallet = $this->Wallets->find('all')->where(['user_id' => $this->Auth->user('id')])->first();
            }

            // TODO: Do not query database for 'move' category
            // TODO: Insert 'move' transactions via the LiteCoin Utility move method
            if($accountTransaction['category'] == 'move'){

                $amount = $accountTransaction['amount'];

                if($amount > 0) {
                    $accountTransaction['txid'] = '(receive) internal funds transfer';
                }
                else {
                    $accountTransaction['txid'] = '(send) internal funds transfer';
                }

                $walletTransaction = $this->WalletTransactions->find('all')->where(['transaction_hash' => $accountTransaction['txid'], 'transaction_time' => $accountTransaction['time']])->first();
            }
            else {

                $walletTransaction = $this->WalletTransactions->find('all')->where(['transaction_hash' => $accountTransaction['txid']])->first();
            }

            if(!isset($walletTransaction))
            {
                $amount = 0;

                if($accountTransaction['category'] == 'receive')
                {
                    $amount = $accountTransaction['amount'];
                }
                else if($accountTransaction['category'] == 'send')
                {
                    $amount = -$accountTransaction['amount'];
                }
                else
                {
                    $amount = $accountTransaction['amount'];

                    if($amount > 0) {
                        $accountTransaction['txid'] = '(receive) internal funds transfer';
                    }
                    else {
                        $accountTransaction['txid'] = '(send) internal funds transfer';
                    }
                }

                $amount = number_format($amount, 8);

                if($accountTransaction['category'] == 'move') {

                    $walletTransactionEntity = $this->WalletTransactions->newEntity([
                        'wallet_id' => $wallet->get('id'),
                        'transaction_hash' => $accountTransaction['txid'],
                        'transaction_details' => json_encode($accountTransaction),
                        'balance' => $amount,
                        'created' => new \DateTime('now'),
                        'transaction_time' => $accountTransaction['time']
                    ]);
                }
                else
                {
                    $walletTransactionEntity = $this->WalletTransactions->newEntity([
                        'wallet_id' => $wallet->get('id'),
                        'transaction_hash' => $accountTransaction['txid'],
                        'transaction_details' => json_encode($accountTransaction),
                        'balance' => $amount,
                        'created' => new \DateTime('now'),
                        'transaction_time' => $accountTransaction['time']
                    ]);
                }

                $this->WalletTransactions->save($walletTransactionEntity);
            }
            else {

                if(isset($accountTransaction['confirmations']) && $walletTransaction->get('confirmations') < 10) {

                    $walletTransaction->set('confirmations', $accountTransaction['confirmations']);
                    $this->WalletTransactions->save($walletTransaction);
                }
            }
        }
    }

    private function getCollapse()
    {
        $here = $this->request->getRequestTarget();

        if(strpos($here, 'collapse=true') !== FALSE) {

            $this->set('bodycollapse', 'sidebar-collapse');
        }
        else {
            $this->set('bodycollapse', '');
        }

        if(strpos($here, 'collapse=true') !== FALSE) {
            $collapse = 'collapse=true';
        }
        else
        {
            $collapse = 'collapse=false';
        }

        if(strpos($here, '?') > 0 && strpos($here, '=') > 0 && strpos($here, 'collapse=') === FALSE) {
            $this->set('navtoggle', str_replace('collapse=true', '', str_replace('collapse=false', '',str_replace('&collapse=true', '', str_replace('&collapse=false', '', $this->request->getRequestTarget())))) . 'collapse=true');
        }
        else if(strpos($here, 'collapse=') === FALSE) {
            $this->set('navtoggle', str_replace('collapse=true', '', str_replace('collapse=false', '',str_replace('&collapse=true', '', str_replace('&collapse=false', '', $this->request->getRequestTarget())))) . '?collapse=true');
        }
        else {
            if(strpos($here, 'true') > 0) {
                $this->set('navtoggle', str_replace('collapse=true', 'collapse=false', $here));
            }
            else {
                $this->set('navtoggle', str_replace('collapse=false', 'collapse=true', $here));
            }
        }

        return $collapse;
    }

    private function getChildCategories($id, $collapse)
    {
        $productCategoriesTable = TableRegistry::get('product_categories');
        $productCategoriesQuery = $productCategoriesTable->find('all')->where(['product_category_id' => $id]);
        $productCategoriesResult = $productCategoriesQuery->all();

        $product_categories = array();
        foreach($productCategoriesResult as $productCategory) {
            $product_categories[$productCategory->get('category_name')] = [
                'path' => '/shop?product_category_id=' . $productCategory->get('id') . '&' . $collapse,
                'menu' => $this->getChildCategories($productCategory->get('id'), $collapse),
                'icon' => 'fa-plus-square'
            ];
        }

        return $product_categories;
    }

    private function buildMenus($collapse)
    {
        if(method_exists($this->Auth, 'user')) {

            if ($this->Auth->user('id')) {

                $currentId = $this->Auth->user('id');

                $currentUser = TableRegistry::get(Configure::read('Users.table'))->get($this->Auth->user('id'));

                $productCategoriesTable = TableRegistry::get('product_categories');
                $productCategoriesQuery = $productCategoriesTable->find('all')->where(['product_category_id' => 0]);
                $productCategoriesResult = $productCategoriesQuery->all();

                $product_categories = array();

                $product_categories['Featured Products'] = [
                    'path' => '/shop?' . $collapse,
                    'icon' => 'fa-check-square-o'
                ];

                $product_categories['Favorited Products'] = [
                    'path' => '/favorites?' . $collapse,
                    'icon' => 'fa-check-square'
                ];

                foreach($productCategoriesResult as $productCategory) {
                    $product_categories[$productCategory->get('category_name')] = [
                        'path' => '/shop?product_category_id=' . $productCategory->get('id') . '&' . $collapse,
                        'menu' => $this->getChildCategories($productCategory->get('id'), $collapse),
                        'icon' => 'fa-plus-square'
                    ];
                }

                $productNavigation = array(
                    'type'  => 'group',
                    'group' => 'Shop by Category',
                    'icon'  => 'fa-map-signs',
                    'css'   => 'active non-active',
                    'menu'  => $product_categories
                );

                //$this->buildUserDashboard($collapse, $currentUser->role);
                Sidebar::addMenuGroup($productNavigation, $currentUser->role);
                $this->buildUserMenu($collapse, $currentUser->role);

                switch($currentUser->get('role')) {
                    case 'vendor':
                        $this->buildVendorMenu($collapse, $currentUser->role);
                        break;
                    case 'admin':
                        $this->buildVendorMenu($collapse, $currentUser->role);
                        $this->buildAdminMenu($collapse, $currentUser->role);
                        break;
                    case 'superadmin':
                        $this->buildVendorMenu($collapse, $currentUser->role);
                        $this->buildAdminMenu($collapse, $currentUser->role);
                        $this->buildSuperAdminMenu($collapse);
                        break;
                }

                $menus = Sidebar::buildMenu($this->request->getRequestTarget(), $currentUser->role);

                $this->set('currentUser', $currentUser);
            }
            else {

                $menus = Sidebar::buildMenu($this->request->getRequestTarget(), 'visitor');
            }
        }
        else {

            $menus = Sidebar::buildMenu($this->request->getRequestTarget(), 'visitor');
        }

        return $menus;
    }

    private function buildUserDashboard($collapse, $role)
    {
        $userDashboard = array(
            'type'  => 'link',
            'link'  => 'Dashboard',
            'icon'  => 'fa-dashboard',
            'path'  => '/dashboard' . '?' . $collapse
        );

        Sidebar::addMenuGroup($userDashboard, $role);

        $userHeader = array(
            'type'  => 'header',
            'header' => 'Welcome to Open Marketplace'
        );

        Sidebar::addMenuGroup($userHeader, $role);
    }

    private function buildUserMenu($collapse, $role) {

        $userNavigation = array(
            'type'  => 'group',
            'group' => 'User Menu',
            'icon'  => 'fa-user',
            'css'   => 'active non-active',
            'menu' => [
                'Dashboard' => [
                    'path' => '/dashboard' . '?' . $collapse,
                    'icon' => 'fa-dashboard'
                ],
                'Shopping Cart' => [
                    'path' => '/orders' . '?' . $collapse,
                    'icon' => 'fa-shopping-cart'
                ],
                'Wallet' => [
                    'path' => '/wallet' . '?' . $collapse,
                    'icon' => 'fa-money'
                ],
                'Messages' => [
                    'path' => '/messages' . '?' . $collapse,
                    'icon' => 'fa-envelope-o'
                ],
                'Notifications' => [
                    'path' => '/notifications' . '?' . $collapse,
                    'icon' => 'fa-bell-o'
                ],
                'Invites' => [
                    'path' => '/invites' . '?' . $collapse,
                    'icon' => 'fa-bullhorn'
                ],
                'Settings' => [
                    'path' => '/settings' . '?' . $collapse,
                    'icon' => 'fa-cogs'
                ],
                'Logout' => [
                    'path' => '/logout' . '?' . $collapse,
                    'icon' => 'fa-power-off'
                ]
            ]
        );

        if($role == 'user') {
            $userNavigation['menu']['Upgrade to Vendor'] = [
                'path' => '/upgrade' . '?' . $collapse,
                'icon' => 'fa-rocket'
            ];
        }

        Sidebar::addMenuGroup($userNavigation, $role);
    }

    private function buildVendorMenu($collapse, $role) {
        $userNavigation = array(
            'type'  => 'group',
            'group' => 'Vendor Menu',
            'icon'  => 'fa-dollar',
            'css'   => 'active non-active',
            'menu' => [
                'Incoming Orders' => [
                    'path' => '/incoming' . '?' . $collapse,
                    'icon' => 'fa-shopping-cart'
                ],
                'Pending Shipment' => [
                    'path' => '/pending-shipment' . '?' . $collapse,
                    'icon' => 'fa-truck'
                ],
                'Shipped Orders' => [
                    'path' => '/shipped-orders' . '?' . $collapse,
                    'icon' => 'fa-ship'
                ],
                'Finalized Orders' => [
                    'path' => '/finalized-orders' . '?' . $collapse,
                    'icon' => 'fa-thumbs-up'
                ],
                'Disputed Orders' => [
                    'path' => '/disputed-orders' . '?' . $collapse,
                    'icon' => 'fa-thumbs-down'
                ],
                'Products' => [
                    'path' => '/products' . '?' . $collapse,
                    'icon' => 'fa-empire'
                ],
                'Shipping Options' => [
                    'path' => '/settings/shipping' . '?' . $collapse,
                    'icon' => 'fa-cart-plus'
                ]
            ]
        );

        Sidebar::addMenuGroup($userNavigation, $role);
    }

    private function buildAdminMenu($collapse, $role) {

        $userNavigation = array(
            'type'  => 'group',
            'group' => 'Admin Menu',
            'icon'  => 'fa-bullhorn',
            'css'   => 'active non-active',
            'menu' => [

            ]
        );

        // Sidebar::addMenuGroup($userNavigation, $role);
    }

    private function buildSuperAdminMenu($collapse) {

        $userNavigation = array(
            'type'  => 'group',
            'group' => 'SuperAdmin Menu',
            'icon'  => 'fa-briefcase',
            'css'   => 'active non-active',
            'menu' => [
                'Product Categories' => [
                    'path' => '/categories' . '?' . $collapse,
                    'icon' => 'fa-edit'
                ]
            ]
        );

        Sidebar::addMenuGroup($userNavigation, 'superadmin');
    }
}
