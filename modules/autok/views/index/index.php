<?php
/***
 * @var View $this
 */

use app\helpers\ColumnsHelper;
use app\helpers\HtmlHelper;
use yii\web\JqueryAsset;
use yii\web\View;

$this->registerJsVar("autokColumns", ColumnsHelper::autokColumns());
$this->registerJsVar("dokumentumokColumns", ColumnsHelper::dokumentumokColumns());
$this->registerJsFile('@web/webpack/autok.js', ['depends' => [JqueryAsset::class]]);

?>


<div class="card main-card">
    <div class="card-header">
        <div class="card-title">
            <?= Yii::t("app", "Autok Kezelese") ?>
        </div>
        <div class="d-inline-flex gap-2">
            <div id="grid-status-filter-selector" class="rounded-0">
                <span><?= Yii::t('app', 'Osszes') ?></span>
                <span><?= Yii::t('app', 'Fooldalra') ?></span>
                <span><?= Yii::t('app', 'Akcios') ?></span>
                <span><?= Yii::t('app', 'Publikalva') ?></span>
                <span><?= Yii::t('app', 'Nem Publikalva') ?></span>
            </div>
            <div id="grid-filter-selector" class="rounded-0">
                <span><?= Yii::t('app', 'Osszes') ?></span>
                <span><?= Yii::t('app', 'Eladott') ?></span>
                <span><?= Yii::t('app', 'Nem Eladott') ?></span>
            </div>
            <?= HtmlHelper::hozzaadasBtn("Autó létrehozása", "create-auto-btn") ?>
        </div>
    </div>
    <div class="card-body">
        <div
                data-igennem-filter="<?= HtmlHelper::igenNemFilters() ?>"
                id="autok-grid" class="border-0"></div>
    </div>
</div>


