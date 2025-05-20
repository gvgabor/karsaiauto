<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%_menu}}`.
 */
class m250419_030815_create__menu_table extends \app\components\Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%_menu}}', [
            'id'        => $this->primaryKey(),
            'menu_name' => $this->string(),
            'menu_url'  => $this->string(),
            'parent_id' => $this->integer()->defaultValue(null),
            'sorrend'   => $this->integer()->defaultValue(0)
        ]);

        $this->createIndex('parent_idx', '{{%_menu}}', 'parent_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%_menu}}');
    }
}
