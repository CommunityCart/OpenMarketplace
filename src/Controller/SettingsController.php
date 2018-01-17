<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Utility\Janitor;
use App\Utility\Vendors;
use App\Utility\Images;
use App\Utility\Crypto;

/**
 * Settings Controller
 *
 *
 * @method \App\Model\Entity\Setting[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SettingsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $settingsTitle = 'Settings';
        $userActive = '';
        $vendorActive = '';

        if($this->Auth->user('role') == 'vendor') {

            $vendor_id = Vendors::getVendorID($this->Auth->user('id'));
        }

        $settings = $this->request->getQuery(['settings']);

        if($settings == '' || $settings == null) {

            $settings = 'user';
        }

        switch($settings)
        {
            case 'user':
                $settingsTitle = 'User Settings';
                $this->loadModel('Users');
                $user = $this->Users->find('all')->where(['id' => $this->Auth->user('id')])->first();
                $this->set('user', $user);
                $userActive = 'active';
                break;

            case 'vendor':
                $settingsTitle = 'Vendor Settings';
                $this->loadModel('Vendors');
                $vendor = $this->Vendors->find('all')->where(['id' => $vendor_id])->first();
                $this->set('vendor', $vendor);
                $vendorActive = 'active';
                break;
        }

        $this->set('settings', $settings);
        $this->set('role', $this->Auth->user('role'));
        $this->set(compact('userActive', 'vendorActive', 'settingsTitle'));
    }

    public function saveVendorSettings()
    {
        if($this->Auth->user('role') == 'vendor') {

            $vendor_id = Vendors::getVendorID($this->Auth->user('id'));
        }
        else {

            Janitor::hackAttempt();
        }

        $this->loadModel('Vendors');
        $vendor = $this->Vendors->find('all')->where(['id' => $vendor_id])->first();

        $vendor->set('title', $this->request->getData('title'));
        $vendor->set('tos', $this->request->getData('tos'));

        $this->Vendors->save($vendor);

        return $this->redirect($this->referer());
    }

    // TODO: Check Product Image Upload For PHP Execution
    public function saveUserSettings()
    {
        $this->loadModel('Users');
        $user = $this->Users->find('all')->where(['id' => $this->Auth->user('id')])->first();

        $fileArray = $this->request->getData('upload');

        if(isset($fileArray) && $fileArray['name'] != '' && $fileArray['tmp_name'] != '' && file_exists($fileArray['tmp_name'])) {

            $filePath = $fileArray['tmp_name'];

            if (file_exists(WWW_ROOT . '/images/' . date('M-Y')) == false) {
                mkdir(WWW_ROOT . '/images/' . date('M-Y'));
            }

            $fileExtArray = explode('.', $fileArray['name']);
            $ext = end($fileExtArray);

            $originalPath = WWW_ROOT . 'images/' . date('M-Y') . '/' . basename($filePath) . '.original.' . $ext;

            move_uploaded_file($filePath, $originalPath);

            Images::convertImage($originalPath, $originalPath . '.jpg', 80);

            try { unlink($originalPath); } catch(\Exception $ex) { }

            Images::resizeImage($originalPath . '.jpg', WWW_ROOT . 'images/' . date('M-Y') . '/' . basename($filePath) . '.display.jpg');
            Images::thumbImage($originalPath . '.jpg', WWW_ROOT . 'images/' . date('M-Y') . '/' . basename($filePath) . '.thumb.jpg');

            $user->set('avatar', WWW_ROOT . 'images/' . date('M-Y') . '/' . basename($filePath));
        }

        if($this->request->getData('enable_2fa') == '')
        {
            $user->set('2fa', 0);
        }

        $user->set('pgp', $this->request->getData('pgp_key'));

        $this->Users->save($user);

        if($this->request->getData('enable_2fa') == 'on' && $user->get('2fa') == 0) {

            if($user->get('pgp') == '') {

                $this->Flash->error('You must save a PGP key to enable 2 factor authentication.');
                return $this->redirect($this->referer());
            }
            else {
                return $this->redirect('/enable2fa');
            }
        }
        else {

            return $this->redirect($this->referer());
        }
    }

    public function enable2fa()
    {
        $this->loadModel('Users');
        $user = $this->Users->find('all')->where(['id' => $this->Auth->user('id')])->first();

        if($user->get('pgp') == '') {

            $this->Flash->error('You must save a PGP key to enable 2 factor authentication.');
            return $this->redirect('/settings');
        }

        $randomString = Crypto::getRandom();
        $challenge = Crypto::encryptMessage($randomString, $user->get('pgp'));

        $user->set('challenge', $challenge);
        $user->set('challenge_response', $randomString);
        $this->Users->save($user);

        $this->set('actionUrl', '/save2fa');
        $this->set('user', $user);
        $this->set('challenge', $challenge);
    }

    public function save2fa()
    {
        $this->loadModel('Users');
        $user = $this->Users->find('all')->where(['id' => $this->Auth->user('id')])->first();

        $challenge_response = $user->get('challenge_response');

        if($challenge_response != '' && $this->request->getData('pgp_challenge_response') == $challenge_response)
        {
            $user->set('2fa', 1);
            $this->Users->save($user);
        }

        return $this->redirect('/settings');
    }

    public function display2fa()
    {
        $this->loadModel('Users');
        $user = $this->Users->find('all')->where(['id' => $this->Auth->user('id')])->first();

        if($user->get('2fa') == 0 || $this->Cookie->read('2fa') == 1) {

            return $this->redirect('/dashboard');
        }

        $randomString = Crypto::getRandom();
        $challenge = Crypto::encryptMessage($randomString, $user->get('pgp'));

        $user->set('challenge', $challenge);
        $user->set('challenge_response', $randomString);
        $this->Users->save($user);

        $this->set('actionUrl', '/login2fa');
        $this->set('user', $user);
        $this->set('challenge', $challenge);
    }

    public function login2fa()
    {
        $this->loadModel('Users');
        $user = $this->Users->find('all')->where(['id' => $this->Auth->user('id')])->first();

        $challenge_response = $user->get('challenge_response');

        if($this->request->getData('pgp_challenge_response') == $challenge_response)
        {
            $this->Cookie->write('2fa', 1);

            return $this->redirect('/dashboard');
        }
        else {

            return $this->redirect('/display2fa');
        }
    }
}
