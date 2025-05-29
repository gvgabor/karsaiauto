<?php

namespace app\components;

use Yii;
use yii\base\Action;
use yii\web\Application;
use yii\web\Request;

/**
 *
 * @property-read Request $request
 * @property array $filters
 * @property array $sort
 * @property-read array $adminColumns
 */
class MainAction extends Action
{
    public int $pageSize = 1;
    public int $page     = 1;

    protected array $_filters = [];
    protected array $_sort    = [];

    public function getRequest(): ?Request
    {
        return Yii::$app instanceof Application ? Yii::$app->request : null;
    }

    public function baseStatus(MainActiveRecord $model)
    {
        if (Yii::$app instanceof Application) {
            Yii::$app->response->statusCode = $model->isNewRecord ? 201 : 202;
        }

    }

    public function errorStatus()
    {
        if (Yii::$app instanceof Application) {
            Yii::$app->response->statusCode = 400;
        }

    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return $this->_filters;
    }

    /**
     * @param array $filters
     */
    public function setFilters($filters)
    {
        if (is_array($filters) === false) {
            $filters = [];
        }
        $filters        = array_key_exists("filters", $filters) === false ? [] : $filters["filters"];
        $this->_filters = $filters;
    }

    /**
     * @return array
     */
    public function getSort()
    {
        return $this->_sort;
    }

    /**
     * @param array $sort
     */
    public function setSort($sort)
    {
        if (is_array($sort) === false) {
            $sort = [];
        }
        //        $sort = array_key_exists("filters", $sort) === false ? [] : $sort["filters"];
        $this->_sort = $sort;
    }

}
