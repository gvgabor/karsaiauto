<?php

namespace app\modules\admin\actions;

use app\components\MainAction;
use app\models\base\Felhasznalok;
use Throwable;
use Yii;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class FelhasznalokAction extends MainAction
{
    public function runWithParams($params)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $query                      = Felhasznalok::find()->orderById();
        return [
            "total" => $query->count(),
            "data"  => $query->all(),
        ];
    }

    public function jelszo($formData)
    {
        $result = [];

        if (empty($formData["id"])) {
            Yii::$app->response->statusCode = 400;
            throw new BadRequestHttpException("id nem található!");
        }

        $model = Felhasznalok::findOne($formData['id']);
        if (empty($model)) {
            Yii::$app->response->statusCode = 400;
            throw new BadRequestHttpException("felhasználó nem található!");
        }

        $model->scenario = Felhasznalok::SCENARIO_JELSZO;

        try {
            $model->setAttributes($formData);
            $model->validate() ?: throw new BadRequestHttpException(Json::encode($model->errors));
            $model->jelszo = Yii::$app->security->generatePasswordHash($model->jelszo1);
            $model->save() ?: throw new BadRequestHttpException(Json::encode($model->errors));
            $result["success"] = true;
        } catch (Throwable $exception) {
            $result["success"] = false;
            $this->errorStatus();
            $result["errors"]  = $model->errors;
            $result["message"] = $exception->getMessage();
        }

        return $result;
    }

    /**
     * Saves a user record by creating a new one or updating an existing one, based on the provided data.
     *
     * @param array $formData The data used to create or update a user record. Should include relevant attributes.
     * @return array Returns an associative array containing the success status, model data if successful, or errors if any occur.
     *               - 'success': A boolean indicating whether the operation was successful.
     *               - 'model': The saved model object if the operation was successful.
     *               - 'errors': Validation errors in case the operation fails.
     *               The status code in the response will indicate success (201/202) or failure (400).
     */
    public function save($formData)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $result      = [];

        $model = empty($formData["id"]) ? new Felhasznalok() : Felhasznalok::findOne($formData["id"]);
        $this->baseStatus($model);

        try {
            $model->setAttributes($formData);
            $model->save() ?: throw new BadRequestHttpException(Json::encode($model->errors));

            $auth = Yii::$app->authManager;


            $role = $auth->getRole(Inflector::slug($model->felhasznaloiJogok->jogosultsag_neve, "_"));

            if ($role) {
                $auth->revokeAll($model->id);
                $auth->assign($role, $model->id);
            }

            $result["success"] = true;
            $result["model"]   = $model;
            $transaction->commit();
        } catch (Throwable $exception) {
            Yii::error($exception->getMessage());
            $transaction->rollBack();
            $result["errors"]  = $model->errors;
            $result["success"] = false;
            $this->errorStatus();
        }
        return $result;
    }

}
