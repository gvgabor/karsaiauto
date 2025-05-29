<?php
/***
 * @var View $this
 * @var LandingAutok $model
 */

use app\models\index\LandingAutok;
use yii\web\View;

?>


<div class="card shadow-lg detail-box">
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
                <span class="text-muted small">
                    <?= $model->marka->name ?> <?= $model->model ?>
                </span>
            </h4>

            <div class="adatok-grid-box">
                <div>
                    <i class="fas fa-calendar-alt"></i>
                    <span>Évjárat:</span>
                    <span><?= $model->gyartasi_ev ?></span>
                </div>
                <div>
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Kilométer:</span>
                    <span><?= $model->formatKilometer ?> km</span>
                </div>
                <div>
                    <i class="fas fa-oil-can"></i>
                    <span>Motor:</span>
                    <span><?= $model->motortipus ?></span>
                </div>
                <div>
                    <i class="fas fa-cogs"></i>
                    <span>Váltó:</span>
                    <span><?= $model->valto ?></span>
                </div>
                <div>
                    <i class="fas fa-wrench"></i>
                    <span>Müszaki érvényes:</span>
                    <span><?= $model->muszaki_ervenyes ?></span>
                </div>
                <div>
                    <i class="fas fa-bolt"></i>
                    <span>Teljesítmény:</span>
                    <span><?= $model->tejlesitmenyText ?></span>
                </div>
            </div>


            <!--            <h4 class="mb-3 mt-3">-->
            <!--               Letölthető dokumentumok-->
            <!--            </h4>-->
            <!---->
            <!--            <div class="adatok-grid-box">-->
            <!--                <div>-->
            <!--                    <i class="fas fa-wrench me-2 text-muted"></i>-->
            <!--                    <span>Műszaki</span>-->
            <!--                </div>-->
            <!--                <div>-->
            <!--                    <i class="fas fa-book-medical me-2 text-muted"></i>-->
            <!--                    <span>Szervízkönyv</span>-->
            <!--                </div>-->
            <!--                <div>-->
            <!--                    <i class="fas fa-id-badge me-2 text-muted"></i>-->
            <!--                    <span>Eredetiség vizsgálat</span>-->
            <!--                </div>-->
            <!--                <div>-->
            <!--                    <i class="fas fa-leaf me-2 text-muted"></i>-->
            <!--                    <span>Zöldkönyv</span>-->
            <!--                </div>-->
            <!--            </div>-->

            <div class="leiras-box">
                <?= $model->hirdetesLeirasa ?>
            </div>


            <div class="erdeklodo-box">
                <div>
                    <i class="fa-solid fa-phone"></i>
                    <a href="tel:+36301234567" class="btn btn-primary rounded-0">Telefonálok</a>
                </div>
                <div>
                    <i class="fa-solid fa-envelope-open-text"></i>
                    <a href="tel:+36301234567" class="btn btn-primary rounded-0">E-mail-t irok</a>
                </div>
                <div>
                    <i class="fa-solid fa-car"></i>
                    <a href="tel:+36301234567" class="btn btn-primary rounded-0">Megnézem személyesen</a>
                </div>
            </div>


        </div>

    </div>
</div>


