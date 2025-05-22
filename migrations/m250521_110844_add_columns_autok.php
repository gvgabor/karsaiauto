<?php

class m250521_110844_add_columns_autok extends \app\components\Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%autok}}', 'publikalva', $this->tinyInteger()->defaultValue(0));
        $this->createIndex('publikalva', '{{%autok}}', 'publikalva');

        $this->addColumn('{{%autok}}', 'eladva', $this->tinyInteger()->defaultValue(0));
        $this->createIndex('eladva', '{{%autok}}', 'eladva');

        $this->addColumn('{{%autok}}', 'akcios', $this->tinyInteger()->defaultValue(0));
        $this->createIndex('akcios', '{{%autok}}', 'akcios');

        $this->addColumn('{{%autok}}', 'fooldalra', $this->tinyInteger()->defaultValue(0));
        $this->createIndex('fooldalra', '{{%autok}}', 'fooldalra');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('publikalva', '{{%autok}}');
        $this->dropColumn('{{%autok}}', 'publikalva');
        $this->dropIndex('eladva', '{{%autok}}');
        $this->dropColumn('{{%autok}}', 'eladva');
        $this->dropIndex('akcios', '{{%autok}}');
        $this->dropColumn('{{%autok}}', 'akcios');
        $this->dropIndex('fooldalra', '{{%autok}}');
        $this->dropColumn('{{%autok}}', 'fooldalra');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250521_110844_add_columns_autok cannot be reverted.\n";

        return false;
    }
    */
}
