<?php

use yii\db\Migration;

/**
 * Class m180907_011828_project_tables
 */
class m180907_011828_project_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->Integer()->notNull()->defaultValue(10),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'balance' => $this->Integer()->defaultValue(1000),
        ], $tableOptions);

        $this->createTable('conversion', [
            'id' => $this->primaryKey(),
            'user_id' => $this->Integer()->notNull(),
            'user_id_to_translate' => $this->Integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'time_transaction' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'translation' => $this->Integer()->defaultValue(0),
        ], $tableOptions);

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-conversion-user_id',
            'conversion',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180907_011828_project_tables cannot be reverted.\n";
        $this->dropTable('user');
        $this->dropTable('conversion');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180907_011828_project_tables cannot be reverted.\n";

        return false;
    }
    */
}
