<?php

/**
 * Handles the creation of table `{{%arvalaszto}}`.
 */
class m250520_061913_create_arvalaszto_table extends \app\components\Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%arvalaszto}}', [
            'id'           => $this->primaryKey(),
            'megnevezes'   => $this->string(),
            'kezdo_osszeg' => $this->integer(),
            'veg_osszeg'   => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%arvalaszto}}');
    }
}
