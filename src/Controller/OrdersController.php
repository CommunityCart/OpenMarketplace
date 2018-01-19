<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Utility\Crypto;
use App\Utility\Janitor;
use App\Utility\Settings;
use App\Utility\Wallet;
use App\Utility\Currency;
use App\Utility\Math;
use App\Utility\Invites;
use App\Utility\Vendors;
use Cake\Cache\Cache;
use App\Utility\MenuCounts;

/**
 * Orders Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 *
 * @method \App\Model\Entity\Order[] paginate($object = null, array $settings = [])
 */

// TODO: Place "TODO: Hack Checks" At The Top Of Every File.
// TODO: Hack Checks
class OrdersController extends AppController
{
    public function orderReviewer($id = null, $idIsProduct = false)
    {
        $this->loadModel('Products');
        $this->loadModel('Wallets');
        $this->loadModel('ShippingOptions');
        $this->loadModel('Vendors');
        $this->loadModel('Disputes');

        $order = $this->Orders->find('all', ['contain' => ['Reviews', 'Products', 'Products.Vendors', 'Products.Vendors.Users']])->where(['Orders.id' => $id, 'Orders.user_id' => $this->Auth->user('id')])->first();

        if($idIsProduct == true)
        {
            $data = $this->request->getData();
        }
        else {

            $data = $order;
        }

        $balances = Wallet::getWalletBalance($this->Auth->user('id'));
        $totalBalance = $balances[0];

        if($idIsProduct == true) {

            $product_id = $id;
        }
        else {

            $product_id = $data->product_id;
        }

        $productsResult = $this->Products->find('all', ['contain' => ['Vendors', 'Vendors.Users', 'ProductCategories', 'Countries', 'Orders', 'ProductCountries', 'ProductImages', 'Vendors.ShippingOptions']])->where(['Products.id' => $product_id])->first();

        // TODO: Performance, Add Count Columns To Tables instead of counting everytime.
        $vendorOrderCount = $this->Orders->find('all', ['contain' => ['Products']])->where(['Products.vendor_id' => $productsResult->vendor->id, 'Orders.status >' => 1])->count();
        $productOrderCount = $this->Orders->find('all')->where(['product_id' => $productsResult->id, 'status >' => 1])->count();

        $vendorRating = $this->Vendors->find('all')->where(['id' => $productsResult->vendor->id])->first();

        if($idIsProduct == true)
        {
            $quantity = $data['quantity'];
            $shipping_options = $data['shipping_options'];
        }
        else {

            $quantity = $data->quantity;
            $shipping_options = $data->shipping_option_id;
        }

        $shippingOptions = $this->ShippingOptions->find('all')->where(['id' => $shipping_options])->first();

        $totalCost = (($productsResult->cost * $quantity) + $shippingOptions->get('shipping_cost'));

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

        if($idIsProduct == true)
        {
            $order = $this->Orders->newEntity([
                'user_id' => $this->Auth->user('id'),
                'product_id' => $id,
                'wallet_transaction_id' => -1,
                'status' => $status,
                'quantity' => $data['quantity'],
                'shipping_option_id' => $data['shipping_options'],
                'created' => new \DateTime('now'),
                'order_total_dollars' => $totalCost,
                'order_total_crypto' => number_format(Currency::Convert('usd', $totalCost, 'cmc'), 8)
            ]);

            $this->Orders->save($order);

            $order = $this->Orders->find('all', ['contain' => ['Reviews', 'Products', 'Products.Vendors', 'Products.Vendors.Users']])->where(['Orders.id' => $order->id, 'Orders.user_id' => $this->Auth->user('id')])->first();
        }

        if($order->get('status') == -2)
        {
            $dispute = $this->Disputes->find('all')->where(['order_id' => $order->id])->first();

            $this->set('dispute', $dispute);
        }

        if($this->Auth->user('role') == 'vendor') {

            $this->set('userIsVendor', true);
        }

        $this->loadModel('Reviews');

        $reviews = $this->Reviews->find('all', ['contain' => ['Orders']])->where(['Orders.product_id' => $productsResult->id])->limit(50)->orderDesc('Reviews.created')->all();


        $this->set('reviews', $reviews);
        $this->set('totalBalance', $totalBalance);
        $this->set('order', $order);
        $this->set('vendorRating', $vendorRating->get('rating'));
        $this->set('vendorOrderCount', $vendorOrderCount);
        $this->set('productOrderCount', $productOrderCount);
        $this->set('shipping_options', $shippingOptions);
        $this->set('image_index', '0');
        $this->set('id', $id);
        $this->set('product', $productsResult);
    }

