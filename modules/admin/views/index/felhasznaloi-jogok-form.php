<?php
/***
 * @var View $this
 * @var MainForm $form
 * @var FelhasznaloiJogok $model
 */

use app\components\MainForm;
use app\models\base\FelhasznaloiJogok;
use yii\web\View;

?>

<div class="card">
    <div class="card-header">
        <div class="card-title">
            Felhasználói jogok létrehozása/szerkesztése
        </div>
        <div class="close-box">
            <i class="fa fa-times-circle fa-2x"></i>
        </div>
    </div>
    <div class="card-body">
        <?PHP $form = MainForm::begin() ?>
        <div style="display: none">
            <?= $form->field($model, "id") ?>
        </div>

        <?= $form->field($model, "jogosultsag_neve") ?>
        <?PHP MainForm::end() ?>
    </div>
    <div class="card-footer">
        <button class="btn btn-danger save-btn">
            <i class="fa fa-sign-in-alt"></i>&nbsp;<?= Yii::t("app", "save") ?>
        </button>
    </div>
</div>


