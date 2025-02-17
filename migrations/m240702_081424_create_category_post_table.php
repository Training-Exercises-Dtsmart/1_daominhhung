<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category_post}}`.
 */
class m240702_081424_create_category_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%category_post}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'name' => $this->string(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'deleted_at' => $this->dateTime(),
        ]);

        $this->createIndex(
            '{{%idx-category_post-user_id}}',
            '{{%category_post}}',
            'user_id'
        );

        $this->addForeignKey(
            '{{%fk-category_post-user_id}}',
            '{{%category_post}}',
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
            '{{%fk-category_post-user_id}}',
            '{{%category_post}}'
        );

        // drops index for column `categories_id`
        $this->dropIndex(
            '{{%idx-category_post-user_id}}',
            '{{%category_post}}'
        );

        $this->dropTable('{{%category_post}}');
    }
}
