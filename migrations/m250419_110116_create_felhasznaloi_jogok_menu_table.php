<?php

/**
 * Handles the creation of table `{{%felhasznaloi_jogok_menu}}`.
 */
class m250419_110116_create_felhasznaloi_jogok_menu_table extends \app\components\Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%felhasznaloi_jogok_menu}}', [
            'id'                    => $this->primaryKey(),
            'felhasznaloi_jogok_id' => $this->integer(),
            'menu_id'               => $this->integer(),
        ]);

        $this->createIndex('felhasznaloi_jogok_idx', '{{%felhasznaloi_jogok_menu}}', 'felhasznaloi_jogok_id');
        $this->createIndex('menu_idx', '{{%felhasznaloi_jogok_menu}}', 'menu_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%felhasznaloi_jogok_menu}}');
    }
}
