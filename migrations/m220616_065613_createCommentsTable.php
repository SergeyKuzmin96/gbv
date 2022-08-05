<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comments}}`.
 */
class m220616_065613_createCommentsTable extends Migration
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

        $this->createTable('comments', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'review_id' => $this->integer()->notNull(),
            'message' => $this->string()->notNull(),
            'date_add' => $this->timestamp()->notNull()
                ->defaultExpression('CURRENT_TIMESTAMP'),
            'date_update' => $this->timestamp()->notNull()
                ->defaultExpression('CURRENT_TIMESTAMP'),
        ], $table_options);

        $this->addForeignKey('fk_user_comments',
            'comments', 'user_id',
            'users', 'id',
            'CASCADE', 'CASCADE');

        $this->addForeignKey('review_comments',
            'comments', 'review_id',
            'reviews', 'id',
            'CASCADE', 'CASCADE');

    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('review_comments', 'comments');
        $this->dropForeignKey('fk_user_reviews', 'comments');
        $this->dropTable('comments');
    }
}
