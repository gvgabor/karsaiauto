<?php
/***
 * @var View $this
 * @var LandingAutok $model
 */

use app\helpers\HtmlHelper;
use app\models\index\LandingAutok;
use yii\helpers\Url;
use yii\web\View;

?>


<div id="detail-box" class="card shadow-lg detail-box">
    <div class="card-body p-0">


        <!-- Kép slider -->
        <div class="simple-slider">
            <div class="slides">
                <?php foreach ($model->autokImage as $item): ?>
                    <div class="slide">
                        <img src="<?= $item->imageUrl ?>" class="img-fluid  w-100" alt="Autó kép 1">
                    </div>
                <?php endforeach; ?>
            </div>
            <button id="prev-btn" class="prev-btn">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
            <button id="next-btn" class="next-btn">
                <i class="fa-solid fa-arrow-right"></i>
            </button>
            <div class="close-box">
                <i class="fa-solid fa-xmark"></i>
            </div>
            <div id="counter-box" class="counter-box">1/1</div>
        </div>

        <div id="thumb-slider" class="thumb-slider">
            <?php foreach ($model->autokImage as $item): ?>
                <div class="thumb-slide">
                    <img src="<?= $item->imageUrl ?>" class="img-fluid  w-100" alt="Autó kép 1">
                </div>
            <?php endforeach; ?>
        </div>

        <div class="erdeklodo-box">
            <div>
                <i class="fa-solid fa-phone"></i>
                <span class="phone">06 30 261 70 50</span>
            </div>
            <div id="email-btn">
                <i class="fa-solid fa-envelope-open-text"></i>
                <span class="phone"><?= Yii::t("app", "Email Kuldok") ?></span>
            </div>
            <div>
                <i class="fab fa-facebook"></i>
                <a
                        href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(Url::to(['auto/view', 'id' => $model->id], true)) ?>"
                        target="_blank"
                        rel="noopener noreferrer"
                >
                    <span class="phone"> Megosztom a Facebookon</span>

                </a>
            </div>
        </div>

        <div class="bg-light vetelar-box">
            <h5 class="mb-0">Vételár</h5>
            <h5 class=" mb-0"><?= $model->formatVetelar ?> Ft</h5>
            <?php if (Yii::$app->request->get("admin") && $model->eladva == 0): ?>
                <div>
                    <button id="auto-edit-btn" class="btn btn-warning">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                </div>
            <?php endif ?>
        </div>

        <div class="adatok-box">
            <!-- Autó adatok -->
            <h4 class="mb-3">
                <?= $model->hirdetes_cime ?>
            </h4>

            <?= HtmlHelper::adatokBoxGrid($model) ?>

            <div class="leiras-box">
                <?= $model->hirdetesLeirasa ?>
            </div>

            <?= HtmlHelper::felszereltsegBox($model) ?>


        </div>

    </div>
    <div id="popup-slide-box" class="popup-slide-box">
        <div class="popup-slide-close-box">
            <div id="close-slide-box" class="d-flex justify-content-center align-items-center close-item-box">
                <i class="fa-solid fa-xmark "></i>
            </div>

        </div>
        <div id="popup-slide-content-box" class="popup-slide-content-box">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid deleniti error esse illum labore,
            laudantium magnam odit sunt velit! Distinctio ipsum iusto, nam nesciunt numquam quisquam repellendus saepe
            suscipit voluptatibus.
        </div>
    </div>
</div>


