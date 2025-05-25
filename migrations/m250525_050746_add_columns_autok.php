<?php

class m250525_050746_add_columns_autok extends \app\components\Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%autok}}', 'akcios_ar', $this->integer());
        $this->addColumn('{{%autok}}', 'eladas_datuma', $this->date());
        $this->addColumn('{{%autok}}', 'eladas_megjegyzes', $this->text());
        $this->addColumn('{{%autok}}', 'eladas_ugyfel_id', $this->integer());

        $this->createIndex('eladas_ugyfel_id', '{{%autok}}', 'eladas_ugyfel_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('eladas_ugyfel_id', '{{%autok}}');
        $this->dropColumn('{{%autok}}', 'akcios_ar');
        $this->dropColumn('{{%autok}}', 'eladas_datuma');
        $this->dropColumn('{{%autok}}', 'eladas_megjegyzes');
        $this->dropColumn('{{%autok}}', 'eladas_ugyfel_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250525_050746_add_columns_autok cannot be reverted.\n";

        return false;
    }
    */
}
