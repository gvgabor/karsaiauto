<?php
/***
 * @var View $this
 * @var MainForm $form
 * @var AutokModel $model
 */

use app\components\MainForm;
use app\helpers\HtmlHelper;
use app\helpers\OptionsHelper;
use app\helpers\UtilHelper;
use app\modules\autok\models\AutokModel;
use yii\helpers\ArrayHelper;
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
$felszereltsegIdList = ArrayHelper::getColumn($model->felszereltsegIdList, 'id');
if ($model->isNewRecord && UtilHelper::isLocal()) {
    $felszereltsegIdList = $model->felszereltseg;
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
                        <li><?= Yii::t("app", "Alapadatok") ?></li>
                        <li><?= Yii::t("app", "Egyeb Adatok") ?></li>
                        <li><?= Yii::t("app", "Dokumentumok") ?></li>
                    </ul>
                    <div>


                        <?= $form->field($model, "hirdetes_cime") ?>
                        <?= $form->field($model, "hirdetes_leirasa")->textarea() ?>


                        <div class="grid-col-3">
                            <div class="hozzad-row">
                                <?= $form->field($model, "marka_id")->dropDownList(OptionsHelper::markakOptions(), [
                                    "prompt" => Yii::t("app", "Please Select")
                                ]) ?>
                                <button id="marka-hozzaad-btn" class="btn btn-danger"><i
                                            class="fa-solid fa-square-plus"
                                    ></i></button>
                            </div>

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



                        <div id="akcios-ar-box">
                            <?= $form->field($model, "akcios_ar") ?>
                        </div>

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
                    <div>
                        <div class="egyeb-box">
                            <div class="grid-col-3">
                                <div class="hozzad-row">
                                    <?= $form->field($model, "szinek_id")->dropDownList(OptionsHelper::szinekOptions(), [
                                        "prompt" => Yii::t("app", "Please Select")
                                    ]) ?>
                                    <button id="szin-hozzaad-btn" class="btn btn-danger"><i
                                                class="fa-solid fa-square-plus"
                                        ></i></button>
                                </div>
                                <div class="hozzad-row">
                                    <?= $form->field($model, "kivitel_id")->dropDownList(OptionsHelper::kivitelOptions(), [
                                        "prompt" => Yii::t("app", "Please Select")
                                    ]) ?>
                                    <button id="kivitel-hozzaad-btn" class="btn btn-danger"><i
                                                class="fa-solid fa-square-plus"
                                        ></i></button>
                                </div>
                            </div>

                            <div class="grid-col-3">
                                <?= $form->field($model, "ajtok_szam") ?>
                                <?= $form->field($model, "szallithato_szemelyek") ?>

                            </div>
                            <div class="grid-col-3">
                                <?= $form->field($model, "sajat_tomeg") ?>
                                <?= $form->field($model, "ossztomeg") ?>
                                <?= $form->field($model, "terhelhetoseg") ?>
                            </div>
                            <div class="grid-col-3">
                                <?= $form->field($model, "tengelytav") ?>
                                <?= $form->field($model, "hosszusag") ?>
                                <?= $form->field($model, "szelesseg") ?>
                            </div>
                            <div class="grid-col-3">
                                <?= $form->field($model, "hengerek_szama") ?>
                                <?= $form->field($model, "hengerurtartalom") ?>
                            </div>
                            <div class="hozzad-row">
                                <?= $form->field($model, "felszereltseg[]")->dropDownList(OptionsHelper::felszereltsegOptions(), [
                                    'multiple'                   => true,
                                    'data-felszereltseg-id-list' => Json::encode($felszereltsegIdList)
                                ]) ?>
                                <button id="felszereltseg-hozzaad-btn" class="btn btn-danger">
                                    <i class="fa-solid fa-square-plus"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                    <div>
                        <div>
                            <?= $form->field($model, "dokumentumok[]")->fileInput([
                                "multiple" => true,
                            ])->label(false) ?>
                        </div>
                        <div>
                            <div data-autok-id="<?= $model->id ?>" id="dokumentumok-grid"></div>
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


