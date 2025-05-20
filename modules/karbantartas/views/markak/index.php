<?php
/***
 * @var View $this
 */

use app\helpers\ColumnsHelper;
use app\helpers\HtmlHelper;
use yii\web\JqueryAsset;
use yii\web\View;

$this->registerJsFile('@web/webpack/markak.js', ['depends' => [JqueryAsset::class]]);
$this->registerJsVar("markakColumns", ColumnsHelper::markakColumns());

?>

<div class="card main-card">
    <div class="card-header">
        <div class="card-title"> Márkák</div>
        <div>
            <?= HtmlHelper::hozzaadasBtn("Márka létrehozása", "create-marka-btn") ?>
        </div>
    </div>
    <div class="card-body">
        <div id="markak-grid" class="border-0"></div>
    </div>
</div>


