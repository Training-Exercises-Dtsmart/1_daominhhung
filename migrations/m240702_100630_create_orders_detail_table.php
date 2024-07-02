<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orders_detail}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%products}}`
 * - `{{%orders}}`
 */
class m240702_100630_create_orders_detail_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%orders_detail}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'order_id' => $this->integer()->notNull(),
            'totalPrice' => $this->float()->notNull(),
            'totalQuantity' => $this->float()->notNull(),
            'payment' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // creates index for column `product_id`
        $this->createIndex(
            '{{%idx-orders_detail-product_id}}',
            '{{%orders_detail}}',
            'product_id'
        );

        // add foreign key for table `{{%products}}`
        $this->addForeignKey(
            '{{%fk-orders_detail-product_id}}',
            '{{%orders_detail}}',
            'product_id',
            '{{%products}}',
            'id',
            'CASCADE'
        );

        // creates index for column `order_id`
        $this->createIndex(
            '{{%idx-orders_detail-order_id}}',
            '{{%orders_detail}}',
            'order_id'
        );

        // add foreign key for table `{{%orders}}`
        $this->addForeignKey(
            '{{%fk-orders_detail-order_id}}',
            '{{%orders_detail}}',
            'order_id',
            '{{%orders}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%products}}`
        $this->dropForeignKey(
            '{{%fk-orders_detail-product_id}}',
            '{{%orders_detail}}'
        );

        // drops index for column `product_id`
        $this->dropIndex(
            '{{%idx-orders_detail-product_id}}',
            '{{%orders_detail}}'
        );

        // drops foreign key for table `{{%orders}}`
        $this->dropForeignKey(
            '{{%fk-orders_detail-order_id}}',
            '{{%orders_detail}}'
        );

        // drops index for column `order_id`
        $this->dropIndex(
            '{{%idx-orders_detail-order_id}}',
            '{{%orders_detail}}'
        );

        $this->dropTable('{{%orders_detail}}');
    }
}
