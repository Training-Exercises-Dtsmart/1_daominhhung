<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%category_post}}`
 */
class m240702_094712_create_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'title' => $this->string(),
            'img' => $this->string(),
            'description' => $this->text(),
            'category_post_id' => $this->integer(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'deleted_at' => $this->dateTime(),
        ]);

        $this->createIndex(
            '{{%idx-post-user_id}}',
            '{{%post}}',
            'user_id'
        );

        // add foreign key for table `{{%category_post}}`
        $this->addForeignKey(
            '{{%fk-post-user_id}}',
            '{{%post}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `categories_post_id`
        $this->createIndex(
            '{{%idx-post-category_post_id}}',
            '{{%post}}',
            'category_post_id'
        );

        // add foreign key for table `{{%category_post}}`
        $this->addForeignKey(
            '{{%fk-post-category_post_id}}',
            '{{%post}}',
            'category_post_id',
            '{{%category_post}}',
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
            '{{%fk-post-user_id}}',
            '{{%post}}'
        );

        // drops index for column `categories_post_id`
        $this->dropIndex(
            '{{%idx-post-user_id}}',
            '{{%post}}'
        );
        // drops foreign key for table `{{%category_post}}`
        $this->dropForeignKey(
            '{{%fk-post-category_post_id}}',
            '{{%post}}'
        );

        // drops index for column `categories_post_id`
        $this->dropIndex(
            '{{%idx-post-category_post_id}}',
            '{{%post}}'
        );

        $this->dropTable('{{%post}}');
    }
}
