<?php
/***
 * @var View $this
 * @var Idoszakok $model
 * @var MainForm $form
 *
 */

use app\components\MainForm;
use app\models\base\Idoszakok;
use yii\web\View;

?>

<div class="card">
    <div class="card-header">
        <div class="card-title">
            Időszakok létrehozása/szerkesztése
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
        <?= $form->field($model, "idoszak_megnevezes") ?>
        <?php MainForm::end() ?>
    </div>
    <div class="card-footer">
        <button class="btn btn-danger save-btn">
            <i class="fa fa-sign-in-alt"></i>&nbsp;<?= Yii::t("app", "save") ?>
        </button>
    </div>
</div>


