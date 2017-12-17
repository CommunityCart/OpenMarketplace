<?php

namespace App\Controller;

use App\Controller\Traits\ProfileTrait;
use Cake\ORM\TableRegistry;
use CakeDC\Users\Controller\UsersController as BaseUsersController;
use Cake\Core\Configure;
use Cake\Utility\Security;
use CakeDC\Users\Controller\Component\UsersAuthComponent;
use App\Utility\Users;

class UsersController extends BaseUsersController
{
    use ProfileTrait;

    public function initialize() {

        parent::initialize();

        $this->loadComponent('CakephpCaptcha.Captcha');

        $this->Auth->allow('login', 'register');
    }

    public function oauth2callback()
    {
        $client = new \Google_Client();
        $client->setAuthConfig(__DIR__ . '/../../config/client_secrets.json');
        $client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback');
        $client->addScope(\Google_Service_Analytics::ANALYTICS_READONLY);

        if (!isset($_GET['code'])) {
            $auth_url = $client->createAuthUrl();
            $this->redirect(filter_var($auth_url, FILTER_SANITIZE_URL));
        } else {
            $client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $client->getAccessToken();
            print_r($_SESSION['access_token']);die();
            $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/';
            $this->redirect(filter_var($redirect_uri, FILTER_SANITIZE_URL));
        }
    }

    public function changePassword()
    {
        $id = basename($this->request->here);

        $usersTable = TableRegistry::get(Configure::read('Users.table'));
        $query = $usersTable->find('all')->where(['id' => $id])->limit(1);
        $user2 = $query->first();

        $this->set(compact('user2'));

        $this->set('title', 'Change User Password');

        parent::changePassword();

        $this->render('admin_change_password');
    }

    public function edit($id = null)
    {
        //$id = basename($this->request->here);

        $usersTable = TableRegistry::get(Configure::read('Users.table'));
        $query = $usersTable->find('all')->where(['id' => $id])->limit(1);
        $user2 = $query->first();

        $this->set(compact('user2'));

        $this->set('title', 'Change User Password');

        parent::edit($id);

        $this->render('admin_edit_user');
    }

    public function register() {

        $this->set('title', 'Register User');

        $data = $this->request->getData('captcha_confirm');

        if($this->request->getMethod() == 'POST' && !$this->Captcha->check($data))
        {
            $this->Flash->error('Invalid Captcha, Please Try Again.');

            $this->redirect('/register');
        }

        parent::register();
    }

    public function captcha()
    {
        $this->autoRender = false;

        echo $this->Captcha->image(5);
    }

    public function login() {

        $this->set('title', 'CakeAdminLTE Login');

        parent::login();
    }

    public function requestResetPassword() {

        $this->set('title', 'Reset Password');

        parent::requestResetPassword();
    }
}
