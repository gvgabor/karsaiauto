<?php

namespace app\commands;

use app\models\base\Felszereltseg;
use app\models\base\Kivitel;
use app\models\base\Szinek;
use Yii;
use yii\console\Controller;

class ImportController extends Controller
{
    /**
     * @return void
     * php yii import/szinek
     */
    public function actionSzinek()
    {
        Yii::$app->db->createCommand()->truncateTable('{{%szinek}}')->execute();
        $path  = Yii::getAlias("@app/web/import/szinek.txt");
        $items = file($path);
        foreach ($items as $value) {
            $model = new Szinek([
                'szin_neve' => trim($value)
            ]);
            $model->save();
        }
    }

    /**
     * @return void
     * php yii import/kivitel
     */
    public function actionKivitel()
    {
        Yii::$app->db->createCommand()->truncateTable('{{%kivitel}}')->execute();
        $path  = Yii::getAlias("@app/web/import/kivitel.txt");
        $items = file($path);
        foreach ($items as $value) {
            $model = new Kivitel([
                'name' => trim($value)
            ]);
            $model->save();
        }
    }

    /**
     * @return void
     * php yii import/felszereltseg
     */
    public function actionFelszereltseg()
    {
        Yii::$app->db->createCommand()->truncateTable('{{%felszereltseg}}')->execute();
        $path  = Yii::getAlias("@app/web/import/feltszereltseg.txt");
        $items = file($path);
        foreach ($items as $value) {
            $model = new Felszereltseg([
                'name' => trim($value)
            ]);
            $model->save();
        }
    }

}
