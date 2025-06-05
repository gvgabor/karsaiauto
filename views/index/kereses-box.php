<?php
/***
 * @var View $this
 * @var MainForm $form
 * @var FilterModel $model
 */

use app\components\MainForm;
use app\helpers\OptionsHelper;
use app\models\index\FilterModel;
use yii\web\View;

?>


<?php $form = MainForm::begin([
    "id"      => "filter-form",
    'options' => [
        'class' => 'filter-form-box'
    ]
]) ?>

<div class="kereses-box">
    <div class="hozzad-row">
        <?= $form->field($model, 'marka', ['options' => ['class' => 'filter-item']])->dropDownList(OptionsHelper::markakOptions(), [
            "prompt" => Yii::t('app', 'Marka ID')
        ])->label(false) ?>
        <button class="btn btn-primary remove-filter-btn">
            <i class="fa-solid fa-trash-can"></i>
        </button>
    </div>

    <div class="hozzad-row">
        <?= $form->field($model, 'evjarat', ['options' => ['class' => 'filter-item']])->dropDownList(OptionsHelper::evjaratOptions(), [
            "prompt" => Yii::t('app', 'Evjarat')
        ])->label(false) ?>
        <button class="btn btn-primary remove-filter-btn">
            <i class="fa-solid fa-trash-can"></i>
        </button>
    </div>


    <div class="hozzad-row">
        <?= $form->field($model, 'vetelar', ['options' => ['class' => 'filter-item']])->dropDownList(OptionsHelper::vetelarOptions(), [
            "prompt" => Yii::t('app', 'Vetelar')
        ])->label(false) ?>
        <button class="btn btn-primary remove-filter-btn">
            <i class="fa-solid fa-trash-can"></i>
        </button>
    </div>

    <div class="hozzad-row">
        <?= $form->field($model, 'jarmutipus', ['options' => ['class' => 'filter-item']])->dropDownList(OptionsHelper::jarmutipusaOptions(), [
            "prompt" => Yii::t('app', 'Jarmutipus ID')
        ])->label(false) ?>
        <button class="btn btn-primary remove-filter-btn">
            <i class="fa-solid fa-trash-can"></i>
        </button>
    </div>

    <div class="hozzad-row">
        <?= $form->field($model, 'motortipus', ['options' => ['class' => 'filter-item']])->dropDownList(OptionsHelper::motortipusOptions(), [
            "prompt" => Yii::t('app', 'Motortipus ID')
        ])->label(false) ?>
        <button class="btn btn-primary remove-filter-btn">
            <i class="fa-solid fa-trash-can"></i>
        </button>
    </div>

    <div class="hozzad-row">
        <?= $form->field($model, 'valto', ['options' => ['class' => 'filter-item']])->dropDownList(OptionsHelper::valtoOptions(), [
            "prompt" => Yii::t('app', 'Valto ID')
        ])->label(false) ?>
        <button class="btn btn-primary remove-filter-btn">
            <i class="fa-solid fa-trash-can"></i>
        </button>
    </div>

    <div class="hozzad-row">
        <?= $form->field($model, 'teljesitmeny', ['options' => ['class' => 'filter-item']])->dropDownList(OptionsHelper::teljesitmenyOptions(), [
            "prompt" => Yii::t('app', 'Teljesitmeny')
        ])->label(false) ?>
        <button class="btn btn-primary remove-filter-btn">
            <i class="fa-solid fa-trash-can"></i>
        </button>
    </div>

    <div class="hozzad-row">
        <?= $form->field($model, 'kilometer', ['options' => ['class' => 'filter-item']])->dropDownList(OptionsHelper::kilometerOptions(), [
            "prompt" => Yii::t('app', 'Kilometer')
        ])->label(false) ?>
        <button class="btn btn-primary remove-filter-btn">
            <i class="fa-solid fa-trash-can"></i>
        </button>
    </div>

    <div class="hozzad-row">
        <?= $form->field($model, 'sorbarendezes', ['options' => ['class' => 'filter-item']])->dropDownList(OptionsHelper::sorbarendezes(), [
            "prompt" => Yii::t('app', 'Sorbarendezes')
        ])->label(false) ?>
        <button class="btn btn-primary remove-filter-btn">
            <i class="fa-solid fa-trash-can"></i>
        </button>
    </div>
</div>

