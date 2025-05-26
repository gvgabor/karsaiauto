<?php
/***
 * @var View $this
 * @var AutokModel $model
 */

use app\components\enums\UgyfelTipus;
use app\helpers\OptionsHelper;
use app\modules\autok\models\AutokModel;
use yii\web\View;
use yii\widgets\DetailView;

?>

<div class="card">
    <div class="card-header">
        <div class="card-title">  <?= Yii::t("app", "Auto adatai", ["auto" => $model->hirdetes_cime]) ?></div>
        <div class="close-box">
            <i class="fa fa-times-circle fa-2x"></i>
        </div>
    </div>
    <div class="card-body">

        <div id="detail-tab">
            <ul>
                <li><?= Yii::t("app", "Autok Alapadatok") ?></li>
                <li><?= Yii::t("app", "Eladasi Adatok") ?></li>
                <li><?= Yii::t("app", "Eladas Ugyfel ID") ?></li>
            </ul>
            <div class="border-0">
                <?= DetailView::widget([
                    'model'      => $model,
                    'attributes' => [
                        'hirdetes_cime',
                        'hirdetes_leirasa',
                        ['label' => Yii::t("app", "Marka ID"), 'attribute' => 'marka.name',],
                        'model',
                        'gyartasi_ev',
                        ['attribute' => 'formatKilometer', 'label' => Yii::t('app', 'Kilometer'),],
                        ['attribute' => 'formatVetelar', 'label' => Yii::t('app', 'Vetelar'),],
                        ['attribute' => 'formatAkciosar', 'label' => Yii::t('app', 'Akcios Ar'),],
                        [
                            'attribute' => 'valto_id',
                            'label'     => Yii::t('app', 'Valto ID'),
                            'value'     => OptionsHelper::valtoOptions()[$model->valto_id],
                        ],
                        ['attribute' => 'motortipus', 'label' => Yii::t('app', 'Motortipus ID'),],
                        'teljesitmeny',
                        'muszaki_ervenyes',
                        'created_at',
                    ]
                ]) ?>
            </div>
            <div class="border-0">
                <?= DetailView::widget([
                    'model'      => $model,
                    'attributes' => [
                        'eladas_datuma',
                        'eladas_megjegyzes',
                        ['attribute' => 'eladasUgyfel.nev', 'label' => Yii::t('app', 'Eladas Ugyfel ID')],
                    ]
                ]) ?>
            </div>
            <div class="border-0">
                <?= DetailView::widget([
                    'model'      => $model->eladasUgyfel,
                    'attributes' => [
                        'nev',
                        'email',
                        'telefon',
                        'lakcim',
                        'cegnev',
                        'adoszam',
                        'szuletesi_datum',
                        'szemelyi_szam',
                        ['attribute' => 'tipus', 'value' => UgyfelTipus::tryFrom($model->eladasUgyfel->tipus)->label(),]
                    ]
                ]) ?>
            </div>
        </div>


    </div>
</div>


