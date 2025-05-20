<?php
/***
 * @var View $this
 * @var MainForm $form
 * @var Arvalaszto $model
 */

use app\components\MainForm;
use app\models\base\Arvalaszto;
use yii\web\View;

?>

<div class="card">
    <div class="card-header">
        <div class="card-title">
            Árak létrehozása/szerkesztése
        </div>
        <div class="close-box">
            <i class="fa fa-times-circle fa-2x"></i>
        </div>
    </div>
    <div class="card-body">
        <?php $form = MainForm::begin() ?>
        <div style="display: none">

        </div>
        <?= $form->field($model, "id") ?>
        <?= $form->field($model, "megnevezes") ?>
        <?= $form->field($model, "kezdo_osszeg") ?>
        <?= $form->field($model, "veg_osszeg") ?>
        <?php MainForm::end() ?>
    </div>
    <div class="card-footer">
        <button class="btn btn-danger save-btn">
            <i class="fa fa-sign-in-alt"></i>&nbsp;<?= Yii::t("app", "save") ?>
        </button>
    </div>
</div>


