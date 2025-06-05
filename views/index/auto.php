<?php
/***
 * @var View $this
 * @var LandingAutok $model
 */

use app\models\index\LandingAutok;
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

