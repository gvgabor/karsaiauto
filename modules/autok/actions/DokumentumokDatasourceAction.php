<?php

namespace app\modules\autok\actions;

use app\components\MainAction;
use app\models\base\AutokDokumentumok;
use Yii;
use yii\web\Response;

class DokumentumokDatasourceAction extends MainAction
{
    public ?string $autokId = null;

    public function runWithParams($params)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $query = AutokDokumentumok::find()->andWhere(["autok_id" => $this->autokId]);

        return [
            "total" => $query->count(),
            "data"  => $query->all()
        ];
    }

}
