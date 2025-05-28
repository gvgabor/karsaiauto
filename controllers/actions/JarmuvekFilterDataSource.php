<?php

namespace app\controllers\actions;

use app\components\MainAction;
use app\helpers\UtilHelper;
use app\models\base\Arvalaszto;
use app\models\base\Idoszakok;
use app\models\index\LandingAutok;
use Yii;
use yii\web\Response;

class JarmuvekFilterDataSource extends MainAction
{
    public function runWithParams($params)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $result                     = [];

        $filterModel = UtilHelper::filterModel();
        $query       = LandingAutok::find()
            ->joinWith(["marka"])
            ->andWhere(["eladva" => 0, "publikalva" => 1])
            ->limit($this->pageSize)
            ->offset(($this->page - 1) * $this->pageSize);

        foreach ($filterModel->attributes as $key => $item) {
            if (!empty($item)) {
                match ($key) {
                    "marka"      => $query->andFilterWhere(["=", "marka_id", $filterModel->$key]),
                    "motortipus" => $query->andFilterWhere(["=", "motortipus_id", $filterModel->$key]),
                    "valto"      => $query->andFilterWhere(["=", "valto_id", $filterModel->$key]),
                    default      => null
                };
            }

        }

        if (!empty($filterModel->teljesitmeny)) {
            $parts = explode("-", $filterModel->teljesitmeny);
            if (count($parts) === 2) {
                $query->andFilterWhere(["between", "teljesitmeny", $parts[0], $parts[1]]);
            } else {
                $parts[0] = str_replace("+", "", $parts[0]);
                $query->andFilterWhere([">=", "teljesitmeny", $parts[0]]);
            }
        }

        if (!empty($filterModel->kilometer)) {
            $parts = explode("-", $filterModel->kilometer);

            if (count($parts) === 2) {
                $parts = array_map(fn ($item) => $item * 1000, $parts);
                $query->andFilterWhere(["between", "kilometer", $parts[0], $parts[1]]);
            } else {
                $parts[0] = str_replace("+", "", $parts[0]);
                $query->andFilterWhere([">=", "kilometer", $parts[0] * 1000]);
            }
        }

        if (!empty($filterModel->evjarat)) {
            $idoszakok = Idoszakok::findOne($filterModel->evjarat);
            $parts     = explode("-", $idoszakok->idoszak_megnevezes);
            if (count($parts) === 2) {
                $query->andFilterWhere(["between", "gyartasi_ev", $parts[0], $parts[1]]);
            } else {
                $parts[0] = str_replace("+", "", $parts[0]);
                $query->andFilterWhere(["between", "gyartasi_ev", $parts[0], date("Y")]);
            }
        }

        if (!empty($filterModel->vetelar)) {
            $arvalaszto = Arvalaszto::findOne($filterModel->vetelar);
            if ($arvalaszto->veg_osszeg) {
                $query->andFilterWhere(["between", "vetelar", $arvalaszto->kezdo_osszeg, $arvalaszto->veg_osszeg]);
            } else {
                $query->andFilterWhere([">=", "vetelar", $arvalaszto->kezdo_osszeg]);
            }

        }

        if (!empty($filterModel->sorbarendezes)) {
            $query->orderBy($filterModel->sorbarendezes);
        }

        $result["total"] = $query->count();
        $result["data"]  = $query->all();

        return $result;
    }

}
