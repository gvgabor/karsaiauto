<?php

use yii\db\Migration;

class m250601_040148_add_columns_autok extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%autok}}', 'friendly_url', $this->string());
        $this->createIndex('friendly_url', '{{%autok}}', 'friendly_url');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('friendly_url', '{{%autok}}');
        $this->dropColumn('{{%autok}}', 'friendly_url');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250601_040148_add_columns_autok cannot be reverted.\n";

        return false;
    }
    */
}
