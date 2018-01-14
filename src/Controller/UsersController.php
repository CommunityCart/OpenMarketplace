<?php

namespace App\Controller;

use App\Controller\Traits\ProfileTrait;
use Cake\ORM\TableRegistry;
use CakeDC\Users\Controller\UsersController as BaseUsersController;
use Cake\Core\Configure;
use Cake\Utility\Security;
use CakeDC\Users\Controller\Component\UsersAuthComponent;
use App\Utility\Users;
use App\Utility\Settings;
use App\Utility\Invites;

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

    public function register($code = null) {

        $this->set('title', 'Register User');

        $data = $this->request->getData('captcha_confirm');

        if($code != null) {

            $this->set('code', $code);
        }
        else {

            $this->set('code', '');
        }

        if($this->request->getMethod() == 'POST' && !$this->Captcha->check($data))
        {
            $this->Flash->error('Invalid Captcha, Please Try Again.');

            if($code != null) {

                return $this->redirect('/youre-invited/' . $code);
            }
            else {

                return $this->redirect('/register');
            }
        }

        if($this->request->getMethod() == 'POST') {
            $inviteCode = $this->request->getData('invite_code');
            $inviteId = Invites::verifyInviteCode($inviteCode);

            if (Settings::registerInviteOnly() == true && $inviteId == false) {

                $this->Flash->error('Invalid Invite Code, Please try Again');

                if($code != null) {

                    return $this->redirect('/youre-invited/' . $code);
                }
                else {

                    return $this->redirect('/register');
                }
            }

            if ($inviteId != false && $inviteId > 0) {

                $this->eventManager()->on(UsersAuthComponent::EVENT_AFTER_REGISTER, function ($event) use ($inviteId) {
                    $username = $event->subject->request->data['username'];
                    $users = new Users();
                    $user = $users->getUserByUsername($username);

                    Invites::insertRegistration($user, $inviteId);
                });
            }
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
