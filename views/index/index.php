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

$this->registerJsFile("@web/webpack/landing.js", ["depends" => JqueryAsset::class]);

?>


<!-- Search Filters -->
<section class="py-5 bg-light">
    <div class="container">
        <?php $form = MainForm::begin([
            "id"      => "filter-form",
            'options' => [
                'class' => 'row g-3 align-items-center'
            ]
        ]) ?>
        <?= $form->field($model, 'marka', ['options' => ['class' => 'col-md-3']])->dropDownList(OptionsHelper::markakOptions(), [
            "prompt" => Yii::t('app', 'Marka ID')
        ])->label(false) ?>
        <?= $form->field($model, 'evjarat', ['options' => ['class' => 'col-md-3']])->dropDownList(OptionsHelper::evjaratOptions(), [
            "prompt" => Yii::t('app', 'Evjarat')
        ])->label(false) ?>
        <?= $form->field($model, 'vetelar', ['options' => ['class' => 'col-md-3']])->dropDownList(OptionsHelper::vetelarOptions(), [
            "prompt" => Yii::t('app', 'Vetelar')
        ])->label(false) ?>
        <div class="col-md-3 d-grid">
            <button id="save-filter-btn" type="submit" class="btn btn-primary">Keresés</button>
        </div>
        <?php MainForm::end() ?>
    </div>
</section>


<section id="listings" class="py-5">
    <div class="container">
        <h2 id="kiemelt-autok-label" class="mb-4 text-center">Kiemelt Járművek</h2>
        <div id="kiemelt-autok-list" class="border-0">

        </div>
    </div>
</section>

<section id="listings" class="py-5">
    <div class="container">
        <h2 id="akcios-autok-label" class="mb-4 text-center">Akciós járművek</h2>
        <div id="akcios-autok-list" class="border-0">

        </div>
    </div>
</section>


