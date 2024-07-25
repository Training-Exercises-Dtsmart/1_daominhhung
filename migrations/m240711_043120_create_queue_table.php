<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%queue}}`.
 */
class m240711_043120_create_queue_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%queue}}', [
            'id' => $this->primaryKey(),
            'channel' => $this->string(),
            'job' => $this->string(),
            'pushed_at' => $this->integer()->unsigned(),
            'ttr' => $this->integer()->unsigned(),
            'delay' => $this->integer()->unsigned(),
            'priority' => $this->integer()->unsigned(),
            'reserved_at' => $this->integer()->unsigned(),
            'attempt' => $this->integer()->unsigned(),
            'done_at' => $this->integer()->unsigned(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%queue}}');
    }
}
