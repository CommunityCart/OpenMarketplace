<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use App\Utility\Vendors;

/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 *
 * @method \App\Model\Entity\Product[] paginate($object = null, array $settings = [])
 */
class ProductsController extends AppController
{

    public function favorite($id = null)
    {
        $this->loadModel('ProductsFavorite');
        $favorite = $this->ProductsFavorite->newEntity([
            'product_id' => $id,
            'user_id' => $this->Auth->user('id')
        ]);
        $this->ProductsFavorite->save($favorite);

        $this->Flash->success('Product Added Successfully');

        $this->redirect($this->referer());
    }

    public function flag($id = null)
    {
        $this->loadModel('ProductsFlagged');
        $favorite = $this->ProductsFlagged->newEntity([
            'product_id' => $id,
            'user_id' => $this->Auth->user('id')
        ]);
        $this->ProductsFlagged->save($favorite);

        $this->Flash->success('Product Flagged Successfully');

        $this->redirect($this->referer());
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $vendorTable = TableRegistry::get('vendors');
        $vendorsQuery = $vendorTable->find('all')->where(['user_id' => $this->Auth->user('id')]);
        $vendorResult = $vendorsQuery->first();

        $this->paginate = [
            'contain' => ['Vendors', 'ProductCategories', 'Countries', 'ProductImages']
        ];

        if(isset($vendorResult)) {
            $products = $this->paginate($this->Products->find('all')->where(['Vendors.id' => $vendorResult->id]));
        }
        else if($this->Auth->user('role') == 'superadmin') {
            $products = $this->paginate($this->Products->find('all'));
        }
        else {

            $this->redirect('/dashboard?collapse=false');
        }

        $this->set(compact('products'));
        $this->set('_serialize', ['products']);
    }

    /**
     * View method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $image_index = $this->request->getQuery('image_index');

        if(!isset($image_index)) {
            $image_index = 0;
        }

        $product = $this->Products->get($id, [
            'contain' => ['Vendors', 'Vendors.Users', 'ProductCategories', 'Countries', 'Orders', 'Orders.Reviews', 'ProductCountries', 'ProductImages', 'Vendors.ShippingOptions']
        ]);

        $this->loadModel('Reviews');

        $reviews = $this->Reviews->find('all', ['contain' => ['Orders']])->where(['Orders.product_id' => $id])->limit(50)->orderDesc('Reviews.created')->all();

        $this->loadModel('Orders');

        $proudctOrderCount = $this->Orders->find('all')->where(['product_id' => $id])->count();
        $vendorOrderCount = $this->Orders->find('all', ['contain' => ['Products']])->where(['Products.vendor_id' => $product->get('vendor_id'), 'Orders.status >' => 1])->count();

        $this->loadModel('Vendors');

        $vendorRating = $this->Vendors->find('all')->where(['id' => $product->get('vendor_id')])->first();

        $this->set('vendorOrderCount', $vendorOrderCount);
        $this->set('vendorRating', $vendorRating->get('rating'));
        $this->set('productOrderCount', $proudctOrderCount);
        $this->set('reviews', $reviews);
        $this->set('id', $id);
        $this->set('image_index', $image_index);
        $this->set('product', $product);
        $this->set('_serialize', ['product']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $vendorTable = TableRegistry::get('vendors');
        $vendorsQuery = $vendorTable->find('all')->where(['user_id' => $this->Auth->user('id')]);
        $vendorResult = $vendorsQuery->first();

        if(isset($vendorResult)) {

            if ($this->request->is('post')) {
                $data = $this->request->getData();

                $product = $this->Products->newEntity([
                    'vendor_id' => $vendorResult->id,
                    'title' => $data['title'],
                    'body' => $data['body'],
                    'cost' => $data['cost'],
                    'product_category_id' => $data['product_category_id'],
                    'country_id' => $data['country_id'],
                    'created' => new \DateTime('now')
                ]);

                if ($this->Products->save($product)) {
                    $this->Flash->success(__('The product has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The product could not be saved. Please, try again.'));
            }
            else {
                $product = $this->Products->newEntity();
            }
            $vendors = $this->Products->Vendors->find('list', ['limit' => 200])->where(['vendor.id' => 1]);
            $productCategories = $this->Products->ProductCategories->find('list')->where(['product_category_id <>' => '0']);
            $countries = $this->Products->Countries->find('list');
            $shipToCountries = $this->Products->Countries->find('all');

            $shipToOptions = array();
            foreach($shipToCountries as $country) {

                $shipToOptions[$country->get('id')] = $country->get('name');
            }

            $this->set(compact('product', 'vendors', 'productCategories', 'countries', 'shipToOptions'));
            $this->set('_serialize', ['product']);
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->loadModel('ProductImages');
        $image = $this->ProductImages->newEntity();

        $product = $this->Products->get($id, [
            'contain' => ['Countries']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $product = $this->Products->patchEntity($product, $this->request->getData());
            if ($this->Products->save($product)) {
                $this->Flash->success(__('The product has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }
        $images = $this->Products->ProductImages->find('all')->where(['product_id' => $id]);
        $images = $images->all();
        $vendors = $this->Products->Vendors->find('list', ['limit' => 200]);
        $productCategories = $this->Products->ProductCategories->find('list');
        $countries = $this->Products->Countries->find('list');

        $this->set(compact('product', 'vendors', 'productCategories', 'countries', 'image', 'images'));
        $this->set('product_id', $id);
        $this->set('_serialize', ['product']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $product = $this->Products->get($id);
        if ($this->Products->delete($product)) {
            $this->Flash->success(__('The product has been deleted.'));
        } else {
            $this->Flash->error(__('The product could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