    public function orderReview($id = null)
    {
        $this->orderReviewer($id, true);
    }

    public function orderReview2($id = null)
    {
        $this->orderReviewer($id, false);

        $this->render('order_review');
    }

    public function index()
    {
        $this->loadModel('Products');
        $this->loadModel('Wallets');
        $this->loadModel('ShippingOptions');
        $this->loadModel('Vendors');

        $totalMissingBalance = 0;
        $totalBalance = Wallet::getWalletBalance($this->Auth->user('id'));

        $orders = $this->Orders->find('all')->where(['Orders.user_id' => $this->Auth->user('id'), 'Orders.status <' => 2, 'Orders.status >' => -1])->all();

        foreach ($orders as $order) {

            $shipping_options = $order->shipping_option_id;

            $productsResult = $this->Products->find('all', ['contain' => []])->where(['Products.id' => $order->product_id])->first();
            $shippingOptions = $this->ShippingOptions->find('all')->where(['id' => $shipping_options])->first();

            if($totalBalance[0] > (($productsResult->cost * $order->quantity) + $shippingOptions->get('shipping_cost'))) {

                $missingBalance = 0;
                $status = 1;
            }
            else {
                $missingBalance = (($productsResult->cost * $order->quantity) + $shippingOptions->get('shipping_cost')) - $totalBalance[0];
                $status = 0;
            }

            $totalMissingBalance = $totalMissingBalance + $missingBalance;

            $order->set('status', $status);
            $order->set('created', new \DateTime('now'));

            $this->Orders->save($order);
        }

        $orders = $this->Orders->find('all', ['contain' => ['Users', 'Products', 'ShippingOptions']])->where(['Orders.user_id' => $this->Auth->user('id')])->all();

        MenuCounts::updateUserViewedShoppingCart($this->Auth->user('id'), null, true);

        $this->set('title', 'Shopping Cart');
        $this->set(compact('orders'));
        $this->set('_serialize', ['orders']);
    }

    public function shipments()
    {
        $this->loadModel('Vendors');

        $vendor = $this->Vendors->find('all')->where(['user_id' => $this->Auth->user('id')])->first();
        $vendor_id = $vendor->get('id');

        $orders = $this->Orders->find('all', ['contain' => ['Users', 'Users.Orders', 'Users.Orders.Products', 'Users.Orders.ShippingOptions', 'Products', 'ShippingOptions']])->where(['Orders.status' => 3, 'Products.vendor_id' => $vendor_id])->all();

        $this->set('title', 'Incoming Orders');
        $this->set(compact('orders'));
        $this->set('_serialize', ['orders']);

        $this->render('shipments');
    }

    public function incoming()
    {
        MenuCounts::updateVendorViewedIncoming(Vendors::getVendorID($this->Auth->user('id')), true);

        $this->viewOrders('Orders.status',2, 'Incoming Orders');
    }

    public function shippedOrders()
    {
        $this->viewOrders('Orders.status',4, 'Shipped Orders');
    }

    public function finalizedOrders()
    {
        MenuCounts::updateVendorViewedFinalized(Vendors::getVendorID($this->Auth->user('id')), true);

        $this->viewOrders('Orders.status >', 4, 'Finalized Orders');
    }

    public function disputes()
    {
        MenuCounts::updateUserViewedDisputes($this->Auth->user('id'), true);

        $this->viewOrders('Orders.status', -2, 'Disputed Orders', false);
    }

