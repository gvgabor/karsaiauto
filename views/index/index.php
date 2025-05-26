<?php
/***
 * @var View $this
 */

use yii\web\JqueryAsset;
use yii\web\View;

$this->registerJsFile("@web/webpack/landing.js", ["depends" => JqueryAsset::class]);

?>


<!-- Search Filters -->
<section class="py-5 bg-light">
    <div class="container">
        <form class="row g-3">
            <div class="col-md-3">
                <select class="form-select">
                    <option selected>Márka</option>
                    <option>Ford</option>
                    <option>Mercedes</option>
                    <option>Renault</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select">
                    <option selected>Évjárat</option>
                    <option>2020+</option>
                    <option>2015-2020</option>
                    <option>2010-2015</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select">
                    <option selected>Ár</option>
                    <option>0-5M Ft</option>
                    <option>5-10M Ft</option>
                    <option>10M Ft felett</option>
                </select>
            </div>
            <div class="col-md-3 d-grid">
                <button type="submit" class="btn btn-primary">Keresés</button>
            </div>
        </form>
    </div>
</section>


<section id="listings" class="py-5">
    <div class="container">
        <h2 class="mb-4 text-center">Kiemelt Járművek</h2>
        <div id="kiemelt-autok-list" class="border-0">

        </div>
    </div>
</section>

<section id="listings" class="py-5">
    <div class="container">
        <h2 class="mb-4 text-center">Akciós járművek</h2>
        <div id="akcios-autok-list" class="border-0">

        </div>
    </div>
</section>


