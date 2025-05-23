<?php
/***
 * @var View $this
 * @var MainForm $form
 * @var Autok $model
 */

use app\components\MainForm;
use app\helpers\HtmlHelper;
use app\helpers\OptionsHelper;
use app\models\base\Autok;
use yii\helpers\Json;
use yii\web\View;
use Yiisoft\Html\Html;

$uploadKepekBox = Html::div()
    ->id("upload-kepek-box");

if ($model->isNewRecord === false) {
    $uploadKepekBox = $uploadKepekBox->addAttributes([
        "data-images" => Json::encode($model->autokImage)
    ]);
}

?>

<div class="card">
    <div class="card-header">
        <div class="card-title">
            Autók létrehozása/szerkesztése
        </div>
        <div class="close-box">
            <i class="fa fa-times-circle fa-2x"></i>
        </div>
    </div>
    <div class="card-body">
        <?php $form = MainForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
        ]) ?>
        <div style="display: none">
            <?= $form->field($model, "id") ?>
        </div>

        <div class="form-wrapper">
            <div>

                <div id="form-tab">
                    <ul>
                        <li>Alapadatok</li>
                    </ul>
                    <div>


                        <?= $form->field($model, "hirdetes_cime") ?>
                        <?= $form->field($model, "hirdetes_leirasa")->textarea() ?>


                        <div class="grid-col-3">
                            <?= $form->field($model, "marka_id")->dropDownList(OptionsHelper::markakOptions(), [
                                "prompt" => Yii::t("app", "Please Select")
                            ]) ?>
                            <?= $form->field($model, "model") ?>
                            <?= $form->field($model, "gyartasi_ev") ?>
                        </div>

                        <?= $form->field($model, "jarmutipus_id")->dropDownList(OptionsHelper::jarmutipusaOptions(), [
                            "prompt" => Yii::t("app", "Please Select")
                        ]) ?>

                        <?= $form->field($model, "motortipus_id")->dropDownList(OptionsHelper::motortipusOptions(), [
                            "prompt" => Yii::t("app", "Please Select")
                        ]) ?>

                        <div class="grid-col-3">
                            <?= $form->field($model, "kilometer") ?>
                            <?= $form->field($model, "teljesitmeny") ?>
                            <?= $form->field($model, "valto_id")->dropDownList(OptionsHelper::valtoOptions(), [
                                "prompt" => Yii::t("app", "Please Select")
                            ]) ?>
                        </div>

                        <?= $form->field($model, "muszaki_ervenyes") ?>
                        <?= $form->field($model, "vetelar") ?>

                        <div class="grid-col-3">

                            <?= $form->field($model, "fooldalra")->checkbox([
                                "template" => HtmlHelper::formCheckBox($model->getAttributeLabel("fooldalra"), \yii\helpers\Html::getInputId($model, "fooldalra")),
                            ]) ?>

                            <?= $form->field($model, "publikalva")->checkbox([
                                "template" => HtmlHelper::formCheckBox($model->getAttributeLabel("publikalva"), \yii\helpers\Html::getInputId($model, "publikalva")),
                            ]) ?>

                            <?= $form->field($model, "akcios")->checkbox([
                                "template" => HtmlHelper::formCheckBox($model->getAttributeLabel("akcios"), \yii\helpers\Html::getInputId($model, "akcios")),
                            ]) ?>


                        </div>

                    </div>
                </div>
            </div>
            <div class="image-box">
                <div>
                    <?= $form->field($model, "image[]")->fileInput([
                        "multiple" => true,
                        "accept"   => "image/*"
                    ])->label(false) ?>
                </div>
                <?= $uploadKepekBox->render() ?>
            </div>
        </div>


        <?php MainForm::end() ?>
    </div>
    <div class="card-footer">
        <button class="btn btn-danger save-btn">
            <i class="fa fa-sign-in-alt"></i>&nbsp;<?= Yii::t("app", "save") ?>
        </button>
    </div>
</div>


