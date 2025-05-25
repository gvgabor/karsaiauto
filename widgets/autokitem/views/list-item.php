<?php
/***
 * @var View $this
 * @var LandingAutok $model
 */

use app\models\index\LandingAutok;
use yii\web\View;

if (empty($model)) {
    $model = new LandingAutok();
}


?>

<div class="card h-100 border-1 autok-list-item">
    <div class="image-box">
        <img
                src="<?= $model->firstImage[0]->imageUrl ?>" class="card-img-top"
                alt="<?= $model->firstImage[0]->name ?>"
        >
        <div class="layer">
            <span>Kattintson a részletekért</span>
            <i class="fa-solid fa-up-right-from-square"></i>
        </div>
    </div>
    <div class="card-body d-flex flex-column">
        <h5 class="card-title"><?= $model->marka?->name ?> <?= $model->model ?></h5>
        <p class="card-text mb-4"><?= $model->gyartasi_ev ?>, <?= $model->formatKilometer ?> km, <?= $model->motortipus ?></p>
        <div class="mt-auto">
            <span class="h5 text-primary"><?= $model->formatVetelar ?> Ft</span>
        </div>
    </div>

</div>
