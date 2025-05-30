<?php

use yii\db\Migration;

class m250530_025223_add_columns_autok extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%autok}}', 'szinek_id', $this->integer());
        $this->createIndex('szinek_id', '{{%autok}}', 'szinek_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('szinek_id', '{{%autok}}');
        $this->dropColumn('szinek_id', '{{%autok}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250530_025223_add_columns_autok cannot be reverted.\n";

        return false;
    }
    */
}
