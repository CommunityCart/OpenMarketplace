<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Utility\Wallet;
use App\Utility\Settings;
use App\Utility\Crypto;
use App\Utility\Users;
use App\Utility\Currency;
use App\Utility\Invites;
use App\Utility\Vendors;
use App\Utility\Tables;

/**
 * Vendors Controller
 *
 * @property \App\Model\Table\VendorsTable $Vendors
 *
 * @method \App\Model\Entity\Vendor[] paginate($object = null, array $settings = [])
 */
//TODO: Set Last Active For Vendor In AppController
class VendorsController extends AppController
{
    public function upgrade()
    {
        $balances = Wallet::getWalletBalance($this->Auth->user('id'));
        $totalBalance = $balances[0];

        $totalCost = Settings::getVendorDepositAmount();

        if($totalBalance > $totalCost) {

            $this->set('balance', 'high');

            $missingBalance = 0;
            $status = 1;
        }
        else {
            $missingBalance = $totalCost - $totalBalance;

            $status = 0;

            $this->set('balance', 'low');
            $this->set('missingBalance', $missingBalance);
        }

        $user = Users::getUser($this->Auth->user('id'));

        if($user->get('pgp') != '') {

            $randomString = Crypto::getRandom();
            $challenge = Crypto::encryptMessage($randomString, $user->get('pgp'));

            $user->set('vendor_challenge', $challenge);
            $user->set('vendor_challenge_response', $randomString);

            $this->loadModel('Users');
            $this->Users->save($user);

            $this->set('no_pgp', false);
            $this->set('challenge', $challenge);
        }
        else {

            $this->set('no_pgp', true);
        }
    }

    public function saveUpgrade()
    {
        $user = Users::getUser($this->Auth->user('id'));

        $challenge_response = $user->get('vendor_challenge_response');

        if($challenge_response != '' && $this->request->getData('pgp_challenge_response') == $challenge_response)
        {
            $this->loadModel('Users');

            $user->set('role', 'vendor');
            $this->Users->save($user);

            $this->loadModel('Vendors');
            $vendor = $this->Vendors->newEntity([
                'user_id' => $this->Auth->user('id'),
                'title' => $this->Auth->user('username'),
                'tos' => '# Terms Of Service',
                'created' => new \DateTime('now'),
                'modified' => new \DateTime('now')
            ]);
            $this->Vendors->save($vendor);

            $litecoin = new \App\Utility\Litecoin();

            $totalCost = Currency::Convert('usd', Settings::getVendorDepositAmount(), 'cmc');

            $superadmin_invite_id = Invites::getSuperAdminInviteID();
            $superadmin_user_id = Invites::getUserIDByInviteID($superadmin_invite_id);
            Invites::upgradeToVendor($user, Vendors::getVendorID($user->get('id')));

            $litecoin->moveFromAccountToAccount($user->get('id'), $superadmin_user_id, $totalCost);

            $this->Flash->success('You have successfully upgraded to vendor, please log back in.');

            return $this->redirect('/logout');
        }
        else {

            return $this->redirect($this->referer());
        }
    }

    /**
     * View method
     *
     * @param string|null $id Vendor id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $vendor = $this->Vendors->get($id, [
            'contain' => []
        ]);

        $ordersTable = Tables::getOrdersTable();
        $orders = $ordersTable->find('all');

        $productsTable = Tables::getProductsTable();
        $products = $productsTable->find('all', ['contain' => ['Vendors', 'Countries', 'Vendors.Users', 'ProductCategories']])->where(['vendor_id' => $vendor->get('id')])->all();

        if(isset($products) && count($products) > 0) {

            foreach ($products as $product) {

                $orders->orWhere(['product_id' => $product->get('id')]);
            }

            $orders = $orders->all();
        }

        $reviewsTable = Tables::getReviewsTable();

        $reviews = $reviewsTable->find('all');

        if(isset($orders) && count($orders) > 0) {

            foreach($orders as $order) {

                $reviews->orWhere(['order_id' => $order->get('id')]);
            }

            $reviews = $reviews->orderDesc('created')->limit(20)->all();

            $this->set('reviews', $reviews);
        }
        else {

            $this->set('reviews', array());
        }

        $user = Users::getOtherUserByID($vendor->get('user_id'));

        if(isset($products) && count($products) > 0) {

            $this->set('products', $products);
        }
        else {

            $this->set('products', array());
        }

        $this->set('ordersCount', count($orders));
        $this->set('user', $user);
        $this->set('vendor', $vendor);
        $this->set('_serialize', ['vendor']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Vendor id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $vendor = $this->Vendors->get($id);
        if ($this->Vendors->delete($vendor)) {
            $this->Flash->success(__('The vendor has been deleted.'));
        } else {
            $this->Flash->error(__('The vendor could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
