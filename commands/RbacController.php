<?php

namespace app\commands;

use app\models\base\Felhasznalok;
use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    /**
     * @return void
     * php yii rbac/init
     */
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $superAdmin              = $auth->createRole('szuperadmin');
        $superAdmin->description = "Szuperadmin";
        $auth->add($superAdmin);

        $admin              = $auth->createRole('admin');
        $admin->description = "Admin";
        $auth->add($admin);

        $me = Felhasznalok::findOne(["felhasznaloi_nev" => "vince"]);
        $auth->assign($superAdmin, $me->id);

        $rootManage              = $auth->createPermission("rootmanage");
        $rootManage->description = "Szuperadmin kezelése";
        $auth->add($rootManage);

        $auth->addChild($superAdmin, $rootManage);

        echo "RBAC jogosultságok és szerepkörök létrehozva.\n";
    }

}
