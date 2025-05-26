<?php
/***
 * @var View $this
 * @var string $content
 */

use app\assets\AppAsset;
use yii\web\View;

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
        <title>Bejelentkezés</title>
        <?php $this->head() ?>
        <style>
            /* Háttérkép alacsony átlátszósággal pseudo-elemmel */
            body {
                position: relative;
                margin: 0;
                min-height: 100vh;
                /* A tartalmi háttérszín, ha szükséges */
                background-color: #f8f9fa;
            }

            body::before {
                content: "";
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: url("/images/70fe78fc-202475-ford-transit-350l-nigtt.jpg") center no-repeat;
                opacity: 0.5;
                z-index: -1;
            }
        </style>
    </head>
    <body class="bg-black">
        <?php $this->beginBody() ?>
        <div class="container">
            <div class="row justify-content-center align-items-center vh-100">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center mb-4" style="height: 60px">
                                <img
                                        src="/images/2yqT.gif" alt="Logo"
                                        class="img-fluid" style="width: 100%"
                                >
                            </div>
                            <!-- Logo hozzáadása -->
                            <div class="text-center mb-4">
                                <img
                                        src="/images/Cemagraphics-Classic-Cars-Yellow-pickup.512.png" alt="Logo"
                                        class="img-fluid" style="max-height:250px;"
                                >
                            </div>


                            <h1 class="h3 mb-3 fw-normal text-center">Bejelentkezés</h1>
                            <?= $content ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>

