<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Utility\Images;

/**
 * ProductImages Controller
 *
 *
 * @method \App\Model\Entity\ProductImage[] paginate($object = null, array $settings = [])
 */

class ProductImagesController extends AppController
{
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        $productImage = $this->ProductImages->newEntity();

        if ($this->request->is('post')) {

            $fileArray = $this->request->getData('upload');
            $filePath = $fileArray['tmp_name'];

            if (file_exists(WWW_ROOT . '/images/' . date('M-Y')) == false) {
                mkdir(WWW_ROOT . '/images/' . date('M-Y'));
            }

            $fileExtArray = explode('.', $fileArray['name']);
            $ext = end($fileExtArray);

            $originalPath = WWW_ROOT . 'images/' . date('M-Y') . '/' . basename($filePath) . '.original.' . $ext;

            move_uploaded_file($filePath, $originalPath);

            Images::convertImage($originalPath, $originalPath . '.jpg', 80);

            try { unlink($originalPath); } catch(\Exception $ex) { }

            Images::resizeImage($originalPath . '.jpg', WWW_ROOT . 'images/' . date('M-Y') . '/' . basename($filePath) . '.display.jpg');
            Images::thumbImage($originalPath . '.jpg', WWW_ROOT . 'images/' . date('M-Y') . '/' . basename($filePath) . '.thumb.jpg');

            $productImage = $this->ProductImages->newEntity([
                'product_id' => $id,
                'image_full' => '/images/' . date('M-Y') . '/' . basename($filePath),
                'image_display' => '/images/' . date('M-Y') . '/' . basename($filePath) . '.display.jpg',
                'image_thumbnail' => '/images/' . date('M-Y') . '/' . basename($filePath) . '.thumb.jpg'
            ]);
            if ($this->ProductImages->save($productImage)) {
                $this->Flash->success(__('The product image has been saved.'));

                return $this->redirect('/products/edit/' . $id);
            }
            $this->Flash->error(__('The product image could not be saved. Please, try again.'));
        }
        $this->set(compact('productImage'));
        $this->set('_serialize', ['productImage']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Product Image id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productImage = $this->ProductImages->get($id);
        if ($this->ProductImages->delete($productImage)) {
            $this->Flash->success(__('The product image has been deleted.'));
        } else {
            $this->Flash->error(__('The product image could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }
}
