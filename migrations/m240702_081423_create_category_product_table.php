<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category_product}}`.
 */
class m240702_081423_create_category_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%category_product}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'name' => $this->string(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'deleted_at' => $this->dateTime(),
        ]);

        $this->createIndex(
            '{{%idx-category_product-user_id}}',
            '{{%category_product}}',
            'user_id'
        );

        $this->addForeignKey(
            '{{%fk-category_product-user_id}}',
            '{{%category_product}}',
            'user_id',
            '{{%user}}',
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
            '{{%fk-category_product-user_id}}',
            '{{%category_product}}'
        );

        // drops index for column `categories_id`
        $this->dropIndex(
            '{{%idx-category_product-user_id}}',
            '{{%category_product}}'
        );
        $this->dropTable('{{%category_product}}');
    }
}
