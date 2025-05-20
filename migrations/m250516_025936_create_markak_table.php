<?php

/**
 * Handles the creation of table `{{%markak}}`.
 */
class m250516_025936_create_markak_table extends \app\components\Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%markak}}', [
            'id'            => $this->primaryKey(),
            'name'          => $this->string(),
            'friendly_name' => $this->string(),
        ]);

        $this->createIndex('friendly_name', '{{%markak}}', 'friendly_name');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%markak}}');
    }
}
