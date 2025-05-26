<?php
/***
 * @var View $this
 * @var Menu $model
 * @var MainForm $form
 */

use app\components\MainForm;
use app\models\base\Menu;
use yii\web\View;

?>

<div class="card">
    <div class="card-header">
        <div class="card-title">
            Menü létrehozása/szerkesztése
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

        <?= $form->field($model, "menu_name") ?>
        <?= $form->field($model, "menu_url") ?>
        <?= $form->field($model, "parent_id")->dropDownList($model->possibleParentList($model), [
            "prompt" => Yii::t("app", "Please Select")
        ]) ?>
        <?= $form->field($model, "sorrend") ?>
        <?php MainForm::end() ?>
    </div>
    <div class="card-footer">
        <button class="btn btn-danger save-btn">
            <i class="fa fa-sign-in-alt"></i>&nbsp;<?= Yii::t("app", "save") ?>
        </button>
    </div>
</div>


