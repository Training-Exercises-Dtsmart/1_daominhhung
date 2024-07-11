<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%category}}`
 * - `{{%post}}`
 * - `{{%user}}`
 */
class m240702_094716_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'name' => $this->string(),
            'image' => $this->text(),
            'price' => $this->integer(),
            'stock' => $this->integer()->unsigned(),
            'description' => $this->text(),
            'category_id' => $this->integer(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'deleted_at' => $this->dateTime(),
            'status' => $this->integer()->defaultValue(0),
        ]);

        $this->createIndex(
            '{{%idx-product-user_id}}',
            '{{%product}}',
            'user_id'
        );

        $this->addForeignKey(
            '{{%fk-product-user_id}}',
            '{{%product}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            '{{%idx-product-category_id}}',
            '{{%product}}',
            'category_id'
        );

        $this->addForeignKey(
            '{{%fk-product-category_id}}',
            '{{%product}}',
            'category_id',
            '{{%category_product}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk-product-user_id}}',
            '{{%product}}'
        );
        // drops index for column `categories_id`
        $this->dropIndex(
            '{{%idx-product-user_id}}',
            '{{%product}}'
        );
        // drops foreign key for table `{{%category}}`
        $this->dropForeignKey(
            '{{%fk-product-category_id}}',
            '{{%product}}'
        );
        // drops index for column `categories_id`
        $this->dropIndex(
            '{{%idx-product-category_id}}',
            '{{%product}}'
        );
        $this->dropTable('{{%product}}');
    }
}
