<?php
/***
 * @var View $this
 * @var MainForm $form
 * @var EladasModel $model
 */

use app\components\MainForm;
use app\modules\autok\models\EladasModel;
use yii\web\View;

?>

<div class="card">
    <div class="card-header">
        <div class="card-title">
            <?= Yii::t("app", "Auto Eladasa", ["auto" => $model->hirdetes_cime]) ?>
        </div>
        <div class="close-box">
            <i class="fa fa-times-circle fa-2x"></i>
        </div>
    </div>
    <div class="card-body">
        <?php $form = MainForm::begin([
            'options' => [
                'data-confirm' => htmlspecialchars(Yii::t('app', 'Eladas Megerositese', [
                        'auto' => $model->hirdetes_cime
                ]))
            ]
        ]) ?>
        <div style="display: none">
            <?= $form->field($model, "id") ?>
        </div>

        <?= $form->field($model, "eladas_datuma") ?>
        <?= $form->field($model, "eladas_megjegyzes")->textarea() ?>
        <div class="hozzad-row">
            <?= $form->field($model, "eladas_ugyfel_id")->dropDownList([], [
                "prompt"         => Yii::t("app", "Please Select"),
                "data-ugyfel-id" => $model->eladas_ugyfel_id,
            ]) ?>
            <?php MainForm::end() ?>
            <button id="ugyfel-letrehozasa-btn" class="btn btn-primary">
                <i class="fa-solid fa-square-plus"></i>
            </button>
        </div>

    </div>
    <div class="card-footer">
        <button class="btn btn-danger save-btn">
            <i class="fa fa-sign-in-alt"></i>&nbsp;<?= Yii::t("app", "save") ?>
        </button>
    </div>
</div>


