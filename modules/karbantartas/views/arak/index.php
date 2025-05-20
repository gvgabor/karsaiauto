<?php
/***
 * @var View $this
 */

use app\helpers\ColumnsHelper;
use app\helpers\HtmlHelper;
use yii\web\JqueryAsset;
use yii\web\View;

$this->registerJsFile("@web/webpack/arak.js", ["depends" => JqueryAsset::class]);
$this->registerJsVar("arvalasztoColumns", ColumnsHelper::arvalasztoColumns());

?>

<div class="card main-card">
    <div class="card-header">
        <div class="card-title"> Ár-választó</div>
        <div>
            <?= HtmlHelper::hozzaadasBtn("Árválasztó létrehozása", "create-arvalaszto-btn") ?>
        </div>
    </div>
    <div class="card-body">
        <div id="arvalaszto-grid" class="border-0"></div>
    </div>
</div>


