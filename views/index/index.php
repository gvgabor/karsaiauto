<?php
/***
 * @var View $this
 */

use yii\web\View;

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

<!-- Featured Listings -->
<section id="listings" class="py-5">
    <div class="container">
        <h2 class="mb-4 text-center">Kiemelt Járművek</h2>
        <div class="row g-4">
            <!-- Card 1 -->
            <div class="col-md-4">
                <div class="card h-100">
                    <img
                            src="https://placehold.co/400x250?text=Jármű+1" class="card-img-top"
                            alt="Jármű 1"
                    >
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Ford Transit</h5>
                        <p class="card-text mb-4">2018, 120 000 km, dízel</p>
                        <div class="mt-auto">
                            <span class="h5 text-primary">4 199 000 Ft</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="col-md-4">
                <div class="card h-100">
                    <img
                            src="https://placehold.co/400x250?text=Jármű+2" class="card-img-top"
                            alt="Jármű 2"
                    >
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Mercedes-Benz Sprinter</h5>
                        <p class="card-text mb-4">2017, 150 000 km, dízel</p>
                        <div class="mt-auto">
                            <span class="h5 text-primary">5 500 000 Ft</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="col-md-4">
                <div class="card h-100">
                    <img
                            src="https://placehold.co/400x250?text=Jármű+3" class="card-img-top"
                            alt="Jármű 3"
                    >
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Renault Master</h5>
                        <p class="card-text mb-4">2019, 90 000 km, dízel</p>
                        <div class="mt-auto">
                            <span class="h5 text-primary">4 800 000 Ft</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>        <!-- Featured Listings -->
<section id="listings" class="py-5">
    <div class="container">
        <h2 class="mb-4 text-center">Akciós Járművek</h2>
        <div class="row g-4">
            <!-- Card 1 -->
            <div class="col-md-4">
                <div class="card h-100">
                    <img
                            src="https://placehold.co/400x250?text=Jármű+1" class="card-img-top"
                            alt="Jármű 1"
                    >
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Ford Transit</h5>
                        <p class="card-text mb-4">2018, 120 000 km, dízel</p>
                        <div class="mt-auto">
                            <span class="h5 text-primary">4 199 000 Ft</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card 2 -->
            <div class="col-md-4">
                <div class="card h-100">
                    <img
                            src="https://placehold.co/400x250?text=Jármű+2" class="card-img-top"
                            alt="Jármű 2"
                    >
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Mercedes-Benz Sprinter</h5>
                        <p class="card-text mb-4">2017, 150 000 km, dízel</p>
                        <div class="mt-auto">
                            <span class="h5 text-primary">5 500 000 Ft</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card 3 -->
            <div class="col-md-4">
                <div class="card h-100">
                    <img
                            src="https://placehold.co/400x250?text=Jármű+3" class="card-img-top"
                            alt="Jármű 3"
                    >
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Renault Master</h5>
                        <p class="card-text mb-4">2019, 90 000 km, dízel</p>
                        <div class="mt-auto">
                            <span class="h5 text-primary">4 800 000 Ft</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

