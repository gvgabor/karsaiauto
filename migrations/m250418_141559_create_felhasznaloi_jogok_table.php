<?php

use app\components\Migration;

/**
 * Handles the creation of table `{{%felhasznaloi_jogok}}`.
 */
class m250418_141559_create_felhasznaloi_jogok_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%felhasznaloi_jogok}}', [
            'id'               => $this->primaryKey(),
            'jogosultsag_neve' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%felhasznaloi_jogok}}');
    }
}
