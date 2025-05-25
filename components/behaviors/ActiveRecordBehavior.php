<?php

namespace app\components\behaviors;

use DateTime;
use Exception;
use Yii;
use yii\base\Behavior;
use yii\db\BaseActiveRecord;

class ActiveRecordBehavior extends Behavior
{
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
        ];
    }

    public function beforeInsert($event)
    {
        $this->updateAuditFields($event->sender, true);
    }

    protected function updateAuditFields($sender, $isInsert)
    {
        try {
            $schema  = Yii::$app->db->getTableSchema($sender->tableName());
            $columns = $schema->columnNames;

            $now    = (new DateTime())->format('Y-m-d H:i:s');
            $userId = Yii::$app->user?->id;

            if ($isInsert) {
                if (in_array('create_by', $columns) && $userId !== null) {
                    $sender->create_by = $userId;
                }
                if (in_array('created_at', $columns)) {
                    $sender->created_at = $now;
                }
            }

            if (in_array('updated_at', $columns) && $userId !== null) {
                $sender->updated_at = $userId;
            }
            if (in_array('updated_at', $columns)) {
                $sender->updated_at = $now;
            }
        } catch (Exception $e) {
            Yii::error("Audit mezők frissítése sikertelen: " . $e->getMessage(), __METHOD__);
        }
    }

    public function beforeUpdate($event)
    {
        $this->updateAuditFields($event->sender, false);
    }
}
