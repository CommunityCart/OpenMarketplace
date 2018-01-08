<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Orders Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 *
 * @method \App\Model\Entity\Order[] paginate($object = null, array $settings = [])
 */
class OrdersController extends AppController
{
    public function orderReviewer($id = null, $idIsProduct = false)
    {
        $this->loadModel('Products');
        $this->loadModel('Wallets');
        $this->loadModel('ShippingOptions');
        $this->loadModel('Vendors');

        $order = $this->Orders->find('all')->where(['id' => $id, 'user_id' => $this->Auth->user('id')])->first();

        if($idIsProduct == true)
        {
            $data = $this->request->getData();
        }
        else {

            $data = $order;
        }

        $balances = \App\Utility\Wallet::getWalletBalance($this->Auth->user('id'));
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
        $productOrderCount = $this->Orders->find('all')->where(['product_id' => $productsResult->id, 'Orders.status >' => 1])->count();

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

        if($totalBalance > (($productsResult->cost * $quantity) + $shippingOptions->get('shipping_cost'))) {

            $this->set('balance', 'high');

            $missingBalance = 0;
            $status = 1;
        }
        else {
            $missingBalance = (($productsResult->cost * $quantity) + $shippingOptions->get('shipping_cost')) - $totalBalance;

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
                'created' => new \DateTime('now')
            ]);

            $this->Orders->save($order);
        }

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
        $totalBalance = \App\Utility\Wallet::getWalletBalance($this->Auth->user('id'));

        $orders = $this->Orders->find('all')->where(['Orders.user_id' => $this->Auth->user('id'), 'Orders.status <' => 2, 'Orders.status >' => -1])->all();

        foreach ($orders as $order) {

            $shipping_options = $order->shipping_option_id;

            $productsResult = $this->Products->find('all', ['contain' => ['Vendors', 'Vendors.Users', 'ProductCategories', 'Countries', 'Orders', 'ProductCountries', 'ProductImages', 'Vendors.ShippingOptions']])->where(['Products.id' => $order->product_id])->first();
            $shippingOptions = $this->ShippingOptions->find('all')->where(['id' => $shipping_options])->first();

            if($totalBalance > (($productsResult->cost * $order->quantity) + $shippingOptions->get('shipping_cost'))) {

                $missingBalance = 0;
                $status = 1;
            }
            else {
                $missingBalance = (($productsResult->cost * $order->quantity) + $shippingOptions->get('shipping_cost')) - $totalBalance;

                $status = 0;
            }

            $totalMissingBalance = $totalMissingBalance + $missingBalance;

            $order->set('status', $status);

            $this->Orders->save($order);
        }

        $this->paginate = [
            'contain' => ['Users', 'Products', 'ShippingOptions']
        ];
        $orders = $this->paginate($this->Orders->find('all', ['contain' => ['Users', 'Products', 'ShippingOptions']])->where(['Orders.user_id' => $this->Auth->user('id')]));

        $this->set('title', 'Shopping Cart');
        $this->set(compact('orders'));
        $this->set('_serialize', ['orders']);
    }

    public function incoming()
    {
        $this->loadModel('Vendors');

        $vendor = $this->Vendors->find('all')->where(['user_id' => $this->Auth->user('id')])->first();
        $vendor_id = $vendor->get('id');

        $this->paginate = [
            'contain' => ['Users', 'Products', 'ShippingOptions']
        ];
        $orders = $this->Orders->find('all', ['contain' => ['Users', 'Products', 'ShippingOptions']])->where(['Orders.status' => 2, 'Products.vendor_id' => $vendor_id])->all();

        $this->set('title', 'Incoming Orders');
        $this->set(compact('orders'));
        $this->set('_serialize', ['orders']);

        $this->render('index');
    }

    public function submit($id = null)
    {
        $order = $this->Orders->get($id);

        if($order->get('user_id') != $this->Auth->user('id')) {

            return $this->redirect($this->referer());
        }

        $data = $this->request->getData('shipping_details');

        $order->set('shipping_details', $data);
        $order->set('status', 2);
        $this->Orders->save($order);

        return $this->redirect('/orders');
    }

    public function accept($id = null)
    {
        $order = $this->Orders->get($id);

        $this->loadModel('Products');
        $this->loadModel('Vendors');

        $product = $this->Products->get($order->product_id);
        $vendor = $this->Vendors->find('all')->where(['user_id' => $this->Auth->user('id')])->first();

        if(!isset($vendor) || $vendor->id != $product->vendor_id) {

            return $this->redirect($this->referer());
        }

        $order->set('status', 3);
        $this->Orders->save($order);

        return $this->redirect($this->referer());
    }

    public function reject($id = null)
    {
        $order = $this->Orders->get($id);

        $this->loadModel('Products');
        $this->loadModel('Vendors');

        $product = $this->Products->get($order->product_id);
        $vendor = $this->Vendors->find('all')->where(['user_id' => $this->Auth->user('id')])->first();

        if(!isset($vendor) || $vendor->id != $product->vendor_id) {

            return $this->redirect($this->referer());
        }

        $order->set('status', -1);
        $this->Orders->save($order);

        return $this->redirect($this->referer());
    }

    public function bulk()
    {
        $this->loadModel('Products');
        $this->loadModel('Vendors');

        $data = $this->request->getData();

        foreach($data['bulk'] as $id)
        {
            $order = $this->Orders->get($id);
            $product = $this->Products->get($order->product_id);
            $vendor = $this->Vendors->find('all')->where(['user_id' => $this->Auth->user('id')])->first();

            if(!isset($vendor) || $vendor->id != $product->vendor_id) {

                return $this->redirect($this->referer());
            }

            if($data['submit'] == 'accept') {
                $order->set('status', 3);
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
