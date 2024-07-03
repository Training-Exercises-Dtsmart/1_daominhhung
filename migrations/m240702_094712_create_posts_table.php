<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%posts}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%postscategories}}`
 */
class m240702_094712_create_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%posts}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'img' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'categories_post_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        // creates index for column `categories_post_id`
        $this->createIndex(
            '{{%idx-posts-categories_post_id}}',
            '{{%posts}}',
            'categories_post_id'
        );

        // add foreign key for table `{{%postscategories}}`
        $this->addForeignKey(
            '{{%fk-posts-categories_post_id}}',
            '{{%posts}}',
            'categories_post_id',
            '{{%posts_categories}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%postscategories}}`
        $this->dropForeignKey(
            '{{%fk-posts-categories_post_id}}',
            '{{%posts}}'
        );

        // drops index for column `categories_post_id`
        $this->dropIndex(
            '{{%idx-posts-categories_post_id}}',
            '{{%posts}}'
        );

        $this->dropTable('{{%posts}}');
    }
}
