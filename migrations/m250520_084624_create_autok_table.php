<?php

/**
 * Handles the creation of table `{{%autok}}`.
 */
class m250520_084624_create_autok_table extends \app\components\Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%autok}}', [
            'id'               => $this->primaryKey(),
            'jarmutipus_id'    => $this->integer(),
            'marka_id'         => $this->integer(),
            'model'            => $this->string(),
            'gyartasi_ev'      => $this->integer(),
            'kilometer'        => $this->integer(),
            'vetelar'          => $this->integer(),
            'hirdetes_cime'    => $this->string(),
            'hirdetes_leirasa' => $this->text(),
            'motortipus_id'    => $this->integer(),
            'teljesitmeny'     => $this->string(),
            'valto_id'         => $this->integer(),
            'muszaki_ervenyes' => $this->string(),
        ]);

        $this->createIndex('jarmutipus_id', '{{%autok}}', 'jarmutipus_id');
        $this->createIndex('marka_id', '{{%autok}}', 'marka_id');
        $this->createIndex('vetelar', '{{%autok}}', 'vetelar');
        $this->createIndex('gyartasi_ev', '{{%autok}}', 'gyartasi_ev');
        $this->createIndex('kilometer', '{{%autok}}', 'kilometer');
        $this->createIndex('motortipus_id', '{{%autok}}', 'motortipus_id');
        $this->createIndex('valto_id', '{{%autok}}', 'valto_id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%autok}}');
    }
}