    public function disputedOrders()
    {
        MenuCounts::updateVendorViewedDisputed(Vendors::getVendorID($this->Auth->user('id')), true);

        $this->viewOrders('Orders.status', -2, 'Disputed Orders');
    }

    private function viewOrders($ordersStatus, $status, $title, $isVendor = true)
    {
        $this->loadModel('Vendors');

        if($isVendor == true) {

            $vendor = $this->Vendors->find('all')->where(['user_id' => $this->Auth->user('id')])->first();
            $vendor_id = $vendor->get('id');

            $orders = $this->Orders->find('all', ['contain' => ['Users', 'Products', 'ShippingOptions']])->where([$ordersStatus => $status, 'Products.vendor_id' => $vendor_id])->all();
        }
        else {

            $orders = $this->Orders->find('all', ['contain' => ['Users', 'Products', 'ShippingOptions']])->where([$ordersStatus => $status, 'Orders.user_id' => $this->Auth->user('id')])->all();
        }

        $this->set('title', $title);
        $this->set(compact('orders'));
        $this->set('_serialize', ['orders']);

        $this->render('index');
    }

    public function submit($id = null)
    {
        $order = $this->Orders->get($id);

        $this->amiuser($order);

        MenuCounts::updateUserViewedShoppingCart($this->Auth->user('id'));
        MenuCounts::updateVendorViewedIncoming(Vendors::getVendorIDByOrder($order));

        $data = $this->request->getData('shipping_details');

        if($this->request->getData('encrypt_shipping') == 'on')
        {
            $vendor_id = Vendors::getVendorIDByOrder($order);

            $data = Crypto::encryptMessage($data, Vendors::getVendorPGP($vendor_id));
        }

        $order->set('shipping_details', $data);
        $order->set('status', 2);
        $order->set('created', new \DateTime('now'));
        $this->Orders->save($order);

        return $this->redirect('/orders');
    }

    public function accept($id = null)
    {
        $order = $this->Orders->get($id);

        $this->amirite($order);

        MenuCounts::updateUserViewedShoppingCart($order->get('user_id'));

        $order->set('status', 3);
        $order->set('accepted', new \DateTime('now'));
        $this->Orders->save($order);

        return $this->redirect($this->referer());
    }

    public function reject($id = null)
    {
        $order = $this->Orders->get($id);

        $this->amirite($order);

        MenuCounts::updateUserViewedShoppingCart($order->get('user_id'), true);

        $order->set('status', -1);
        $this->Orders->save($order);

        return $this->redirect($this->referer());
    }

    public function openDispute($id = null)
    {
        $this->loadModel('Products');
        $this->loadModel('ShippingOptions');
        $this->loadModel('Vendors');
        $this->loadModel('Users');

        $order = $this->Orders->get($id);
        $product = $this->Products->get($order->get('product_id'));
        $shipping = $this->ShippingOptions->get($order->get('shipping_option_id'));
        $vendor = $this->Vendors->get($product->get('vendor_id'));
        $vendor_user = $this->Users->get($vendor->get('user_id'));

        $this->set('id', $id);
        $this->set('order', $order);
        $this->set('product', $product);
        $this->set('shipping', $shipping);
        $this->set('vendor', $vendor);
        $this->set('vendor_user', $vendor_user);

        $this->render('dispute');
    }

