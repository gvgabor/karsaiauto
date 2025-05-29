<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%szinek}}`.
 */
class m250529_103832_create_szinek_table extends \app\components\Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%szinek}}', [
            'id'        => $this->primaryKey(),
            'szin_neve' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%szinek}}');
    }
}
