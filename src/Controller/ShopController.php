<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class ShopController extends AppController
{
    public function index()
    {
        $this->loadModel('Products');
        $this->loadModel('ProductsFeatured');

        $pcid = $this->request->getQuery('product_category_id');

        if(isset($pcid)) {

            $categories = $this->getCategoryIds($pcid);
            $categories[] = $pcid;

            $title = $this->getCategoryTitle($pcid);

            $productsQuery = $this->ProductsFeatured->find('all',
                ['contain' =>
                    ['Products', 'Products.ProductImages', 'Products.ProductCategories', 'Products.Countries', 'Products.Vendors', 'Products.Vendors.Users']
                ]
            );

            foreach($categories as $category) {
                $productsQuery->orWhere(['ProductCategories.id' => $category]);
            }

            if($title == 'Product Categories') {

                $title = 'All Products';
            }

            $this->set('title', $title);

            $products = $this->paginate($productsQuery);
        }
        else {
            $products = $this->paginate($this->ProductsFeatured->find('all', ['contain' => ['Products', 'Products.ProductImages', 'Products.ProductCategories', 'Products.Countries', 'Products.Vendors', 'Products.Vendors.Users']]));

            $this->set('title', 'Featured Products');
        }


        $this->set(compact('products'));
        $this->set('_serialize', ['products']);
    }

    public function favorites()
    {
        $this->loadModel('Products');
        $this->loadModel('ProductsFavorite');

        $products = $this->paginate($this->ProductsFavorite->find('all',
            ['contain' =>
                ['Products', 'Products.ProductImages', 'Products.ProductCategories', 'Products.Countries', 'Products.Vendors', 'Products.Vendors.Users']
            ]
        )->where(['ProductsFavorite.user_id' => $this->Auth->user('id')]));

        $this->set('title', 'Favorite Products');
        $this->set(compact('products'));
        $this->set('_serialize', ['products']);

        $this -> render('index');
    }

    private function getCategoryTitle($id)
    {
        $this->loadModel('ProductCategories');

        $categories = $this->ProductCategories->find('all')->where(['id' => $id])->first();

        return $categories->category_name;
    }

    private function getCategoryIds($id)
    {
        $this->loadModel('ProductCategories');

        $categories = $this->ProductCategories->find('all')->where(['product_category_id' => $id])->all();

        $categoryArray = array();

        foreach($categories as $category)
        {
            $categoryArray[] = $category->id;

            $categoryArray = array_merge($categoryArray, $this->getCategoryIds($category->id));
        }

        return $categoryArray;
    }
}
