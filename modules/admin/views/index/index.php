<?php
/***
 * @var View $this
 */

use app\helpers\ColumnsHelper;
use yii\web\JqueryAsset;
use yii\web\View;

$this->registerJsFile('@web/webpack/admin.js', ['depends' => [JqueryAsset::class]]);
$this->registerJsVar("felhasznalokColumns", ColumnsHelper::felhasznalokColumns());
$this->registerJsVar("felhasznaloiJogokColumns", ColumnsHelper::felhasznaloiJogokColumns());
$this->registerJsVar("menuColumns", ColumnsHelper::menuColumns());
$this->registerJsVar("hozzarendelesMenuColumns", ColumnsHelper::hozzarendelesMenuColumns());
$this->registerJsVar("hozzarendelveMenuColumns", ColumnsHelper::hozzarendelveMenuColumns());


?>

<div class="card main-card border-0">
    <div class="card-header">
        <div class="card-title">
            Admin felület
        </div>
    </div>
    <div class="card-body">
        <div class="main-box">
            <div class="content-box">
                <div id="admin-tab" class="admin-tab">
                    <ul>
                        <li>
                            <i class="fa fa-list-alt"></i>&nbsp;Menük
                        </li>
                        <li>
                            <i class="fa fa-list-alt"></i>&nbsp;Felhasználók
                        </li>
                        <li>
                            <i class="fa fa-list-alt"></i>&nbsp;Felhasználói jogok
                        </li>
                    </ul>
                    <div>
                        <div class="inner">
                            <div class="header">
                                <div>&nbsp;</div>
                                <button id="create-menu-btn" class="btn btn-danger rounded-0">
                                    <i class="fa fa-plus-square"></i> Menüpont hozzáadása
                                </button>
                            </div>
                            <div class="grid-box">
                                <div  id="menu-grid" class="border-0 grid"></div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="inner">
                            <div class="header">
                                <div>&nbsp;</div>
                                <button id="create-felhasznalo-btn" class="btn btn-danger rounded-0">
                                    <i class="fa fa-plus-square"></i> Felhasználó hozzáadása
                                </button>
                            </div>
                            <div class="wper">
                                <div id="felhasznalok-grid" class="border-0 grid"></div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="inner">
                            <div class="header">
                                <div>&nbsp;</div>
                                <button id="create-felhasznaloi-jog-btn" class="btn btn-danger rounded-0">
                                    <i class="fa fa-plus-square"></i> Felhasználói jog hozzáadása
                                </button>
                            </div>
                            <div class="wper">
                                <div id="felhasznaloi-jogok-grid" class="border-0 grid"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
