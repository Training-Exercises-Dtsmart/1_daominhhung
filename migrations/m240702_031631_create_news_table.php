<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%news}}`.
 */
class m240702_031631_create_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%news}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'message' => $this->string()->notNull(),
            'created_at' => $this->dateTime(),
            'update_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%news}}');
    }
}
