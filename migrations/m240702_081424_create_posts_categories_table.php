<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%postscategories}}`.
 */
class m240702_081424_create_posts_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%posts_categories}}', [
            'id' => $this->primaryKey(),
            'value' => $this->string()->notNull(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%posts_categories}}');
    }
}
