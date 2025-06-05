<?php
/***
 * @var View $this
 * @var MainForm $form
 * @var FilterModel $model
 */

use app\components\MainForm;
use app\models\index\FilterModel;
use yii\web\JqueryAsset;
use yii\web\View;

$this->registerJsFile("@web/webpack/jarmuvek.js", ['depends' => JqueryAsset::class]);

?>

<!-- Search Filters -->
<section class="py-5 bg-light">
    <div class="container">

        <?= $this->render("@app/views/index/kereses-box", ["model" => $model]) ?>

        <?php $form = MainForm::begin([
            "id"      => "filter-form",
            'options' => [
                'class' => 'filter-form-box'
            ]
        ]) ?>


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

