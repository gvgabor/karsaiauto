<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%kivitel}}`.
 */
class m250529_104909_create_kivitel_table extends \app\components\Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%kivitel}}', [
            'id'   => $this->primaryKey(),
            'name' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%kivitel}}');
    }
}
