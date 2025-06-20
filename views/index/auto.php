<?php
/***
 * @var View $this
 * @var LandingAutok $model
 */

use app\models\index\LandingAutok;
use yii\helpers\Url;
use yii\web\JqueryAsset;
use yii\web\View;

$this->registerJsVar("autoId", $model->id);
$this->registerJsFile("@web/webpack/auto.js", ['depends' => JqueryAsset::class]);
?>


<section class="">
    <div class="container pt-3 pb-3">
        <?= $this->render("auto-detail", ["model" => $model]) ?>
    </div>
</section>

<div class="jump-box">
    <div id="jump-home-btn" class="icon-box">
        <i class="fa-solid fa-house"></i>
    </div>
    <a class="icon-box" href="<?= Url::to(['/index/jarmuvek']) ?>">
        <i class="fa-solid fa-car-side"></i>
    </a>
</div>

