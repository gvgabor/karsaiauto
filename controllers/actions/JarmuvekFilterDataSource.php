<?php

namespace app\controllers\actions;

use app\components\MainAction;
use app\helpers\UtilHelper;
use app\models\base\Arvalaszto;
use app\models\base\Idoszakok;
use app\models\index\FilterModel;
use app\modules\autok\models\AutokModel;
use Yii;
use yii\web\Response;

class JarmuvekFilterDataSource extends MainAction
{
    public function runWithParams($params)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $result                     = [];

        $filterModel = UtilHelper::filterModel();
        $query       = $this->createQuery($filterModel);

        $result["total"] = (clone $query)->count();
        $result["data"]  = $query->all();

        return $result;
    }

    public function createQuery(FilterModel $filterModel, $admin = false)
    {
        $query = AutokModel::find()
            ->with(['autokImage','autokDokumentumok'])
            ->joinWith(["marka"])
            ->limit($this->pageSize)
            ->orderBy(["id" => SORT_DESC])
            ->offset(($this->page - 1) * $this->pageSize);

        if ($admin === false) {
            $query->andWhere(["eladva" => 0, "publikalva" => 1]);
        }

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

        if ($filterModel->szin) {
            $query->andFilterWhere(['szinek_id' => $filterModel->szin]);
        }

        if ($filterModel->kivitel) {
            $query->andFilterWhere(['kivitel_id' => $filterModel->kivitel]);
        }

        if ($filterModel->ajtokszama) {
            $parts = explode("-", $filterModel->ajtokszama);
            if (count($parts) === 2) {
                $query->andFilterWhere(["between", "ajtok_szam", $parts[0], $parts[1]]);
            } else {
                $query->andFilterWhere([">=", "ajtok_szam", str_replace("+", "", $parts[0])]);
            }
        }

        if ($filterModel->szallithatoSzemelyek) {
            $parts = explode("-", $filterModel->szallithatoSzemelyek);
            if (count($parts) === 2) {
                $query->andFilterWhere(["between", "szallithato_szemelyek", $parts[0], $parts[1]]);
            } else {
                $query->andFilterWhere([">=", "szallithato_szemelyek", str_replace("+", "", $parts[0])]);
            }
        }

        if ($filterModel->sajatTomeg) {
            $parts = explode("-", $filterModel->sajatTomeg);
            if (count($parts) === 2) {
                $query->andFilterWhere(["between", "sajat_tomeg", $parts[0], $parts[1]]);
            } else {
                $query->andFilterWhere([">=", "sajat_tomeg", str_replace("+", "", $parts[0])]);
            }
        }

        if ($filterModel->ossztomeg) {
            $parts = explode("-", $filterModel->ossztomeg);
            if (count($parts) === 2) {
                $query->andFilterWhere(["between", "ossztomeg", $parts[0], $parts[1]]);
            } else {
                $query->andFilterWhere([">=", "ossztomeg", str_replace("+", "", $parts[0])]);
            }
        }

        if ($filterModel->terhelhetoseg) {
            $parts = explode("-", $filterModel->terhelhetoseg);
            if (count($parts) === 2) {
                $query->andFilterWhere(["between", "terhelhetoseg", $parts[0], $parts[1]]);
            } else {
                $query->andFilterWhere([">=", "terhelhetoseg", str_replace("+", "", $parts[0])]);
            }
        }

        if ($filterModel->tengelytav) {
            $parts = explode("-", $filterModel->tengelytav);
            if (count($parts) === 2) {
                $query->andFilterWhere(["between", "tengelytav", $parts[0], $parts[1]]);
            } else {
                $query->andFilterWhere([">=", "tengelytav", str_replace("+", "", $parts[0])]);
            }
        }

        if ($filterModel->hosszusag) {
            $parts = explode("-", $filterModel->hosszusag);
            if (count($parts) === 2) {
                $query->andFilterWhere(["between", "hosszusag", $parts[0], $parts[1]]);
            } else {
                $query->andFilterWhere([">=", "hosszusag", str_replace("+", "", $parts[0])]);
            }
        }

        if ($filterModel->szelesseg) {
            $parts = explode("-", $filterModel->szelesseg);
            if (count($parts) === 2) {
                $query->andFilterWhere(["between", "szelesseg", $parts[0], $parts[1]]);
            } else {
                $query->andFilterWhere([">=", "szelesseg", str_replace("+", "", $parts[0])]);
            }
        }

        if ($filterModel->hengerurtartalom) {
            $parts = explode("-", $filterModel->hengerurtartalom);
            if (count($parts) === 2) {
                $query->andFilterWhere(["between", "hengerurtartalom", $parts[0], $parts[1]]);
            } else {
                $query->andFilterWhere([">=", "hengerurtartalom", str_replace("+", "", $parts[0])]);
            }
        }

        if ($filterModel->hengerek_szama) {
            $query->andFilterWhere(["=", "hengerek_szama", $filterModel->hengerek_szama]);
        }

        if (!empty($filterModel->sorbarendezes)) {
            $query->orderBy($filterModel->sorbarendezes);
        }

        return $query;
    }

}
