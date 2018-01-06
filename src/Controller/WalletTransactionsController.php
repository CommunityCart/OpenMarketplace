<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * WalletTransactions Controller
 *
 * @property \App\Model\Table\WalletTransactionsTable $WalletTransactions
 *
 * @method \App\Model\Entity\WalletTransaction[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WalletTransactionsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Wallets']
        ];
        $walletTransactions = $this->paginate($this->WalletTransactions);

        $this->set(compact('walletTransactions'));
    }

    /**
     * View method
     *
     * @param string|null $id Wallet Transaction id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $walletTransaction = $this->WalletTransactions->get($id, [
            'contain' => ['Wallets', 'Orders', 'UserTransactions']
        ]);

        $this->set('walletTransaction', $walletTransaction);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $walletTransaction = $this->WalletTransactions->newEntity();
        if ($this->request->is('post')) {
            $walletTransaction = $this->WalletTransactions->patchEntity($walletTransaction, $this->request->getData());
            if ($this->WalletTransactions->save($walletTransaction)) {
                $this->Flash->success(__('The wallet transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The wallet transaction could not be saved. Please, try again.'));
        }
        $wallets = $this->WalletTransactions->Wallets->find('list', ['limit' => 200]);
        $this->set(compact('walletTransaction', 'wallets'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Wallet Transaction id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $walletTransaction = $this->WalletTransactions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $walletTransaction = $this->WalletTransactions->patchEntity($walletTransaction, $this->request->getData());
            if ($this->WalletTransactions->save($walletTransaction)) {
                $this->Flash->success(__('The wallet transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The wallet transaction could not be saved. Please, try again.'));
        }
        $wallets = $this->WalletTransactions->Wallets->find('list', ['limit' => 200]);
        $this->set(compact('walletTransaction', 'wallets'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Wallet Transaction id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $walletTransaction = $this->WalletTransactions->get($id);
        if ($this->WalletTransactions->delete($walletTransaction)) {
            $this->Flash->success(__('The wallet transaction has been deleted.'));
        } else {
            $this->Flash->error(__('The wallet transaction could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
