<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%complete_job}}`.
 */
class m240715_080322_create_complete_job_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%complete_job}}', [
            'id' => $this->primaryKey(),
            'job_id' => $this->bigInteger()->notNull(),
            'job_data' => $this->binary()->notNull(),
            'completed_at' => $this->integer()->notNull(),
            'status' => $this->string(255)->notNull()->defaultValue('completed'),
        ]);
        $this->createIndex('idx-complete_job-job_id', '{{%complete_job}}', 'job_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%complete_job}}');
    }
}
