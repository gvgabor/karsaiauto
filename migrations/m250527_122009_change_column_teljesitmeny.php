<?php

use yii\db\Migration;

class m250527_122009_change_column_teljesitmeny extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%autok}}', 'teljesitmeny');
        $this->addColumn('{{%autok}}', 'teljesitmeny', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250527_122009_change_column_teljesitmeny cannot be reverted.\n";

        return false;
    }
    */
}
