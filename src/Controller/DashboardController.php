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

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

class DashboardController extends AppController
{

    public function index()
    {
        $role = $this->Auth->user('role');

        switch($role) {
            case 'superadmin':
                $this->superadmin();
                break;
            case 'admin':
                $this->admin();
                break;
            case 'vendor':
                $this->vendor();
                break;
            case 'user':
                $this->user();
                break;
        }
    }

    private function superadmin()
    {
        $this->render('superadmin');
    }

    private function admin()
    {
        $this->render('admin');
    }

    private function vendor()
    {
        $this->render('vendor');
    }

    private function user()
    {
        $this->render('user');
    }
}