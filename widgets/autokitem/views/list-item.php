<?php
/***
 * @var View $this
 * @var LandingAutok $model
 */

use app\helpers\HtmlHelper;
use app\models\index\LandingAutok;
use yii\web\View;

if (empty($model)) {
    $model = new LandingAutok();
}

?>

<div class="card h-100 border-1 autok-list-item">
    <div class="image-box">
        <img
                src="<?= $model->firstImage?->imageUrl ?>" class="card-img-top"
                alt="<?= $model->firstImage?->name ?>"
        >
        <div class="layer">
            <span>Kattintson a részletekért</span>
            <i class="fa-solid fa-up-right-from-square"></i>
        </div>
    </div>
    <div class="card-body d-flex flex-column">
        <h5 class="card-title d-flex justify-content-between">
            <span><?= $model->marka?->name ?> <?= $model->model ?></span>
            <span class="text-muted"><?= $model->azonosito ?></span>
        </h5>
        <div class="card-text text-muted small mb-3 detail">
            <div><strong>Évjárat:</strong> <?= $model->gyartasi_ev ?></div>
            <div><strong>Futott km:</strong> <?= $model->formatKilometer ?> km</div>
            <div><strong>Motor:</strong> <?= $model->motortipus ?></div>
            <div><strong>Váltó:</strong> <?= $model->valto ?></div>
            <div><strong>Teljesítmény:</strong> <?= $model->tejlesitmenyText ?></div>
        </div>


        <?= HtmlHelper::vetelarBox($model) ?>
    </div>

</div>


