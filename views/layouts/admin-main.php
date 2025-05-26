<?php

/** @var yii\web\View $this */

/** @var string $content */

use app\assets\AppAsset;
use app\helpers\HtmlHelper;
use app\models\base\Felhasznalok;
use richardfan\widget\JSRegister;
use yii\bootstrap5\Html;
use yii\web\View;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="">
        <?php $this->beginBody() ?>
        <?php JSRegister::begin(["position" => View::POS_HEAD]) ?>
        <script>
            kendo.culture("hu-HU");
        </script>
        <?php JSRegister::end() ?>


        <nav class="navbar navbar-expand-xxl  navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>">
                    MÁRTON HUNGARY KFT
                </a>
                <button
                        class="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbar-content"
                        aria-controls="navbar-content"
                        aria-expanded="false"
                        aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbar-content">
                    <?= Felhasznalok::findOne(Yii::$app->user->id)->getHtmlMenu() ?>
                    <ul class="navbar-nav ms-auto">
                        <?php foreach (HtmlHelper::languageSelector() as $item): ?>
                            <?= $item->render() ?>
                        <?php endforeach; ?>
                        <li class="nav-item d-inline-flex align-items-center text-white">
                            <i class="fa fa-user-alt"></i>&nbsp;
                            Felhasználó: <?= Yii::$app->user->identity?->username ?>
                        </li>
                        <li class="nav-item">
                            <a
                                    class="nav-link"
                                    href="<?= Yii::$app->urlManager->createAbsoluteUrl(['login/logout']) ?>"
                            >
                                <i class="fas fa-sign-out-alt"></i>&nbsp;<?= Yii::t("app", "logout") ?>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>

        <div class="main-page-box">
            <?= $content ?>
        </div>


        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
