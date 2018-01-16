<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Utility\Vendors;

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

            $vendorCount = $this->Messages->find('all', ['contain' => ['Users', 'Vendors']])->Where(['vendor_read' => 0, 'Messages.vendor_id' => $vendor_id, 'vendor_deleted' => 0])->count();
        }

        if($inbox == 'vendor' && $this->Auth->user('role') == 'vendor') {

            $messages = $this->paginate($this->Messages->find('all', ['contain' => ['Users', 'Vendors']])->where(['Messages.vendor_id' => $vendor_id, 'vendor_deleted' => 0])->orderDesc('Messages.id'));

            $vendorActive = 'active';
            $userActive = '';
            $inboxTitle = 'Vendor Inbox';

            $url = '/messages?inbox=vendor';
        }
        else {

            $messages = $this->paginate($this->Messages->find('all', ['contain' => ['Users', 'Vendors']])->where(['Messages.user_id' => $this->Auth->user('id'), 'user_deleted' => 0])->orderDesc('Messages.id'));

            $vendorActive = '';
            $userActive = 'active';
            $inboxTitle = 'User Inbox';

            $url = '/messages?inbox=user';
        }

        $userCount = $this->Messages->find('all', ['contain' => ['Users', 'Vendors']])->where(['user_read' => 0, 'Messages.user_id' => $this->Auth->user('id'), 'user_deleted' => 0])->count();

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

        if($message->get('user_id') == $this->Auth->user('id')) {

            $message->set('user_read', 1);
        }
        else if($message->get('vendor_id') == $vendor_id) {

            $message->set('vendor_read', 1);
        }

        $this->Messages->save($message);

        $this->set('username', $this->Auth->user('username'));
        $this->set('vendor_pgp', Vendors::getVendorPGP($vendor_id));
        $this->set('message', $message);
        $this->set('_serialize', ['message']);
    }
}
