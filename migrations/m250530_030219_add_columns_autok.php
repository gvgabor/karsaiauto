<?php

use yii\db\Migration;

class m250530_030219_add_columns_autok extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%autok}}', 'kivitel_id', $this->integer());
        $this->createIndex('kivitel_id', '{{%autok}}', 'kivitel_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('kivitel_id', '{{%autok}}');
        $this->dropColumn('{{%autok}}', 'kivitel_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250530_030219_add_columns_autok cannot be reverted.\n";

        return false;
    }
    */
}