<div id="bovitett-kereses-box" class="bovitett-kereses-box">
    <div class="kereses-header">
        <h2><?= Yii::t("app", "Bovitett Kereses") ?></h2>
        <div>
            <i class="fa-solid fa-square-plus"></i>
            <i class="fa-solid fa-square-minus"></i>
        </div>
    </div>

    <div class="bovitett-kereses-box-accordion">
        <div>
            <div>
                <div class="kereses-box">
                    <div class="hozzad-row">
                        <?= $form->field($model, 'szin', ['options' => ['class' => 'filter-item']])->dropDownList(OptionsHelper::szinekOptions(), [
                            "prompt" => Yii::t('app', 'Szinek')
                        ])->label(false) ?>
                        <button class="btn btn-primary remove-filter-btn">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                    <div class="hozzad-row">
                        <?= $form->field($model, 'kivitel', ['options' => ['class' => 'filter-item']])->dropDownList(OptionsHelper::kivitelOptions(), [
                            "prompt" => Yii::t('app', 'Kivitel ID')
                        ])->label(false) ?>
                        <button class="btn btn-primary remove-filter-btn">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                    <div class="hozzad-row">
                        <?= $form->field($model, 'ajtokszama', ['options' => ['class' => 'filter-item']])->dropDownList(OptionsHelper::ajtokOptions(), [
                            "prompt" => Yii::t('app', 'Ajtok Szam')
                        ])->label(false) ?>
                        <button class="btn btn-primary remove-filter-btn">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                    <div class="hozzad-row">
                        <?= $form->field($model, 'szallithatoSzemelyek', ['options' => ['class' => 'filter-item']])->dropDownList(OptionsHelper::szallithatoSzemelyekOptions(), [
                            "prompt" => Yii::t('app', 'Szallithato Szemelyek')
                        ])->label(false) ?>
                        <button class="btn btn-primary remove-filter-btn">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                    <div class="hozzad-row">
                        <?= $form->field($model, 'sajatTomeg', ['options' => ['class' => 'filter-item']])->dropDownList(OptionsHelper::tomegOptions(), [
                            "prompt" => Yii::t('app', 'Sajat Tomeg')
                        ])->label(false) ?>
                        <button class="btn btn-primary remove-filter-btn">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                    <div class="hozzad-row">
                        <?= $form->field($model, 'ossztomeg', ['options' => ['class' => 'filter-item']])->dropDownList(OptionsHelper::tomegOptions(), [
                            "prompt" => Yii::t('app', 'Ossztomeg')
                        ])->label(false) ?>
                        <button class="btn btn-primary remove-filter-btn">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                    <div class="hozzad-row">
                        <?= $form->field($model, 'terhelhetoseg', ['options' => ['class' => 'filter-item']])->dropDownList(OptionsHelper::tomegOptions(), [
                            "prompt" => Yii::t('app', 'Terhelhetoseg')
                        ])->label(false) ?>
                        <button class="btn btn-primary remove-filter-btn">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                    <div class="hozzad-row">
                        <?= $form->field($model, 'tengelytav', ['options' => ['class' => 'filter-item']])->dropDownList(OptionsHelper::meretOptions(), [
                            "prompt" => Yii::t('app', 'Tengelytav')
                        ])->label(false) ?>
                        <button class="btn btn-primary remove-filter-btn">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                    <div class="hozzad-row">
                        <?= $form->field($model, 'hosszusag', ['options' => ['class' => 'filter-item']])->dropDownList(OptionsHelper::meretOptions(), [
                            "prompt" => Yii::t('app', 'Hosszusag')
                        ])->label(false) ?>
                        <button class="btn btn-primary remove-filter-btn">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                    <div class="hozzad-row">
                        <?= $form->field($model, 'szelesseg', ['options' => ['class' => 'filter-item']])->dropDownList(OptionsHelper::meretOptions(), [
                            "prompt" => Yii::t('app', 'Szelesseg')
                        ])->label(false) ?>
                        <button class="btn btn-primary remove-filter-btn">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                    <div class="hozzad-row">
                        <?= $form->field($model, 'hengerek_szama', ['options' => ['class' => 'filter-item']])->dropDownList(OptionsHelper::hengerSzamOptions(), [
                            "prompt" => Yii::t('app', 'Hengerek Szama')
                        ])->label(false) ?>
                        <button class="btn btn-primary remove-filter-btn">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                    <div class="hozzad-row">
                        <?= $form->field($model, 'hengerurtartalom', ['options' => ['class' => 'filter-item']])->dropDownList(OptionsHelper::hengerurtartalomOptions(), [
                            "prompt" => Yii::t('app', 'Hengerurtartalom')
                        ])->label(false) ?>
                        <button class="btn btn-primary remove-filter-btn">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="d-flex justify-content-between">
    <button id="reset-filter-btn" class="btn btn-danger">
        <i class="fa-solid fa-trash-can"></i>&nbsp;Alaphelyzet
    </button>
    <button id="save-filter-btn" type="submit" class="btn btn-primary">
        <i class="fa-solid fa-sliders"></i>&nbsp;
        Keresés
    </button>

</div>


<?php MainForm::end() ?>
