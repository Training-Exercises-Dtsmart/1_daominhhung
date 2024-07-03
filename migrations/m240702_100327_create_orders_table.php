<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orders}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 */
class m240702_100327_create_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey(),
            'code_order' => $this->string()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'date' => $this->datetime()->notNull(),
            'status' => $this->integer()->notNull(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-orders-user_id}}',
            '{{%orders}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-orders-user_id}}',
            '{{%orders}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-orders-user_id}}',
            '{{%orders}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-orders-user_id}}',
            '{{%orders}}'
        );

        $this->dropTable('{{%orders}}');
    }
}
