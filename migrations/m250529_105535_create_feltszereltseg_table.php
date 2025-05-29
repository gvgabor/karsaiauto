<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%feltszereltseg}}`.
 */
class m250529_105535_create_feltszereltseg_table extends \app\components\Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%feltszereltseg}}', [
            'id'   => $this->primaryKey(),
            'name' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%feltszereltseg}}');
    }
}
