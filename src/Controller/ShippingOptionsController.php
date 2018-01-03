<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Utility\Users;

/**
 * ShippingOptions Controller
 *
 * @property \App\Model\Table\ShippingOptionsTable $ShippingOptions
 *
 * @method \App\Model\Entity\ShippingOption[] paginate($object = null, array $settings = [])
 */
class ShippingOptionsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $vendor_id = \App\Utility\Users::getVendorID($this->Auth->user('id'));

        $this->paginate = [
            'contain' => ['Vendors']
        ];
        $shippingOptions = $this->paginate($this->ShippingOptions->find('all')->where(['vendor_id' => $vendor_id]));

        $this->set(compact('shippingOptions'));
        $this->set('_serialize', ['shippingOptions']);
    }

    /**
     * View method
     *
     * @param string|null $id Shipping Option id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $vendor_id = \App\Utility\Users::getVendorID($this->Auth->user('id'));

        $shippingOption = $this->ShippingOptions->find('all')->where(['id' => $id, 'vendor_id' => $vendor_id]);
        $shippingOption = $shippingOption->first();

        $this->set('shippingOption', $shippingOption);
        $this->set('_serialize', ['shippingOption']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $vendor_id = \App\Utility\Users::getVendorID($this->Auth->user('id'));

        $shippingOption = $this->ShippingOptions->newEntity();
        if ($this->request->is('post')) {
            $shippingOption = $this->ShippingOptions->patchEntity($shippingOption, $this->request->getData());
            if ($this->ShippingOptions->save($shippingOption)) {
                $this->Flash->success(__('The shipping option has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The shipping option could not be saved. Please, try again.'));
        }
        $vendors = $this->ShippingOptions->Vendors->find('list', ['limit' => 200]);

        $this->set('vendor_id', $vendor_id);
        $this->set(compact('shippingOption', 'vendors'));
        $this->set('_serialize', ['shippingOption']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Shipping Option id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $vendor_id = \App\Utility\Users::getVendorID($this->Auth->user('id'));

        $shippingOption = $this->ShippingOptions->find('all')->where(['id' => $id, 'vendor_id' => $vendor_id]);
        $shippingOption = $shippingOption->first();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $shippingOption = $this->ShippingOptions->patchEntity($shippingOption, $this->request->getData());
            if ($this->ShippingOptions->save($shippingOption)) {
                $this->Flash->success(__('The shipping option has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The shipping option could not be saved. Please, try again.'));
        }
        $vendors = $this->ShippingOptions->Vendors->find('list', ['limit' => 200]);
        $this->set(compact('shippingOption', 'vendors'));
        $this->set('_serialize', ['shippingOption']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Shipping Option id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $vendor_id = \App\Utility\Users::getVendorID($this->Auth->user('id'));

        $this->request->allowMethod(['post', 'delete']);
        $shippingOption = $this->ShippingOptions->find('all')->where(['id' => $id, 'vendor_id' => $vendor_id]);
        $shippingOption = $shippingOption->first();

        if ($this->ShippingOptions->delete($shippingOption)) {
            $this->Flash->success(__('The shipping option has been deleted.'));
        } else {
            $this->Flash->error(__('The shipping option could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
