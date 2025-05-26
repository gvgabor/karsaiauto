<?php

use yii\db\Migration;

class m250524_054707_add_columns_autok_image extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%autok_image}}', 'remote_key', $this->string());
        $this->addColumn('{{%autok_image}}', 'url', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%autok_image}}', 'remote_key');
        $this->dropColumn('{{%autok_image}}', 'url');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250524_054707_add_columns_autok_image cannot be reverted.\n";

        return false;
    }
    */
}
