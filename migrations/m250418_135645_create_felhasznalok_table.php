<?php

/**
 * Handles the creation of table `{{%felhasznalok}}`.
 */
class m250418_135645_create_felhasznalok_table extends \app\components\Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%felhasznalok}}', [
            'id'               => $this->primaryKey(),
            'felhasznaloi_nev' => $this->string(),
            'jelszo'           => $this->string(),
            'email'            => $this->string(),
            'felhasznaloi_jog' => $this->integer(),
        ]);
        $this->createIndex('felhasznaloi_jogx', '{{%felhasznalok}}', 'felhasznaloi_jog');
        $this->createIndex('emailx', '{{%felhasznalok}}', 'email');
        $this->createIndex('jelszox', '{{%felhasznalok}}', 'jelszo');
        $this->createIndex('felhasznaloi_nevx', '{{%felhasznalok}}', 'felhasznaloi_nev');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%felhasznalok}}');
    }
}
