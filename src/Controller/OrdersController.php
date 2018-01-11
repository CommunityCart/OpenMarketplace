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

        $order = $this->Orders->find('all', ['contain' => ['Reviews']])->where(['id' => $id, 'user_id' => $this->Auth->user('id')])->first();

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
            $order->set('created', new \DateTime('now'));

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
        $this->loadModel('Vendors');

        $vendor = $this->Vendors->find('all')->where(['user_id' => $this->Auth->user('id')])->first();
        $vendor_id = $vendor->get('id');

        $orders = $this->Orders->find('all', ['contain' => ['Users', 'Products', 'ShippingOptions']])->where(['Orders.status' => 2, 'Products.vendor_id' => $vendor_id])->all();

        $this->set('title', 'Incoming Orders');
        $this->set(compact('orders'));
        $this->set('_serialize', ['orders']);

        $this->render('index');
    }

    public function submit($id = null)
    {
        $order = $this->Orders->get($id);

        $this->amiuser($order);

        $data = $this->request->getData('shipping_details');

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

        $order->set('status', 3);
        $order->set('accepted', new \DateTime('now'));
        $this->Orders->save($order);

        return $this->redirect($this->referer());
    }

    public function reject($id = null)
    {
        $order = $this->Orders->get($id);

        $this->amirite($order);

        $order->set('status', -1);
        $this->Orders->save($order);

        return $this->redirect($this->referer());
    }

    public function shipped($id = null)
    {
        $order = $this->Orders->get($id);

        $this->amirite($order);

        $order->set('status', 4);
        $order->set('shipped', new \DateTime('now'));
        $this->Orders->save($order);

        return $this->redirect($this->referer());
    }

    public function finalize($id = null)
    {
        $order = $this->Orders->get($id);

        $this->amiuser($order);

        $order->set('status', 5);
        $order->set('finalized', new \DateTime('now'));
        $this->Orders->save($order);

        return $this->redirect($this->referer());
    }

    public function rate($id = null)
    {
        $data = $this->request->getData();

        $order = $this->Orders->get($id);

        $this->amiuser($order);

        $this->loadModel('Reviews');

        $review = $this->Reviews->find('all')->where(['order_id' => $id])->first();

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
        }
        else {

            $review->set('comment', $data['review_comment']);
            $review->set('stars', $data['review_star']);
            $review->set('modified', new \DateTime('now'));

            $this->Reviews->save($review);
        }

        $order->set('status', 6);
        $order->set('rated', new \DateTime('now'));
        $this->Orders->save($order);

        $this->loadModel('Products');
        $this->loadModel('Vendors');

        $totalStars = 0;
        $totalReviews = 0;

        // TODO: Add columns to tables so that we dont have to grab every review to recalculate ratings

        $product = $this->Products->find('all')->where(['id' => $order->product_id])->first();
        $vendor_id = $product->get('vendor_id');
        $products = $this->Products->find('all')->where(['vendor_id' => $vendor_id])->all();

        foreach($products as $product) {

            $orders = $this->Orders->find('all', ['contain' => ['Reviews']])->where(['product_id' => $product->get('id')])->all();

            $totalProductStars = 0;
            $totalProductReviews = 0;

            foreach ($orders as $order) {

                if (isset($order->reviews[0])) {

                    $totalProductStars = $totalProductStars + $order->reviews[0]->stars;
                    $totalProductReviews = $totalProductReviews + 1;
                }
            }

            if($totalProductReviews > 0) {
                $rating = $totalProductStars / $totalProductReviews;

                $product->set('rating', $rating);
                $this->Products->save($product);
            }

            $totalStars = $totalStars + $totalProductStars;
            $totalReviews = $totalReviews + $totalProductReviews;
        }

        $vendor = $this->Vendors->find('all')->where(['id' => $vendor_id])->first();

        $vendorRating = $totalStars / $totalReviews;

        $vendor->set('rating', $vendorRating);
        $this->Vendors->save($vendor);

        return $this->redirect($this->referer());
    }

    private function amiuser($order)
    {
        if($order->get('user_id') != $this->Auth->user('id'))
        {
            return $this->redirect($this->referer());
        }
    }

    private function amirite($order)
    {
        $this->loadModel('Products');
        $this->loadModel('Vendors');

        $product = $this->Products->get($order->product_id);
        $vendor = $this->Vendors->find('all')->where(['user_id' => $this->Auth->user('id')])->first();

        if(!isset($vendor) || $vendor->id != $product->vendor_id) {

            return $this->redirect($this->referer());
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
