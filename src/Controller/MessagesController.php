<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Utility\Janitor;
use App\Utility\Vendors;
use App\Utility\Messages;
use App\Utility\Crypto;

/**
 * Messages Controller
 *
 *
 * @method \App\Model\Entity\Message[] paginate($object = null, array $settings = [])
 */
class MessagesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        if($this->Auth->user('role') == 'vendor') {

            $vendor_id = Vendors::getVendorID($this->Auth->user('id'));
        }

        $inbox = $this->request->getQuery(['inbox']);

        if($this->request->getMethod() == 'POST' && $this->request->getData('submit') == 'deleteChecked') {

            $data = $this->request->getData('checkie');

            foreach($data as $message_id) {

                if($inbox == 'vendor') {

                    $message = $this->Messages->find('all')->where(['Messages.vendor_id' => $vendor_id, 'Messages.id' => $message_id])->first();

                    if(isset($message)) {

                        $message->set('vendor_deleted', 1);
                        $this->Messages->save($message);
                    }
                }
                else {

                    $message = $this->Messages->find('all')->where(['Messages.user_id' => $this->Auth->user('id'), 'Messages.id' => $message_id])->first();

                    if(isset($message)) {

                        $message->set('user_deleted', 1);
                        $this->Messages->save($message);
                    }
                }
            }
        }

        if($this->request->getMethod() == 'POST' && $this->request->getData('submit') == 'checkAll') {

            $checkAll = true;
        }
        else {

            $checkAll = false;
        }

        if($this->Auth->user('role') == 'vendor') {

            $vendorCount = Messages::getVendorCount($vendor_id);
        }

        if($inbox == 'vendor' && $this->Auth->user('role') == 'vendor') {

            $messages = $this->paginate($this->Messages->find('all', ['contain' => ['Users', 'Vendors']])->where(['Messages.vendor_id' => $vendor_id, 'vendor_deleted' => 0])->orderDesc('Messages.modified'));

            $vendorActive = 'active';
            $userActive = '';
            $inboxTitle = 'Vendor Inbox';

            $url = '/messages?inbox=vendor';
        }
        else {

            $messages = $this->paginate($this->Messages->find('all', ['contain' => ['Users', 'Vendors']])->where(['Messages.user_id' => $this->Auth->user('id'), 'user_deleted' => 0])->orderDesc('Messages.modified'));

            $vendorActive = '';
            $userActive = 'active';
            $inboxTitle = 'User Inbox';

            $url = '/messages?inbox=user';
        }

        $userCount = Messages::getUserCount($this->Auth->user('id'));

        $this->set('role', $this->Auth->user('role'));
        $this->set(compact('messages', 'userActive', 'vendorActive', 'userCount', 'vendorCount', 'inboxTitle', 'url', 'checkAll'));
        $this->set('_serialize', ['messages']);
    }

    /**
     * View method
     *
     * @param string|null $id Message id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        if($this->Auth->user('role') == 'vendor') {

            $vendor_id = Vendors::getVendorID($this->Auth->user('id'));
        }
        else {
            $vendor_id = 0;
        }

        $message = $this->Messages->find('all', ['contain' => ['Users', 'Vendors', 'MessageMessages']])->where(['Messages.id' => $id, 'Messages.vendor_id' => $vendor_id])->orWhere(['Messages.id' => $id, 'Messages.user_id' => $this->Auth->user('id')])->first();

        if(!isset($message)) {

            Janitor::hackAttempt();
        }

        if($message->get('user_id') == $this->Auth->user('id')) {

            $message->set('user_read', 1);
        }
        else if($message->get('vendor_id') == $vendor_id) {

            $message->set('vendor_read', 1);
        }

        $this->Messages->save($message);

        if($this->Auth->user('role') == 'vendor') {

            $vendorCount = Messages::getVendorCount($vendor_id);
        }
        else {

            $vendorCount = 0;
        }

        $userCount = Messages::getUserCount($this->Auth->user('id'));

        $this->set('vendorCount', $vendorCount);
        $this->set('userCount', $userCount);
        $this->set('username', $this->Auth->user('username'));
        $this->set('role', $this->Auth->user('role'));
        $this->set('vendor_pgp', Vendors::getVendorPGP($vendor_id));
        $this->set('message', $message);
        $this->set('_serialize', ['message']);
    }

    public function sendReply($id = null)
    {
        if($this->Auth->user('role') == 'vendor') {

            $vendor_id = Vendors::getVendorID($this->Auth->user('id'));
        }
        else {
            $vendor_id = 0;
        }

        $message = $this->Messages->find('all', ['contain' => ['Users', 'Vendors', 'MessageMessages']])->where(['Messages.id' => $id, 'Messages.vendor_id' => $vendor_id])->orWhere(['Messages.id' => $id, 'Messages.user_id' => $this->Auth->user('id')])->first();

        if(!isset($message)) {

            Janitor::hackAttempt();
        }

        $from_user = 0;
        $from_vendor = 0;

        if($message->get('user_id') == $this->Auth->user('id')) {

            $from_user = 1;
            $message->set('vendor_read', 0);
            $message->set('modified', new \DateTime('now'));
            $pgp = $this->Auth->user('pgp');
        }
        else if($message->get('vendor_id') == $vendor_id) {

            $from_vendor = 1;
            $message->set('user_read', 0);
            $message->set('modified', new \DateTime('now'));
            $pgp = Vendors::getVendorPGP($vendor_id);
        }

        $body = $this->request->getData('reply_field');

        if($this->request->getData('reply_encrypt') == 'on') {

            $body = Crypto::encryptMessage($body, $pgp);
        }

        $this->Messages->save($message);

        $this->loadModel('MessageMessages');

        $reply = $this->MessageMessages->newEntity([
            'message_id' => $message->id,
            'body' => $body,
            'created' => new \DateTime('now'),
            'from_user' => $from_user,
            'from_vendor' => $from_vendor
        ]);

        $this->MessageMessages->save($reply);

        return $this->redirect($this->referer());
    }
}
