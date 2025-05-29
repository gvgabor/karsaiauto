<?php

/**
 * Handles the creation of table `{{%felszereltseg}}`.
 */
class m250529_121907_create_felszereltseg_table extends \app\components\Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable("feltszereltseg");
        $this->createTable('{{%felszereltseg}}', [
            'id'   => $this->primaryKey(),
            'name' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%felszereltseg}}');
    }
}
