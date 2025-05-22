<?php

/**
 * Handles the creation of table `{{%autok_image}}`.
 */
class m250521_063111_create_autok_image_table extends \app\components\Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%autok_image}}', [
            'id'       => $this->primaryKey(),
            'autok_id' => $this->integer(),
            'sorrend'  => $this->integer()->defaultValue(0),
            'name'     => $this->string(),
        ]);

        $this->createIndex('autok_id', '{{%autok_image}}', 'autok_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%autok_image}}');
    }
}
