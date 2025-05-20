<?php

use yii\db\Migration;

class m250418_141843_insert_base_felhasznalok extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%felhasznaloi_jogok}}', [
            'jogosultsag_neve' => 'Szuperadmin'
        ]);

        $insertId = Yii::$app->db->lastInsertID;

        $this->insert('{{%felhasznalok}}', [
            'felhasznaloi_nev' => 'Vince',
            'email'            => 'gvgabor@gmail.com',
            'jelszo'           => Yii::$app->security->generatePasswordHash('alma'),
            'felhasznaloi_jog' => $insertId,
        ]);
        $this->insert('{{%felhasznalok}}', [
            'felhasznaloi_nev' => 'GPadmin',
            'email'            => 'gpadmin@gmail.com',
            'jelszo'           => Yii::$app->security->generatePasswordHash('alma'),
            'felhasznaloi_jog' => $insertId,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%felhasznaloi_jogok}}', [
            'jogosultsag_neve' => 'Szuperadmin'
        ]);
        $this->delete('{{%felhasznalok}}', [
            'felhasznaloi_nev' => 'Vince'
        ]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250418_141843_insert_base_felhasznalok cannot be reverted.\n";

        return false;
    }
    */
}
