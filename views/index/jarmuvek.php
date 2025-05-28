<?php
/***
 * @var View $this
 * @var MainForm $form
 * @var FilterModel $model
 */

use app\components\MainForm;
use app\helpers\OptionsHelper;
use app\models\index\FilterModel;
use yii\web\JqueryAsset;
use yii\web\View;

$this->registerJsFile("@web/webpack/jarmuvek.js", ['depends' => JqueryAsset::class]);

?>

<!-- Search Filters -->
<section class="py-5 bg-light">
    <div class="container">
        <?php $form = MainForm::begin([
            "id"      => "filter-form",
            'options' => [
                'class' => 'filter-form-box'
            ]
        ]) ?>

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


        <div>
            <button style="display: none" id="save-filter-btn" type="submit" class="btn btn-primary">Keresés</button>
        </div>



        <?php MainForm::end() ?>
    </div>
</section>
<section id="listings" class="py-5">
    <div class="container">
        <h2 class="mb-4 text-center">Járművek</h2>
        <div id="jarmuvek-pager-1"></div>
        <div id="jarmuvek-list" class="border-0 pt-2 pb-2">

        </div>
        <div id="jarmuvek-pager-2"></div>
    </div>
</section>

