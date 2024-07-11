<?php

use yii\db\Migration;

/**
 * Class m240710_025358_init_rbac
 */
class m240710_025358_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240710_025358_init_rbac cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240710_025358_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
