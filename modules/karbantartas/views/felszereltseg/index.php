<?php
/***
 * @var View $this
 */

use app\helpers\ColumnsHelper;
use app\helpers\HtmlHelper;
use yii\web\JqueryAsset;
use yii\web\View;

$this->registerJsVar("gridColumns", ColumnsHelper::baseColumns());
$this->registerJsFile('@web/webpack/felszereltseg.js', ['depends' => [JqueryAsset::class]]);


?>

<div class="card main-card">
    <div class="card-header">
        <div class="card-title">
            <?= Yii::t("app", "Feltszereltsegek") ?>
        </div>
        <div>
            <?= HtmlHelper::hozzaadasBtn(Yii::t("app", "Felszereltseg Letrehozasa"), "create-btn") ?>
        </div>
    </div>
    <div class="card-body">
        <div id="grid" class="border-0"></div>
    </div>
</div>



