<?php

/**
 * Handles the creation of table `{{%ugyfelek}}`.
 */
class m250523_053950_create_ugyfelek_table extends \app\components\Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ugyfelek}}', [
            'id'              => $this->primaryKey(),
            'nev'             => $this->string(),
            'email'           => $this->string(),
            'telefon'         => $this->string(),
            'lakcim'          => $this->string(),
            'cegnev'          => $this->string(),
            'adoszam'         => $this->string(),
            'szuletesi_datum' => $this->date(),
            'szemelyi_szam'   => $this->string(),
            'tipus'           => $this->tinyInteger()->defaultValue(1)->comment('1 magánszemély 2 cég'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%ugyfelek}}');
    }
}
