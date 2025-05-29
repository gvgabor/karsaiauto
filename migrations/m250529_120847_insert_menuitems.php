<?php

class m250529_120847_insert_menuitems extends \app\components\Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert(
            '{{%_menu}}',
            [
                'menu_name' => 'Felszereltség',
                'menu_url'  => 'karbantartas/feltszereltseg',
                'parent_id' => 79,
                'sorrend'   => 10,
            ],
        );
        $this->insert(
            '{{%_menu}}',
            [
                'menu_name' => 'Kivitel',
                'menu_url'  => 'karbantartas/kivitel',
                'parent_id' => 79,
                'sorrend'   => 10,
            ],
        );
        $this->insert(
            '{{%_menu}}',
            [
                'menu_name' => 'Szinek',
                'menu_url'  => 'karbantartas/szinek',
                'parent_id' => 79,
                'sorrend'   => 10,
            ],
        );
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
        echo "m250529_120847_insert_menuitems cannot be reverted.\n";

        return false;
    }
    */
}
