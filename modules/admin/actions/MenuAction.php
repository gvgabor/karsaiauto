<?php

namespace app\modules\admin\actions;

use app\components\MainAction;
use app\models\base\FelhasznaloiJogokMenu;
use app\models\base\Menu;
use Throwable;
use Yii;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class MenuAction extends MainAction
{
    public ?int $felhasznaloiJogId = null;

    public function runWithParams($params)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $query                      = Menu::find()->orderBy(["{{%_menu}}.sorrend" => SORT_ASC]);

        if ($this->felhasznaloiJogId) {
            $menuIdList = FelhasznaloiJogokMenu::find()->menuIdList($this->felhasznaloiJogId);
            $query->andWhere(["id" => $menuIdList]);
        }

        return [
            "total" => $query->count(),
            "data"  => $query->all(),
        ];
    }

    public function save($formData)
    {

        $result = [];
        $model  = empty($formData["id"]) ? new Menu() : Menu::findOne($formData["id"]);

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $model->setAttributes($formData);
            $model->save() ?: throw new BadRequestHttpException(Json::encode($model->errors));
            $result["success"] = true;
            $result["model"]   = $model;
            $transaction->commit();
        } catch (Throwable $exception) {
            Yii::$app->response->statusCode = 400;
            $transaction->rollBack();
            $result["success"] = false;
            $result["errors"]  = $model->errors;
            $result["message"] = $exception->getMessage();
        }

        return $result;

    }

}
