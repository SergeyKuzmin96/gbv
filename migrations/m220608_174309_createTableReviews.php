<?php

use yii\db\Migration;

/**
 * Class m220608_174309_createTableReviews
 */
class m220608_174309_createTableReviews extends Migration
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

        $this->createTable('reviews', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'message' => $this->string()->notNull(),
            'date_add' => $this->timestamp()->notNull()
                ->defaultExpression('CURRENT_TIMESTAMP'),
        ], $table_options);

        $this->addForeignKey('fk_user_reviews',
            'reviews', 'user_id',
            'users', 'id',
            'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_user_reviews', 'reviews');
        $this->dropTable('reviews');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220608_174309_createTableReviews cannot be reverted.\n";

        return false;
    }
    */
}
