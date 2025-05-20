<?php

namespace app\modules\admin\actions;

use app\components\MainAction;
use app\models\base\FelhasznaloiJogok;
use app\models\base\FelhasznaloiJogokMenu;
use app\models\base\Felhasznalok;
use Throwable;
use Yii;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class FelhasznaloiJogokAction extends MainAction
{

    public function runWithParams($params)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $query = FelhasznaloiJogok::find()->orderBy(["{{%felhasznaloi_jogok}}.id" => SORT_DESC]);

        return [
            "total" => $query->count(),
            "data"  => $query->all(),
        ];
    }

    public function hozzarendeles($felhasznaloiJogId, $menuIdList)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $result = [];
        $transaction = Yii::$app->db->beginTransaction();
        try {
            FelhasznaloiJogokMenu::updateAll(["deleted" => 1], ["felhasznaloi_jogok_id" => $felhasznaloiJogId]);

            foreach ($menuIdList as $id) {
                $model = new FelhasznaloiJogokMenu([
                    "menu_id"               => $id,
                    "felhasznaloi_jogok_id" => $felhasznaloiJogId
                ]);
                $model->save() ?: throw new BadRequestHttpException(Json::encode($model->errors));
            }

            $result["success"] = true;
            $transaction->commit();
        } catch (Throwable $exception) {
            Yii::$app->response->statusCode = 400;
            $result["success"] = false;
            $result["message"] = $exception->getMessage();
            $transaction->rollBack();
        }
        return $result;
    }

    public function save($formData)
    {
        $result = [];
        $model = empty($formData["id"]) ? new FelhasznaloiJogok() : FelhasznaloiJogok::findOne($formData["id"]);
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model->setAttributes($formData);
            $szerepkor = $model->isNewRecord ? Inflector::slug($model->jogosultsag_neve, "_") : Inflector::slug($model->oldAttributes["jogosultsag_neve"], "_");
            $model->save() ?: throw new BadRequestHttpException(Json::encode($model->errors));
            $auth = Yii::$app->authManager;

            $role = $auth->getRole($szerepkor);

            if ($role) {
                $role->name = Inflector::slug($model->jogosultsag_neve, "_");
                $role->description = $model->jogosultsag_neve;
                $auth->update($szerepkor, $role);
            } else {
                $role = $auth->createRole($szerepkor);
                $role->description = $model->jogosultsag_neve;
                $auth->add($role);
            }

            $result["success"] = true;
            $result["model"] = $model;
            $transaction->commit();
        } catch (Throwable $exception) {
            Yii::$app->response->statusCode = 400;
            $result["success"] = false;
            $result["message"] = $exception->getMessage();
            $result["errors"] = $model->errors;
            $transaction->rollBack();
        }

        return $result;
    }

}