    public function dispute($id = null)
    {
        $order = $this->Orders->get($id);

        $this->amiuser($order);

        MenuCounts::updateUserViewedDisputes($this->Auth->user('id'));
        MenuCounts::updateVendorViewedDisputed(Vendors::getVendorIDByOrder($order));

        $order->set('status', -2);
        $this->Orders->save($order);

        $this->loadModel('Disputes');

        $data = $this->request->getData();

        $never_arrived = 0;
        $wrong_product = 0;
        $bad_quality = 0;
        $other = 0;

        switch($data['dispute_radio'])
        {
            case 'null_route':
                $never_arrived = 1;
                break;
            case 'wrong':
                $wrong_product = 1;
                break;
            case 'quality':
                $bad_quality = 1;
                break;
            default:
                $other = 1;
                break;
        }

        $comment = '';
        if(isset($data['other_comment'])) {
            $comment = $data['other_comment'];
        }

        $dispute = $this->Disputes->newEntity([
            'order_id' => $order->id,
            'never_arrived' => $never_arrived,
            'wrong_product' => $wrong_product,
            'bad_quality' => $bad_quality,
            'other' => $other,
            'comment' => $comment,
            'created' => new \DateTime('now')
        ]);

        $this->Disputes->save($dispute);

        return $this->redirect('/orders');
    }

    public function shipped($id = null)
    {
        $order = $this->Orders->get($id);

        $this->amirite($order);

        MenuCounts::updateUserViewedShoppingCart($order->get('user_id'));

        $order->set('status', 4);
        $order->set('shipped', new \DateTime('now'));
        $this->Orders->save($order);

        if($order->get('finalize_early') == 1) {

            $this->finalizeOrder($order);
        }

        return $this->redirect($this->referer());
    }

    public function finalize($id = null)
    {
        $order = $this->Orders->get($id);

        $this->amiuser($order);

        if($order->get('status') == 2 || $order->get('status') == 3) {

            $order->set('finalize_early', 1);
            $this->Orders->save($order);

            $this->Flash->success('Your Order Has Been Set To Finalize Early.');
        }
        else if($order->get('status') == 4) {

            $this->finalizeOrder($order);
        }
        else {

            $this->Flash->error('Unable To Finalize At This Time.');
        }

        return $this->redirect($this->referer());
    }

