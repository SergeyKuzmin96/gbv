<?php

use yii\db\Migration;

/**
 * Class m220608_175151_createTableReviewsImages
 */
class m220608_175151_createTableReviewsImages extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table_options = null;
        if ($this->db->driverName === 'mysql') {
            $table_options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('reviews_images', [
            'id' => $this->primaryKey(),
            'review_id' => $this->integer()->notNull(),
            'path' => $this->string()->notNull(),
            'date_add' => $this->timestamp()->notNull()
                ->defaultExpression('CURRENT_TIMESTAMP'),
        ], $table_options);

        $this->addForeignKey('fk_reviews_images',
            'reviews_images', 'review_id',
            'reviews', 'id',
            'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_reviews_images', 'reviews_images');
        $this->dropTable('reviews_images');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220608_175151_createTableReviewsImages cannot be reverted.\n";

        return false;
    }
    */
}
