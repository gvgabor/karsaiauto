<?php
/***
 * @var View $this
 */

use app\helpers\ColumnsHelper;
use app\helpers\HtmlHelper;
use yii\web\JqueryAsset;
use yii\web\View;

$this->registerJsVar("autokColumns", ColumnsHelper::autokColumns());
$this->registerJsFile('@web/webpack/autok.js', ['depends' => [JqueryAsset::class]]);


?>

<div class="card main-card">
    <div class="card-header">
        <div class="card-title">
            Autók kezelése
        </div>
        <div>
            <?= HtmlHelper::hozzaadasBtn("Autó létrehozása", "create-auto-btn") ?>
        </div>
    </div>
    <div class="card-body">
      <div id="autok-grid" class="border-0"></div>
    </div>
</div>


