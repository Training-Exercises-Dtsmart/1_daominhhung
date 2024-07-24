<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_detail}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%cart_item}}`
 * - `{{%order}}`
 */
class m240702_100630_create_order_detail_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_detail}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'order_id' => $this->integer(),
            'price' => $this->float(),
            'quantity' => $this->float(),
            'payment' => $this->integer(),
            'status' => $this->integer(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'deleted_at' => $this->dateTime(),
        ]);

        // creates index for column `product_id`
        $this->createIndex(
            '{{%idx-order_detail-product_id}}',
            '{{%order_detail}}',
            'product_id'
        );

        // add foreign key for table `{{%products}}`
        $this->addForeignKey(
            '{{%fk-order_detail-product_id}}',
            '{{%order_detail}}',
            'product_id',
            '{{%product}}',
            'id',
            'CASCADE'
        );

        // creates index for column `order_id`
        $this->createIndex(
            '{{%idx-order_detail-order_id}}',
            '{{%order_detail}}',
            'order_id'
        );

        // add foreign key for table `{{%orders}}`
        $this->addForeignKey(
            '{{%fk-order_detail-order_id}}',
            '{{%order_detail}}',
            'order_id',
            '{{%order}}',
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
            '{{%fk-order_detail-product_id}}',
            '{{%order_detail}}'
        );

        // drops index for column `product_id`
        $this->dropIndex(
            '{{%idx-order_detail-product_id}}',
            '{{%order_detail}}'
        );

        // drops foreign key for table `{{%orders}}`
        $this->dropForeignKey(
            '{{%fk-order_detail-order_id}}',
            '{{%order_detail}}'
        );

        // drops index for column `order_id`
        $this->dropIndex(
            '{{%idx-order_detail-order_id}}',
            '{{%order_detail}}'
        );

        $this->dropTable('{{%order_detail}}');
    }
}
