<?php

use yii\db\Migration;

class m250530_121656_add_autok_columns extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%autok}}', 'ajtok_szam', $this->integer());
        $this->addColumn('{{%autok}}', 'szallithato_szemelyek', $this->integer());
        $this->addColumn('{{%autok}}', 'sajat_tomeg', $this->integer());
        $this->addColumn('{{%autok}}', 'ossztomeg', $this->integer());
        $this->addColumn('{{%autok}}', 'terhelhetoseg', $this->integer());
        $this->addColumn('{{%autok}}', 'tengelytav', $this->integer());
        $this->addColumn('{{%autok}}', 'hosszusag', $this->integer());
        $this->addColumn('{{%autok}}', 'szelesseg', $this->integer());
        $this->addColumn('{{%autok}}', 'hengerek_szama', $this->integer());
        $this->addColumn('{{%autok}}', 'hengerurtartalom', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%autok}}', 'ajtok_szam');
        $this->dropColumn('{{%autok}}', 'szallithato_szemelyek');
        $this->dropColumn('{{%autok}}', 'sajat_tomeg');
        $this->dropColumn('{{%autok}}', 'ossztomeg');
        $this->dropColumn('{{%autok}}', 'terhelhetoseg');
        $this->dropColumn('{{%autok}}', 'tengelytav');
        $this->dropColumn('{{%autok}}', 'hosszusag');
        $this->dropColumn('{{%autok}}', 'szelesseg');
        $this->dropColumn('{{%autok}}', 'hengerek_szama');
        $this->dropColumn('{{%autok}}', 'hengerurtartalom');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250530_121656_add_autok_columns cannot be reverted.\n";

        return false;
    }
    */
}
