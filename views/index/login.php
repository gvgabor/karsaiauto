<?php
/***
 * @var View $this
 * @var MainForm $form
 * @var Felhasznalok $model
 */

use app\components\MainForm;
use app\models\base\Felhasznalok;
use yii\web\View;
use yii\widgets\ActiveForm;

//$this->registerJsFile('@web/webpack/login.js', ['depends' => [JqueryAsset::class]]);

?>



<?PHP $form = ActiveForm::begin(["id" => "login-form", 'validateOnType' => false]) ?>
<?= $form->field($model, "felhasznaloi_nev") ?>
<?= $form->field($model, "jelszo") ?>
<button id="login-btn" class="w-100 btn btn-lg btn-primary" type="submit">Bejelentkezés</button>
<?PHP ActiveForm::end() ?>


