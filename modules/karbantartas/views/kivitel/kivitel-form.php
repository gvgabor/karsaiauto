<?php
/***
 * @var View $this
 * @var MainForm $form
 * @var Kivitel $model
 */

use app\components\MainForm;
use app\models\base\Felszereltseg;
use app\models\base\Kivitel;
use yii\web\View;

?>

<div class="card">
    <div class="card-header">
        <div class="card-title">
            <?= Yii::t("app", "Kivitel Szerkesztese Letrehozasa") ?>
        </div>
        <div class="close-box">
            <i class="fa fa-times-circle fa-2x"></i>
        </div>
    </div>
    <div class="card-body">
        <?php $form = MainForm::begin() ?>
        <div style="display: none">
            <?= $form->field($model, "id") ?>
        </div>

        <?= $form->field($model, "name") ?>
        <?php MainForm::end() ?>
    </div>
    <div class="card-footer">
        <button class="btn btn-danger save-btn">
            <i class="fa fa-sign-in-alt"></i>&nbsp;<?= Yii::t("app", "save") ?>
        </button>
    </div>
</div>