    //TODO: Make Site Unusable Until SuperAdmin Logs In
    private function finalizeOrder($order)
    {
        $cacheTimestamp = Cache::read($order->get('id') . '.finalized', 'memcache');

        if($cacheTimestamp != null || $cacheTimestamp != '') {

            $this->Flash->error('Nice try...');

            return $this->redirect($this->referer());
        }

        Cache::write($order->get('id') . '.finalized', new \DateTime('now'), 'memcache');

        $order->set('status', 5);
        $order->set('finalized', new \DateTime('now'));
        $this->Orders->save($order);

        MenuCounts::updateVendorViewedFinalized(Vendors::getVendorIDByOrder($order));

        $this->loadModel('InvitesFinalized');

        $litecoin = new \App\Utility\Litecoin();

        //
        // Super Admin Commission
        //

        $superAdminsCommission = Math::roundCryptoDown($order->get('order_total_crypto') * Settings::getSuperAdminsCommissionPercent());
        $superadmin_invite_id = Invites::getSuperAdminInviteID();
        $superadmin_user_id = Invites::getUserIDByInviteID($superadmin_invite_id);

        $litecoin->moveFromAccountToAccount($order->get('user_id'), $superadmin_user_id, $superAdminsCommission);

        sleep(1);

        $superadmin_invite_finalized = $this->InvitesFinalized->newEntity([
            'order_id' => $order->get('id'),
            'commission' => $superAdminsCommission,
            'finalized' => new \DateTime('now'),
            'invite_id' => $superadmin_invite_id
        ]);
        $this->InvitesFinalized->save($superadmin_invite_finalized);

        $order->set('paid_commission_superadmin', 1);

        //
        // End Super Admin Commission

        //
        // User Commissions
        //

        $userCommission = Math::roundCryptoDown($order->get('order_total_crypto') * Settings::getUserCommissionPercent());
        $user_invite_id = Invites::getUserInviteID($order);

        if($user_invite_id != null)
        {
            $user_inviter_user_id = Invites::getUserIDByInviteID($user_invite_id);
        }
        else {
            $user_inviter_user_id = $superadmin_user_id;
        }

        $litecoin->moveFromAccountToAccount($order->get('user_id'), $user_inviter_user_id, $userCommission);

        sleep(1);

        $user_invite_finalized = $this->InvitesFinalized->newEntity([
            'order_id' => $order->get('id'),
            'commission' => $userCommission,
            'finalized' => new \DateTime('now'),
            'invite_id' => $user_invite_id
        ]);
        $this->InvitesFinalized->save($user_invite_finalized);

        $order->set('paid_commission_user', 1);

        //
        // End User Commissions

        //
        // Vendor Commissions
        //

        $vendorCommission = Math::roundCryptoDown($order->get('order_total_crypto') * Settings::getVendorCommissionPercent());
        $vendor_invite_id = Invites::getVendorInviteID($order);

        if($vendor_invite_id != null) {
            $vendor_inviter_user_id = Invites::getUserIDByInviteID($vendor_invite_id);
        }
        else {
            $vendor_inviter_user_id = $superadmin_user_id;
        }

        $litecoin->moveFromAccountToAccount($order->get('user_id'), $vendor_inviter_user_id, $vendorCommission);

        sleep(1);

        $vendor_invite_finalized = $this->InvitesFinalized->newEntity([
            'order_id' => $order->get('id'),
            'commission' => $vendorCommission,
            'finalized' => new \DateTime('now'),
            'invite_id' => $vendor_invite_id
        ]);
        $this->InvitesFinalized->save($vendor_invite_finalized);

        $order->set('paid_commission_vendor', 1);

        //
        // End Vendor Commissions

        //
        // Admins Commissions
        //

        $adminsCommission = Math::roundCryptoDown($order->get('order_total_crypto') * Settings::getAdminsCommissionPercent());
        $adminInviteIDs = Invites::getAdminsInviteIDs();

        if(count($adminInviteIDs) == 0)
        {
            $adminInviteIDs[] = $superadmin_invite_id;
        }

        $adminIndividualCommission = Math::roundCryptoDown($adminsCommission / count($adminInviteIDs));

        foreach($adminInviteIDs as $adminInviteID)
        {
            $admin_user_id = Invites::getUserIDByInviteID($adminInviteID);

            $litecoin->moveFromAccountToAccount($order->get('user_id'), $admin_user_id, $adminIndividualCommission);

            sleep(1);

            $admin_invite_finalized = $this->InvitesFinalized->newEntity([
                'order_id' => $order->get('id'),
                'commission' => $adminIndividualCommission,
                'finalized' => new \DateTime('now'),
                'invite_id' => $adminInviteID
            ]);
            $this->InvitesFinalized->save($admin_invite_finalized);
        }

        $order->set('paid_commission_admins', 1);

        //
        // End Admins Commissions

        //
        // Vendor Pay Out
        //
        $totalCommissions = Math::roundCryptoDown($userCommission + $vendorCommission + $adminsCommission + $superAdminsCommission);

        $totalVendorCryptoToPayout = number_format(Math::roundDown($order->get('order_total_crypto') - $totalCommissions), 8);

        $vendor_user_id = Vendors::getVendorUserIDByOrder($order);

        $litecoin->moveFromAccountToAccount($order->get('user_id'), $vendor_user_id, $totalVendorCryptoToPayout);

        $order->set('paid_vendor', 1);
        $order->set('order_total_crypto_paid', $totalVendorCryptoToPayout);

        //
        // End Vendor Payout

        $this->Orders->save($order);

        $this->Flash->success('Your Order Has Been Finalized.');

        $this->redirect($this->referer());
    }

    public function unfinalize($id = null)
    {
        $order = $this->Orders->get($id);

        $this->amiuser($order);

        if($order->get('status') == 2 || $order->get('status') == 3) {
            $order->set('finalize_early', 0);
            $this->Orders->save($order);

            $this->Flash->success('Your Order Will Not Finalize Early.');
        }
        else {

            $this->Flash->error('Unable To Remove Finalize Early.');
        }

        return $this->redirect($this->referer());
    }

