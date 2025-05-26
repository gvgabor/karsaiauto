<?php

/**
 * Handles the creation of table `{{%autok_dokumentumok}}`.
 */
class m250524_150421_create_autok_dokumentumok_table extends \app\components\Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%autok_dokumentumok}}', [
            'id'        => $this->primaryKey(),
            'autok_id'  => $this->integer(),
            'name'      => $this->string(),
            'extension' => $this->string(),
            'filename'  => $this->string(),
        ]);
        $this->createIndex('autok_id', '{{%autok_dokumentumok}}', 'autok_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%autok_dokumentumok}}');
    }
}
