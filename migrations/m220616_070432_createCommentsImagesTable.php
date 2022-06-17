<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comments_images}}`.
 */
class m220616_070432_createCommentsImagesTable extends Migration
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

        $this->createTable('comments_images', [
            'id' => $this->primaryKey(),
            'comment_id' => $this->integer()->notNull(),
            'path' => $this->string()->notNull(),
            'date_add' => $this->timestamp()->notNull()
                ->defaultExpression('CURRENT_TIMESTAMP'),
        ], $table_options);

        $this->addForeignKey('fk_comments_images',
            'comments_images', 'comment_id',
            'comments', 'id',
            'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_comments_images', 'comments_images');
        $this->dropTable('comments_images');
    }
}
