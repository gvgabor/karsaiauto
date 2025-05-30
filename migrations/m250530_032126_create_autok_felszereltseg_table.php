<?php

/**
 * Handles the creation of table `{{%autok_felszereltseg}}`.
 */
class m250530_032126_create_autok_felszereltseg_table extends \app\components\Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%autok_felszereltseg}}', [
            'id'               => $this->primaryKey(),
            'felszereltseg_id' => $this->integer(),
            'autok_id'         => $this->integer(),
        ]);
        $this->createIndex('felszereltseg_id', '{{%autok_felszereltseg}}', 'felszereltseg_id');
        $this->createIndex('autok_id', '{{%autok_felszereltseg}}', 'autok_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%autok_felszereltseg}}');
    }
}
