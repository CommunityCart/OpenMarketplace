<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Utility\Users;
use App\Utility\MenuCounts;

/**
 * Wallets Controller
 *
 *
 * @method \App\Model\Entity\Wallet[] paginate($object = null, array $settings = [])
 */
class WalletsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->loadModel('Users');
        $this->loadModel('Orders');
        $this->loadModel('WalletTransactions');

        $user = Users::getUser($this->Auth->user('id'));

        MenuCounts::updateUserViewedWallet($this->Auth->user('id'), true);

        $orders = $this->Orders->find('all')->where(['user_id' => $this->Auth->user('id'), 'status' => 0])->all();

        if(count($orders) > 0) {

            $total = 0;

            foreach($orders as $order) {

                $total = $total + $order->get('order_total_dollars');
            }
        }

        $wallets = $this->Wallets->find('all')->where(['user_id' => $this->Auth->user('id')]);

        $walletTransactions = $this->WalletTransactions->find('all');

        foreach($wallets as $wallet)
        {
            $walletTransactions = $walletTransactions->orWhere(['wallet_id' => $wallet->get('id')]);

            $currentWallet = $wallet;
        }

        $walletTransactions = $walletTransactions->orderDesc('transaction_time')->limit(100)->all();

        $totalBalanceMinusEscrowFinalized = \App\Utility\Wallet::getWalletBalance($this->Auth->user('id'));

        $totalBalance = $totalBalanceMinusEscrowFinalized[1];
        $totalUSDBalance = $totalBalanceMinusEscrowFinalized[0];

        if(isset($total)) {

            $missing = $totalBalance - $total;
            $missing2 = $missing + ($missing * .1);
            $missing2 = \App\Utility\Currency::Convert('usd', -$missing2, 'cmc');

            $this->set('missing2', $missing2 . ' CMC');
            $this->set('missing', $missing);
            $this->set('total', $total);
        }

        $this->set('walletTransactions', $walletTransactions);
        $this->set('role', $user->get('role'));
        if($user->get('role') == 'vendor') {
            $this->set('orders_escrow', \App\Utility\Wallet::getOrdersEscrowDollars($this->Auth->user('id')));
            $this->set('orders_escrow_crypto', \App\Utility\Wallet::getOrdersEscrowCrypto($this->Auth->user('id')));
        }
        $this->set('escrow', \App\Utility\Wallet::getEscrowDollars($this->Auth->user('id')));
        $this->set('escrow_crypto', \App\Utility\Wallet::getEscrowCrypto($this->Auth->user('id')));
        $this->set(compact('wallets', 'currentWallet', 'totalBalance', 'totalUSDBalance'));
        $this->set('_serialize', ['wallets']);
    }

    public function withdrawal()
    {

    }

    /**
     * View method
     *
     * @param string|null $id Wallet id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $wallet = $this->Wallets->get($id, [
            'contain' => []
        ]);

        $this->set('wallet', $wallet);
        $this->set('_serialize', ['wallet']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $wallet = $this->Wallets->newEntity();
        if ($this->request->is('post')) {
            $wallet = $this->Wallets->patchEntity($wallet, $this->request->getData());
            if ($this->Wallets->save($wallet)) {
                $this->Flash->success(__('The wallet has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The wallet could not be saved. Please, try again.'));
        }
        $this->set(compact('wallet'));
        $this->set('_serialize', ['wallet']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Wallet id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $wallet = $this->Wallets->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $wallet = $this->Wallets->patchEntity($wallet, $this->request->getData());
            if ($this->Wallets->save($wallet)) {
                $this->Flash->success(__('The wallet has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The wallet could not be saved. Please, try again.'));
        }
        $this->set(compact('wallet'));
        $this->set('_serialize', ['wallet']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Wallet id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $wallet = $this->Wallets->get($id);
        if ($this->Wallets->delete($wallet)) {
            $this->Flash->success(__('The wallet has been deleted.'));
        } else {
            $this->Flash->error(__('The wallet could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
