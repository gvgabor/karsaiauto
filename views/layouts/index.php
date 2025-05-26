<?php

/** @var yii\web\View $this */

/** @var string $content */

use app\assets\AppAsset;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
$heroBack = Yii::getAlias("@web/images/70fe78fc-202475-ford-transit-350l-nigtt.jpg")
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Használt Kisteherautók</title>
        <link
                href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
                rel="stylesheet"
        >
        <?php $this->head() ?>
    </head>
    <body class="d-flex flex-column h-100">
        <?php $this->beginBody() ?>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg  navbar-dark bg-dark sticky-top">
            <div class="container">
                <a class="navbar-brand" href="#">KARSAI AUTÓ</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto text-center">
                        <li class="nav-item">
                            <a class="nav-link active" href="/">Kezdőlap</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Járművek</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Kapcsolat</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


        <!-- Hero Section -->
        <section class="hero text-center" style="--back:url(<?= $heroBack ?>)">
            <div class="container">
                <div class="inner container p-4 rounded">
                    <h1 class="text-white">Találd meg a hozzád illő kisteherautót</h1>
                    <p class="lead text-white">Széles választék, megbízható állapot, kedvező árak.</p>
                </div>
            </div>
        </section>




        <?= $content ?>

        <!-- Contact CTA -->
        <section id="contact" class="py-5 bg-dark text-white text-center">
            <div class="container">
                <h2>Érdeklődés vagy kérdés?</h2>
                <p class="mb-4">Küldj üzenetet, és munkatársaink hamarosan felveszik veled a kapcsolatot.</p>
                <a href="mailto:info@kisteherauto.hu" class="btn btn-outline-light btn-lg">Írj nekünk</a>
            </div>
        </section>

        <!-- Footer -->
        <footer class="py-4 bg-secondary text-white text-center">
            <div class="container">
                <p class="mb-0">&copy; 2025 Használt Kisteherautók. Minden jog fenntartva.</p>
            </div>
        </footer>


        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