    public function rate($id = null)
    {
        $data = $this->request->getData();

        $order = $this->Orders->get($id);

        $this->amiuser($order);

        $this->loadModel('Products');
        $this->loadModel('Vendors');
        $this->loadModel('Reviews');

        $review = $this->Reviews->find('all')->where(['order_id' => $id])->first();

        $oldStars = 0;
        $stars = 0;
        $reviewCount = 0;

        if(!isset($review))
        {
            $new_review = $this->Reviews->newEntity([
                'order_id' => $id,
                'comment' => $data['review_comment'],
                'stars' => $data['review_star'],
                'created' => new \DateTime('now'),
                'modified' => new \DateTime('now')
            ]);

            $this->Reviews->save($new_review);

            $stars = $data['review_star'];
            $reviewCount = 1;
        }
        else {

            $oldStars = $review->get('stars');
            $stars = $data['review_star'];

            $review->set('comment', $data['review_comment']);
            $review->set('stars', $data['review_star']);
            $review->set('modified', new \DateTime('now'));

            $this->Reviews->save($review);
        }

        $order->set('status', 6);
        $order->set('rated', new \DateTime('now'));
        $this->Orders->save($order);

        $product = $this->Products->find('all')->where(['id' => $order->product_id])->first();
        $vendor_id = $product->get('vendor_id');
        $vendor = $this->Vendors->find('all')->where(['id' => $vendor_id])->first();

        $vendor->set('total_stars', (($vendor->get('total_stars') - $oldStars) + $stars));
        $vendor->set('total_reviews', $vendor->get('total_reviews') + $reviewCount);
        $vendor->set('rating', $vendor->get('total_stars') / $vendor->get('total_reviews'));
        $this->Vendors->save($vendor);

        $product->set('total_stars', (($product->get('total_stars') - $oldStars) + $stars));
        $product->set('total_reviews', $product->get('total_reviews') + $reviewCount);
        $product->set('rating', $product->get('total_stars') / $product->get('total_reviews'));
        $this->Products->save($product);

        return $this->redirect($this->referer());
    }

    private function amiuser($order)
    {
        if($order->get('user_id') != $this->Auth->user('id'))
        {
            Janitor::hackAttempt();;
        }
    }

    private function amirite($order)
    {
        $this->loadModel('Products');
        $this->loadModel('Vendors');

        $product = $this->Products->get($order->product_id);
        $vendor = $this->Vendors->find('all')->where(['user_id' => $this->Auth->user('id')])->first();

        if(!isset($vendor) || $vendor->id != $product->vendor_id) {

            Janitor::hackAttempt();
        }
    }

    public function bulk()
    {
        $this->loadModel('Products');
        $this->loadModel('Vendors');

        $data = $this->request->getData();

        foreach($data['bulk'] as $id)
        {
            $order = $this->Orders->get($id);

            $this->amirite($order);

            $product = $this->Products->get($order->product_id);
            $vendor = $this->Vendors->find('all')->where(['user_id' => $this->Auth->user('id')])->first();

            if(!isset($vendor) || $vendor->id != $product->vendor_id) {

                return $this->redirect($this->referer());
            }

            if($data['submit'] == 'accept') {
                $order->set('status', 3);
                $order->set('accepted', new \DateTime('now'));
            }
            else {
                $order->set('status', -1);
            }

            $this->Orders->save($order);
        }

        return $this->redirect($this->referer());
    }

    /**
     * Delete method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $order = $this->Orders->get($id);

        $this->amiuser($order);

        MenuCounts::updateVendorViewedIncomingSubtract(Vendors::getVendorIDByOrder($order));

        if($order->get('user_id') != $this->Auth->user('id')) {

            return $this->redirect($this->referer());
        }

        if($order->get('status') == 0 || $order->get('status') == 1 || $order->get('status') == 2) {

            if ($this->Orders->delete($order)) {
                $this->Flash->success(__('The order has been deleted.'));
            } else {
                $this->Flash->error(__('The order could not be deleted. Please, try again.'));
            }
        }

        return $this->redirect(['action' => 'index']);
    }
}
