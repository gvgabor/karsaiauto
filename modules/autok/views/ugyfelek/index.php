<?php
/***
 * @var View $this
 */

use app\helpers\ColumnsHelper;
use app\helpers\HtmlHelper;
use yii\web\JqueryAsset;
use yii\web\View;

$this->registerJsVar("ugyfelekColumns", ColumnsHelper::ugyfelekColumns());
$this->registerJsFile('@web/webpack/ugyfelek.js', ['depends' => [JqueryAsset::class]]);

?>

<div class="card main-card">
    <div class="card-header">
        <div class="card-title">
            <?= Yii::t("app", "Ugyfelek Kezelese") ?>
        </div>
        <div>
            <?= HtmlHelper::hozzaadasBtn(Yii::t("app", "Ugyfel Letrehozasa"), "create-ugyfel-btn") ?>
        </div>
    </div>
    <div class="card-body">
        <div id="ugyfelek-grid" class="border-0"></div>
    </div>
</div>


