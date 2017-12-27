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
        $collapse = $this->getCollapse();

        $this->set('menus', $this->buildMenus($collapse));

        return parent::beforeRender($event);
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
                'Orders' => [
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
                'Help Desk' => [
                    'path' => '/support' . '?' . $collapse,
                    'icon' => 'fa-question-circle'
                ],
                'Disputes' => [
                    'path' => '/disputes' . '?' . $collapse,
                    'icon' => 'fa-exclamation'
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
                'Products' => [
                    'path' => '/products' . '?' . $collapse,
                    'icon' => 'fa-empire'
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
