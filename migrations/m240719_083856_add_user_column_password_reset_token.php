<?php

use yii\db\Migration;

/**
 * Class m240719_083856_add_user_column_password_reset_token
 */
class m240719_083856_add_user_column_password_reset_token extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'password_reset_token', $this->string()->after('access_token'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'password_reset_token');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240719_083856_add_user_column_password_reset_token cannot be reverted.\n";

        return false;
    }
    */
}
