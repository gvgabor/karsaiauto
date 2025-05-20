<?php
/***
 * @var View $this
 */

use yii\web\View;

?>



<div class="card hozzarendeles-box rounded-0">
    <div class="card-header">
        <div class="card-title">
            Hozzárendelés
        </div>
        <div class="close-box">
            <i class="fa fa-times-circle fa-2x"></i>
        </div>
    </div>
    <div class="card-body">
        <div class="hozzarendeles-grid-box">
            <div>
                <div class="card rounded-0">
                    <div class="card-header">
                        <div class="card-title">
                            Menü elemek
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div id="menu-elemek-grid" class="border-0"></div>
                    </div>
                </div>

            </div>
            <div><i class="fa-solid fa-arrow-right-arrow-left"></i></div>
            <div>
                <div class="card rounded-0">
                    <div class="card-header">
                        <div class="card-title">
                            Hozzárendelt elemek
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div id="hozzarendelt-elemek-grid" class="border-0"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button class="btn btn-danger save-btn">
            <i class="fa fa-sign-in-alt"></i>&nbsp;<?= Yii::t("app", "save") ?>
        </button>
    </div>
</div>


