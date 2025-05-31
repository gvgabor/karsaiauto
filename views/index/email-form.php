<?php
/***
 * @var View $this
 * @var MainForm $form
 * @var KapcsolatModel $model
 */

use app\components\MainForm;
use app\models\index\KapcsolatModel;
use yii\web\View;

?>

<div class="row justify-content-center w-100">
    <div class="p-0">
        <div class="card shadow-lg border-0 rounded-0 round-left">
            <div class="card-body p-5">
                <h2 class="mb-4 text-center">Kapcsolatfelvétel</h2>
                <?php $form = MainForm::begin([
                    "id" => "uzenet-form"
                ]) ?>
                <div style="display: none">
                    <?= $form->field($model, "autoId") ?>
                </div>
                <?= $form->field($model, "nev") ?>
                <?= $form->field($model, "email") ?>
                <?= $form->field($model, "targy") ?>
                <?= $form->field($model, "uzenet")->textarea() ?>
                <div class="d-grid">
                    <button id="kuldes-btn" type="submit" class="btn btn-primary btn-lg">Üzenet küldése</button>
                </div>
                <?php MainForm::end() ?>
            </div>
        </div>
    </div>
</div>
