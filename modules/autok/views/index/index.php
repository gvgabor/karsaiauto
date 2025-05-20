<?php
/***
 * @var View $this
 */

use app\helpers\HtmlHelper;
use yii\web\JqueryAsset;
use yii\web\View;

$this->registerJsFile('@web/webpack/autok.js', ['depends' => [JqueryAsset::class]]);

?>

<div class="card main-card">
    <div class="card-header">
        <div class="card-title">
            Autók kezelése
        </div>
        <div>
            <?= HtmlHelper::hozzaadasBtn("Autó létrehozása", "create-auto-btn") ?>
        </div>
    </div>
    <div class="card-body">
      Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa eos, placeat! Autem illo iste molestiae quis tenetur. Adipisci beatae commodi deleniti dolores expedita iste laborum obcaecati, officia pariatur! Labore, numquam.
    </div>
</div>


