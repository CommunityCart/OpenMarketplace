<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ProductImages Controller
 *
 *
 * @method \App\Model\Entity\ProductImage[] paginate($object = null, array $settings = [])
 */
class ProductImagesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $productImages = $this->paginate($this->ProductImages);

        $this->set(compact('productImages'));
        $this->set('_serialize', ['productImages']);
    }

    /**
     * View method
     *
     * @param string|null $id Product Image id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $productImage = $this->ProductImages->get($id, [
            'contain' => []
        ]);

        $this->set('productImage', $productImage);
        $this->set('_serialize', ['productImage']);
    }

    private function resizeImage($filename, $to_filename)
    {
        list($width, $height) = getimagesize($filename);

        if ($height > 800) {
            $newwidth = (800 / $height) * $width;
            $newheight = 800;
        }

        # wider
        if ($width > 600) {
            $newheight = (600 / $width) * $height;
            $newwidth = 600;
        }

        $thumb = imagecreatetruecolor($newwidth, $newheight);
        $source = imagecreatefromjpeg($filename);

        imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        imagejpeg($thumb, $to_filename);
    }

    private function thumbImage($filename, $to_filename)
    {
        list($width, $height) = getimagesize($filename);

        if ($height > 200) {
            $newwidth = (200 / $height) * $width;
            $newheight = 200;
        }

        # wider
        if ($width > 150) {
            $newheight = (150 / $width) * $height;
            $newwidth = 150;
        }

        $thumb = imagecreatetruecolor($newwidth, $newheight);
        $source = imagecreatefromjpeg($filename);

        imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        imagejpeg($thumb, $to_filename);
    }

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

            if(file_exists(WWW_ROOT . '/images/' . date('M-Y')) == false) {
                mkdir(WWW_ROOT . '/images/' . date('M-Y'));
            }

            $this->resizeImage($filePath, WWW_ROOT . 'images/' . date('M-Y') . '/' . basename($filePath) . '.display.jpg');
            $this->thumbImage($filePath, WWW_ROOT . 'images/' . date('M-Y') . '/' . basename($filePath) . '.thumb.jpg');

            move_uploaded_file($filePath, WWW_ROOT . 'images/' . date('M-Y') . '/' . basename($filePath));

            $productImage = $this->ProductImages->newEntity([
                'product_id' => $id,
                'image_full' => WWW_ROOT . 'images/' . date('M-Y') . '/' . basename($filePath),
                'image_display' => WWW_ROOT . 'images/' . date('M-Y') . '/' . basename($filePath) . '.display.jpg',
                'image_thumbnail' => WWW_ROOT . 'images/' . date('M-Y') . '/' . basename($filePath) . '.thumb.jpg'
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
     * Edit method
     *
     * @param string|null $id Product Image id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productImage = $this->ProductImages->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productImage = $this->ProductImages->patchEntity($productImage, $this->request->getData());
            if ($this->ProductImages->save($productImage)) {
                $this->Flash->success(__('The product image has been saved.'));

                return $this->redirect(['action' => 'index']);
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
