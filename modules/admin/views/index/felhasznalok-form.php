<?php
/***
 * @var View $this
 * @var Felhasznalok $model
 * @var MainForm $form
 */

use app\components\MainForm;
use app\helpers\OptionsHelper;
use app\models\base\Felhasznalok;
use yii\web\View;

?>

<div class="card rounded-0">
    <div class="card-header">
        <div class="card-title">
            Felhasználók létrehozása/szerkesztése
        </div>
        <div class="close-box">
            <i class="fa fa-times-circle fa-2x"></i>
        </div>
    </div>
    <div class="card-body">
        <?PHP $form = MainForm::begin() ?>

        <div style="display:none;">
            <?= $form->field($model, 'id') ?>
        </div>

        <?= $form->field($model, 'felhasznaloi_nev') ?>
        <?= $form->field($model, 'felhasznaloi_jog')->dropDownList(OptionsHelper::felhasznaloiJogokOptions(), ["prompt" => Yii::t("app", "Please Select")]) ?>
        <?= $form->field($model, 'email') ?>
        <?PHP if ($model->isNewRecord): ?>
            <?= $form->field($model, 'jelszo') ?>
        <?PHP endif; ?>
        <?PHP MainForm::end() ?>
    </div>
    <div class="card-footer">
        <button class="btn btn-danger save-btn">
            <i class="fa fa-sign-in-alt"></i>&nbsp;<?= Yii::t("app", "save") ?>
        </button>
    </div>
</div>


