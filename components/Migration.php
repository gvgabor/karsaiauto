<?php

namespace app\components;

use yii\db\Migration as BaseMigration;

class Migration extends BaseMigration
{
    public function createTable($table, $columns, $options = null)
    {
        $this->addBaseColumns($columns);
        parent::createTable($table, $columns, $options);
    }

    protected function addBaseColumns(&$columns)
    {
        $defaults = [
            'deleted'    => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'active'     => $this->tinyInteger(1)->notNull()->defaultValue(1),
            'created_at' => $this->dateTime()->null(),
            'updated_at' => $this->dateTime()->null(),
            'updated_by' => $this->integer()->null(),
            'create_by'  => $this->integer()->null(),
        ];

        foreach ($defaults as $name => $definition) {
            if (!isset($columns[$name])) {
                $columns[$name] = $definition;
            }
        }
    }
}
