<?php
/***
 * @var View $this
 */

use app\helpers\ColumnsHelper;
use app\helpers\HtmlHelper;
use yii\web\JqueryAsset;
use yii\web\View;

$this->registerJsFile('@web/webpack/idoszakok.js', ['depends' => [JqueryAsset::class]]);
$this->registerJsVar("idoszakokColumns", ColumnsHelper::idoszakokColumns());

?>

<div class="card main-card">
    <div class="card-header">
        <div class="card-title">
            Időszakok
        </div>
        <div>
            <?= HtmlHelper::hozzaadasBtn("Időszak létrehozása", "create-idoszak-btn") ?>
        </div>
    </div>
    <div class="card-body">
        <div id="idoszakok-grid" class="border-0"></div>
    </div>
</div>

