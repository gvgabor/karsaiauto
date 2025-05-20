<?php

/**
 * Handles the creation of table `{{%idoszakok}}`.
 */
class m250520_045225_create_idoszakok_table extends \app\components\Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%idoszakok}}', [
            'id'                 => $this->primaryKey(),
            'idoszak_megnevezes' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%idoszakok}}');
    }
}
