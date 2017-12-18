<?php
use Migrations\AbstractMigration;

class CreateProductImages extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('product_images');
        $table->addColumn('product_id', 'integer', [
            'null' => false,
        ]);
        $table->addColumn('title','string', [
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('thumb_b64', 'text', [
            'null' => false,
        ]);
        $table->addColumn('image_b64','text', [
            'null' => false,
        ]);
        $table->create();
    }
}
