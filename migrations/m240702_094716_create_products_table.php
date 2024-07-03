<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%products}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%categories}}`
 * - `{{%posts}}`
 */
class m240702_094716_create_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%products}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'img' => $this->text()->notNull(),
            'price' => $this->integer()->notNull(),
            'quantity' => $this->float()->notNull(),
            'description' => $this->text()->notNull(),
            'categories_id' => $this->integer(),
            'post_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        // creates index for column `categories_id`
        $this->createIndex(
            '{{%idx-products-categories_id}}',
            '{{%products}}',
            'categories_id'
        );

        // add foreign key for table `{{%categories}}`
        $this->addForeignKey(
            '{{%fk-products-categories_id}}',
            '{{%products}}',
            'categories_id',
            '{{%categories}}',
            'id',
            'CASCADE'
        );

        // creates index for column `post_id`
        $this->createIndex(
            '{{%idx-products-post_id}}',
            '{{%products}}',
            'post_id'
        );

        // add foreign key for table `{{%posts}}`
        $this->addForeignKey(
            '{{%fk-products-post_id}}',
            '{{%products}}',
            'post_id',
            '{{%posts}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%categories}}`
        $this->dropForeignKey(
            '{{%fk-products-categories_id}}',
            '{{%products}}'
        );

        // drops index for column `categories_id`
        $this->dropIndex(
            '{{%idx-products-categories_id}}',
            '{{%products}}'
        );

        // drops foreign key for table `{{%posts}}`
        $this->dropForeignKey(
            '{{%fk-products-post_id}}',
            '{{%products}}'
        );

        // drops index for column `post_id`
        $this->dropIndex(
            '{{%idx-products-post_id}}',
            '{{%products}}'
        );

        $this->dropTable('{{%products}}');
    }
}
