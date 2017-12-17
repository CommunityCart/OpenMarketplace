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

        $this->Auth->configShallow('loginRedirect', '/dashboard');
        $this->Auth->configShallow('logoutRedirect', '/login');
        $this->Auth->allow(['register', 'requestResetPassword', 'captcha']);

        $this->viewBuilder()->setTheme('AdminLTE');

        $this->viewBuilder()->setClassName('AdminLTE.AdminLTE');
    }

    public function beforeRender(Event $event)
    {
        if(method_exists($this->Auth, 'user')) {

            if ($this->Auth->user('id')) {

                $currentId = $this->Auth->user('id');

                $currentUser = TableRegistry::get(Configure::read('Users.table'))->get($this->Auth->user('id'));

                $menus = Sidebar::buildMenu($this->request->here, $currentUser->role);

                $this->set('menus', $menus);
            }
            else {

                $menus = Sidebar::buildMenu($this->request->here, 'visitor');
            }
        }
        else {

            $menus = Sidebar::buildMenu($this->request->here, 'visitor');
        }

        $this->set('menus', $menus);

        return parent::beforeRender($event);
    }
}
