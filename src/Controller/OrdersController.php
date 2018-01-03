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
    public function orderReview($id = null)
    {
        $data = $this->request->getData();

        $this->loadModel('Products');
        $this->loadModel('Wallets');
        $this->loadModel('ShippingOptions');

        $wallets = $this->Wallets->find('all', ['contain' => ['Users', 'Currencies']])->where(['Wallets.user_id' => $this->Auth->user('id'), 'Wallets.currency_id' => '4'])->all();

        $totalBalance = 0;

        foreach($wallets as $wallet)
        {
            $totalBalance = $totalBalance + $wallet->wallet_balance;
        }

        $productsResult = $this->Products->find('all', ['contain' => ['Vendors', 'Vendors.Users', 'ProductCategories', 'Countries', 'Orders', 'ProductCountries', 'ProductImages', 'Vendors.ShippingOptions']])->where(['Products.id' => $id])->first();

        $shippingOptions = $this->ShippingOptions->find('all')->where(['id' => $data['shipping_options']])->first();

        if($totalBalance > ($productsResult->cost * $data['quantity'])) {

            $this->set('balance', 'high');

            $missingBalance = 0;
        }
        else {
            $missingBalance = ($productsResult->cost * $data['quantity']) - $totalBalance;

            $this->set('balance', 'low');
            $this->set('missingBalance', $missingBalance);
        }

        $order = $this->Orders->newEntity([
            'user_id' => $this->Auth->user('id'),
            'product_id' => $id,
            'wallet_transaction_id' => -1,
            'status' => 0,
            'quantity' => $data['quantity'],
            'shipping_option_id' => $data['shipping_options'],
            'created' => new \DateTime('now')
        ]);

        $this->Orders->save($order);

        $this->set('shipping_options', $shippingOptions);
        $this->set('image_index', '0');
        $this->set('id', $id);
        $this->set('product', $productsResult);
    }

    public function orderReview2($id = null)
    {
        $data = $this->Orders->find('all')->where(['id' => $id, 'user_id' => $this->Auth->user('id')])->first();

        $this->loadModel('Products');
        $this->loadModel('Wallets');
        $this->loadModel('ShippingOptions');

        $wallets = $this->Wallets->find('all', ['contain' => ['Users', 'Currencies']])->where(['Wallets.user_id' => $this->Auth->user('id'), 'Wallets.currency_id' => '4'])->all();

        $totalBalance = 0;

        foreach($wallets as $wallet)
        {
            $totalBalance = $totalBalance + $wallet->wallet_balance;
        }

        $productsResult = $this->Products->find('all', ['contain' => ['Vendors', 'Vendors.Users', 'ProductCategories', 'Countries', 'Orders', 'ProductCountries', 'ProductImages', 'Vendors.ShippingOptions']])->where(['Products.id' => $data->product_id])->first();

        $shippingOptions = $this->ShippingOptions->find('all')->where(['id' => $data->shipping_option_id])->first();

        if($totalBalance > ($productsResult->cost * $data->quantity)) {

            $this->set('balance', 'high');

            $missingBalance = 0;
        }
        else {
            $missingBalance = ($productsResult->cost * $data->quantity) - $totalBalance;

            $this->set('balance', 'low');
            $this->set('missingBalance', $missingBalance);
        }

        $this->set('shipping_options', $shippingOptions);
        $this->set('image_index', '0');
        $this->set('id', $id);
        $this->set('product', $productsResult);

        $this->render('order_review');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
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
