<?php
use Migrations\AbstractMigration;

class CreateImages extends AbstractMigration
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
        $table->addColumn('image_full', 'text', [
            'null' => false,
        ]);
        $table->addColumn('image_display', 'text', [
            'null' => false,
        ]);
        $table->addColumn('image_thumbnail', 'text', [
            'null' => false,
        ]);
        $table->create();
    }
}
