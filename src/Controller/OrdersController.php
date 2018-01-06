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

        $totalBalance = \App\Utility\Wallet::getWalletBalance($this->Auth->user('id'));

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

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->loadModel('Products');
        $this->loadModel('Wallets');
        $this->loadModel('ShippingOptions');
        $this->loadModel('Vendors');

        $totalMissingBalance = 0;
        $totalBalance = \App\Utility\Wallet::getWalletBalance($this->Auth->user('id'));

        $orders = $this->Orders->find('all')->where(['Orders.user_id' => $this->Auth->user('id')])->all();

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

        $this->set(compact('orders'));
        $this->set('_serialize', ['orders']);
    }

    /**
     * View method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => ['Users', 'Products', 'WalletTransactions', 'ShippingOptions', 'Disputes', 'Reviews']
        ]);

        $this->set('order', $order);
        $this->set('_serialize', ['order']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $order = $this->Orders->newEntity();
        if ($this->request->is('post')) {
            $order = $this->Orders->patchEntity($order, $this->request->getData());
            if ($this->Orders->save($order)) {
                $this->Flash->success(__('The order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order could not be saved. Please, try again.'));
        }
        $users = $this->Orders->Users->find('list', ['limit' => 200]);
        $products = $this->Orders->Products->find('list', ['limit' => 200]);
        $walletTransactions = $this->Orders->WalletTransactions->find('list', ['limit' => 200]);
        $shippingOptions = $this->Orders->ShippingOptions->find('list', ['limit' => 200]);
        $this->set(compact('order', 'users', 'products', 'walletTransactions', 'shippingOptions'));
        $this->set('_serialize', ['order']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $order = $this->Orders->patchEntity($order, $this->request->getData());
            if ($this->Orders->save($order)) {
                $this->Flash->success(__('The order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order could not be saved. Please, try again.'));
        }
        $users = $this->Orders->Users->find('list', ['limit' => 200]);
        $products = $this->Orders->Products->find('list', ['limit' => 200]);
        $walletTransactions = $this->Orders->WalletTransactions->find('list', ['limit' => 200]);
        $shippingOptions = $this->Orders->ShippingOptions->find('list', ['limit' => 200]);
        $this->set(compact('order', 'users', 'products', 'walletTransactions', 'shippingOptions'));
        $this->set('_serialize', ['order']);
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
        $this->request->allowMethod(['post', 'delete']);
        $order = $this->Orders->get($id);
        if ($this->Orders->delete($order)) {
            $this->Flash->success(__('The order has been deleted.'));
        } else {
            $this->Flash->error(__('The order could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
