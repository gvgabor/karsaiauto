<?php
/***
 * @var View $this
 * @var MainForm $form
 * @var Ugyfelek $model
 */

use app\components\enums\UgyfelTipus;
use app\components\MainForm;
use app\models\base\Ugyfelek;
use yii\web\View;

?>

<div class="card">
    <div class="card-header">
        <div class="card-title">
            <?= Yii::t("app", "Ugyfelek Kezelese") ?>
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
        <?= $form->field($model, "nev") ?>
        <?= $form->field($model, "lakcim") ?>
        <?= $form->field($model, "tipus")->dropDownList(UgyfelTipus::list(), [
            "prompt" => Yii::t("app", "Please Select")
        ]) ?>

        <div class="grid-col-2">
            <?= $form->field($model, "email") ?>
            <?= $form->field($model, "telefon") ?>
        </div>

        <div class="grid-col-2" id="ceg-data">
            <?= $form->field($model, "cegnev") ?>
            <?= $form->field($model, "adoszam") ?>
        </div>


        <div class="grid-col-2" id="magan-data">
            <?= $form->field($model, "szuletesi_datum") ?>
            <?= $form->field($model, "szemelyi_szam") ?>
        </div>


        <?php MainForm::end() ?>
    </div>
    <div class="card-footer">
        <button class="btn btn-danger save-btn">
            <i class="fa fa-sign-in-alt"></i>&nbsp;<?= Yii::t("app", "save") ?>
        </button>
    </div>
</div>


