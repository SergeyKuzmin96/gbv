<?php

use yii\db\Migration;

/**
 * Class m220606_071208_createTableUsers
 */
class m220606_071208_createTableUsers extends Migration
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

        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->notNull()->unique(),
            'password_hash' => $this->string(300)->notNull(),
            'auth_key' => $this->string(150),
            'token' => $this->string(150)->unique(),
            'date_add' => $this->timestamp()->notNull()
                ->defaultExpression('CURRENT_TIMESTAMP'),
        ], $table_options);

        $password = '123456';
        $email = 'admin@site.ru';

        $this->insert('users',[
            'id' => 1,
            'email' => $email,
            'password_hash' => Yii::$app->security->generatePasswordHash($password)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('users');

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220606_071208_createTableUsers cannot be reverted.\n";

        return false;
    }
    */
}
