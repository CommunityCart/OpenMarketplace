<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

Router::scope('/', function (RouteBuilder $routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks(DashedRoute::class);
});

/**
 * Load all plugin routes. See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */

Router::connect('/profile/*', ['controller' => 'Users', 'action' => 'profile']);
Router::connect('/profile', ['controller' => 'Users', 'action' => 'profile']);
Router::connect('/login', ['controller' => 'Users', 'action' => 'login']);
Router::connect('/logout', ['plugin' => 'CakeDC/Users', 'controller' => 'Users', 'action' => 'logout']);
Router::connect('/register', ['controller' => 'Users', 'action' => 'register']);
Router::connect('/upgrade', ['controller' => 'Users', 'action' => 'upgrade']);
Router::connect('/reset', ['controller' => 'Users', 'action' => 'requestResetPassword']);
Router::connect('/captcha', ['controller' => 'Users', 'action' => 'captcha']);
Router::connect('/messages', ['controller' => 'Messages', 'action' => 'index']);
Router::connect('/categories', ['controller' => 'ProductCategories', 'action' => 'index']);
Router::connect('/images/add/*', ['controller' => 'ProductImages', 'action' => 'add']);
Router::connect('/favorites', ['controller' => 'Shop', 'action' => 'favorites']);
Router::connect('/settings/shipping', ['controller' => 'ShippingOptions', 'action' => 'index']);
Router::connect('/settings/shipping/create', ['controller' => 'ShippingOptions', 'action' => 'add']);
Router::connect('/settings/shipping/*', ['controller' => 'ShippingOptions', 'action' => 'edit']);
Router::connect('/products/flag/*', ['controller' => 'Products', 'action' => 'flag']);
Router::connect('/products/favorite/*', ['controller' => 'Products', 'action' => 'favorite']);
Router::connect('/order/*', ['controller' => 'Orders', 'action' => 'order_review']);
Router::connect('/order/order-review2/*', ['controller' => 'Orders', 'action' => 'order_review2']);
Router::connect('/wallet', ['controller' => 'Wallets', 'action' => 'index']);
Router::connect('/wallet/deposit', ['controller' => 'Wallets', 'action' => 'deposit']);
Router::connect('/vendor/*', ['controller' => 'Vendors', 'action' => 'view']);
Router::connect('/incoming', ['controller' => 'Orders', 'action' => 'incoming']);
Router::connect('/submit/*', ['controller' => 'Orders', 'action' => 'submit']);
Router::connect('/cancel/*', ['controller' => 'Orders', 'action' => 'delete']);
Router::connect('/accept/*', ['controller' => 'Orders', 'action' => 'accept']);
Router::connect('/reject/*', ['controller' => 'Orders', 'action' => 'reject']);
Router::connect('/dispute/*', ['controller' => 'Orders', 'action' => 'openDispute']);
Router::connect('/open-dispute/*', ['controller' => 'Orders', 'action' => 'dispute']);
Router::connect('/shipped/*', ['controller' => 'Orders', 'action' => 'shipped']);
Router::connect('/finalize/*', ['controller' => 'Orders', 'action' => 'finalize']);
Router::connect('/unfinalize/*', ['controller' => 'Orders', 'action' => 'unfinalize']);
Router::connect('/rate/*', ['controller' => 'Orders', 'action' => 'rate']);
Router::connect('/incoming-bulk', ['controller' => 'Orders', 'action' => 'bulk']);
Router::connect('/pending-shipment', ['controller' => 'Orders', 'action' => 'shipments']);
Router::connect('/shipped-orders', ['controller' => 'Orders', 'action' => 'shipped_orders']);
Router::connect('/finalized-orders', ['controller' => 'Orders', 'action' => 'finalized_orders']);
Router::connect('/disputed-orders', ['controller' => 'Orders', 'action' => 'disputed_orders']);

Plugin::routes();
