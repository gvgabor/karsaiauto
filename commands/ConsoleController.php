<?php

namespace app\commands;

use app\components\enums\UgyfelTipus;
use app\helpers\DirectoryHelper;
use app\helpers\OptionsHelper;
use app\models\base\FelhasznaloiJogok;
use app\models\base\Felhasznalok;
use app\models\base\Menu;
use app\models\base\Ugyfelek;
use app\modules\autok\actions\AutokAction;
use app\modules\autok\models\AutokModel;
use app\modules\autok\models\EladasModel;
use Exception;
use Faker\Factory;
use Yii;
use yii\console\Controller;
use yii\gii\generators\model\Generator as ModelGenerator;
use yii\helpers\BaseConsole;
use yii\helpers\Console;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;

class ConsoleController extends Controller
{
    public ?string $tableName = null;

    public function options($actionID)
    {
        return ["tableName"];
    }

    public function init()
    {
        parent::init();
        $this->color = true;
    }

    /**
     * @return void
     * php yii console/import-markak
     */
    public function actionImportMarkak()
    {
        Yii::$app->db->createCommand()->truncateTable('{{%markak}}')->execute();
        $path = Yii::getAlias("@app/web/import/markak.txt");
        if (is_file($path)) {
            $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $data  = [];
            $count = 0;
            foreach ($lines as $line) {
                $trimmed = trim($line);
                if ($trimmed !== '') {
                    $data[] = [$trimmed, Inflector::slug($trimmed)];
                    $count++;
                }
            }

            Yii::$app->db->createCommand()->batchInsert('{{%markak}}', ['name', 'friendly_name'], $data)->execute();

            $this->writeOut(gethostname() . PHP_EOL);
            $this->writeOut("Sikeresen importálva: ");
            $this->stdout($count);
            $this->stdout(" márka." . PHP_EOL);
        }
    }

    public function writeOut($text, $param = [
        BaseConsole::FG_YELLOW,
        BaseConsole::BOLD
    ])
    {
        $this->stdout(BaseConsole::ansiFormat($text, $param));
    }

    /**
     * @return void
     * php yii console/create-model-list
     */
    public function actionCreateModelList()
    {
        $except = ['migration'];
        $tables = Yii::$app->db->schema->getTableNames();
        $tables = array_diff($tables, $except);
        foreach ($tables as $item) {
            $this->tableName = $item;
            $this->actionCreateModel();
        }
    }

    /**
     * @return int
     * php yii console/create-model --tableName=
     */
    public function actionCreateModel()
    {
        $generator = new ModelGenerator();

        $generator->tableName = $this->tableName;

        $generator->modelClass        = Inflector::camelize($this->tableName);
        $generator->baseClass         = 'app\components\MainActiveRecord';
        $generator->enableI18N        = true;
        $generator->messageCategory   = 'app';
        $generator->generateRelations = ModelGenerator::RELATIONS_NONE;

        $generator->queryNs       = 'app\\models\\query';
        $generator->ns            = 'app\\models';
        $generator->queryClass    = Inflector::id2camel($this->tableName, '_') . 'Query';
        $generator->generateQuery = true;
        $queryFile                = Yii::getAlias('@app/models/query/' . $generator->queryClass . '.php');

        if (file_exists($queryFile)) {
            $generator->generateQuery = false;
        }

        $generator->queryBaseClass = 'app\\components\\MainActiveQuery';
        if (!$generator->validate()) {
            print_r($generator->getErrors());
            return 1;
        }

        $files = $generator->generate();
        if (empty($files)) {
            echo "Nincsenek fájlok generálva. Lehet, hogy a tábla nem létezik, vagy nem olvasható.\n";
            return 1;
        }

        foreach ($files as $file) {
            if (!$file->save()) {
                echo "Nem sikerült elmenteni: $file->path. Ellenőrizd az írási jogokat vagy az elérési utat.\n";
                return 1;
            } else {
                echo "Sikeresen elmentve: $file->path\n";
            }

        }

        return 0;
    }

    /**
     * @return void
     * php yii console/convert-web-p
     */
    public function actionConvertWebP()
    {
        $path    = "C:/Users/Vince/Desktop/tmp/osszes_auto";
        $memoria = number_format(memory_get_usage() / 1024 / 1024, 2) . ' MB';
        $this->writeOut("Memóriahasználat: " . $memoria);

        $files = FileHelper::findFiles($path, [
            'filter' => function ($path) {
                return pathinfo($path, PATHINFO_EXTENSION) !== 'webp';
            }
        ]);
        $total = count($files);
        Console::startProgress(0, $total);
        $counter = 1;

        foreach ($files as $file) {
            $memoria = number_format(memory_get_usage() / 1024 / 1024, 2) . ' MB';
            Yii::$container->get(AutokAction::class)->convertToWebP($file, $file . ".webp");
            unlink($file);
            Console::updateProgress($counter + 1, $total, "Memória: " . $memoria);
            $counter++;
        }

        Console::endProgress();
        Console::output('Max memóriahasználat: ' . number_format(memory_get_peak_usage() / 1024 / 1024, 2) . ' MB');
    }

    /**
     * @return void
     * php yii console/fill-autok-data
     */
    public function actionFillAutokData()
    {
        $factory = Factory::create('hu_HU');
        $memoria = number_format(memory_get_usage() / 1024 / 1024, 2) . ' MB';
        $this->writeOut("Memóriahasználat: " . $memoria);
        $total = 10000;
        Console::startProgress(0, $total);
        $path        = "C:/Users/Vince/Desktop/tmp/osszes_auto";
        $files       = FileHelper::findFiles($path);
        $autokAction = Yii::$container->get(AutokAction::class);
        $limitBytes  = 10 * 1024 * 1024 * 1024;
        $bytesSize   = DirectoryHelper::getDirectorySize(Yii::getAlias('@app/web/uploads'));
        $formatSize  = DirectoryHelper::formatBytes($bytesSize);

        for ($i = 0; $i < $total; $i++) {
            $memoria = sprintf(
                'Iteráció: %d | Használat: %.2f MB | Csúcs: %.2f MB',
                $i,
                memory_get_usage()      / 1024 / 1024,
                memory_get_peak_usage() / 1024 / 1024
            );

            if ($i % 100 === 0) {
                $bytesSize  = DirectoryHelper::getDirectorySize(Yii::getAlias('@app/web/uploads'));
                $formatSize = DirectoryHelper::formatBytes($bytesSize);
                if ($bytesSize !== false && $bytesSize >= $limitBytes) {
                    Console::updateProgress($i + 1, $total, "MEGÁLLÍTVA! Könyvtár mérete elérte a limitet: " . $formatSize);
                    Console::endProgress();
                    Console::output('A fájlgenerálás leállt, mert az "uploads" könyvtár mérete meghaladta a 10 GB-ot.');
                    Console::output('Max memóriahasználat: ' . number_format(memory_get_peak_usage() / 1024 / 1024, 2) . ' MB');
                    return; // Kilépés a metódusból
                }
            }

            Console::updateProgress($i + 1, $total, "Memória: " . $memoria . " Size: " . $formatSize);
            $model    = $this->actionRandomAuto();
            $images   = $factory->randomElements($files, random_int(2, 21));
            $formData = [
                "hirdetes_leirasa" => $model->hirdetes_leirasa,
                "hirdetes_cime"    => $model->hirdetes_cime,
                "teljesitmeny"     => $model->teljesitmeny,
                "kilometer"        => $model->kilometer,
                "vetelar"          => $model->vetelar,
                "muszaki_ervenyes" => $model->muszaki_ervenyes,
                "motortipus_id"    => $model->motortipus_id,
                "marka_id"         => $model->marka_id,
                "model"            => $model->model,
                "jarmutipus_id"    => $model->jarmutipus_id,
                "gyartasi_ev"      => $model->gyartasi_ev,
                "valto_id"         => $model->valto_id,
                "publikalva"       => 1,
            ];

            $result = $autokAction->save($formData, $images);
            if ($result["success"] === false) {
                throw new Exception($result['message']);
            }
            unset($model, $images, $formData, $result);
            gc_collect_cycles();
        }
        Console::endProgress();
        Console::output('Max memóriahasználat: ' . number_format(memory_get_peak_usage() / 1024 / 1024, 2) . ' MB');

    }

    public function actionRandomAuto()
    {
        $factory                 = Factory::create('hu_HU');
        $model                   = new AutokModel();
        $model->hirdetes_leirasa = "Fiat Ducato 2.3 JTD A strapabíró és megbízható furgon, ami nem hagy cserben! Ha masszív, tágas és gazdaságos haszongépjárművet keresel, megtaláltad a tökéletes választást! Főbb jellemzők: Erős és takarékos motor alacsony fogyasztás, nagy teherbírás Óriási raktér minden belefér, amit csak szállítani akarsz Megbízható technika üzembiztos, karbantartott állapot Kényelmes vezetés hosszú utakra is ideális Azonnal elvihető! Kedvező ár! Hívj most, és vidd el a tökéletes munkafurgont, mielőtt más csap le rá!";
        $model->hirdetes_cime    = mb_strtoupper($factory->randomElement(array_values(OptionsHelper::markakOptions()))) . " 2.3 Mjet LWB 3.5 t";
        $model->teljesitmeny     = (string)$factory->numberBetween(1000, 6000);
        $model->kilometer        = round($factory->numberBetween(100000, 800000), -3);
        $model->vetelar          = round($factory->numberBetween(1000000, 8000000), -3);
        $model->muszaki_ervenyes = $factory->dateTimeBetween("now", "+3 years")->format("Y-m");
        $model->motortipus_id    = $factory->randomElement(array_keys(OptionsHelper::motortipusOptions()));
        $model->marka_id         = $factory->randomElement(array_keys(OptionsHelper::markakOptions()));
        $model->model            = $factory->randomElement(array_values(OptionsHelper::markakOptions()));
        $model->jarmutipus_id    = $factory->randomElement(array_keys(OptionsHelper::jarmutipusaOptions()));
        $model->gyartasi_ev      = random_int(1990, 2025);
        $model->valto_id         = $factory->randomElement(array_keys(OptionsHelper::valtoOptions()));
        $model->publikalva       = 1;
        return $model;
    }

    /**
     * @return void
     * php yii console/fill-ugyfelek
     */
    public function actionFillUgyfelek()
    {
        $memoria = number_format(memory_get_usage() / 1024 / 1024, 2) . ' MB';
        $this->writeOut("Memóriahasználat: " . $memoria);
        $total = 15000;
        Console::startProgress(0, $total);
        for ($i = 0; $i < $total; $i++) {
            $memoria = sprintf(
                'Iteráció: %d | Használat: %.2f MB | Csúcs: %.2f MB',
                $i,
                memory_get_usage()      / 1024 / 1024,
                memory_get_peak_usage() / 1024 / 1024
            );
            Console::updateProgress($i + 1, $total, "Memória: " . $memoria);
            $model = $this->actionRandomUgyfel();
            $model->save();
        }
        Console::endProgress();
        Console::output('Max memóriahasználat: ' . number_format(memory_get_peak_usage() / 1024 / 1024, 2) . ' MB');
    }

    public function actionRandomUgyfel()
    {
        $factory                = Factory::create('hu_HU');
        $model                  = new Ugyfelek();
        $model->nev             = $factory->lastName() . " " . $factory->firstName();
        $model->email           = $factory->email;
        $model->telefon         = $factory->phoneNumber();
        $model->lakcim          = $factory->address();
        $model->szuletesi_datum = $factory->dateTimeBetween("-90 years", "-20 years")->format("Y-m-d");
        $model->szemelyi_szam   = $factory->numerify('###########');
        $model->adoszam         = $factory->numerify('########-#-##');
        $model->cegnev          = $factory->company;
        $model->tipus           = $factory->randomElement(array_keys(UgyfelTipus::list()));
        return $model;
    }

    public function actionRandomEladasModel($modelId)
    {
        $factory                  = Factory::create('hu_HU');
        $model                    = EladasModel::findOne($modelId);
        $model->eladas_datuma     = date("Y-m-d");
        $model->eladas_megjegyzes = $factory->realText(200);
        $model->eladas_ugyfel_id  = $factory->randomElement(array_keys(OptionsHelper::ugyfelOptions()));
        return $model;
    }

    public function actionRandomMenu()
    {
        $model            = new Menu();
        $factory          = Factory::create('hu_HU');
        $model->menu_name = $factory->word();
        $model->parent_id = $factory->randomElement(array_keys($model->possibleParentList($model)));
        $model->sorrend   = $factory->numberBetween(1, 100);
        return $model;
    }

    public function actionRandomFelhasznaloiJog()
    {
        $model                   = new FelhasznaloiJogok();
        $factory                 = Factory::create('hu_HU');
        $model->jogosultsag_neve = $factory->word();
        return $model;
    }

    public function actionRandomFelhasznalo()
    {
        $model                   = new Felhasznalok();
        $factory                 = Factory::create('hu_HU');
        $model->felhasznaloi_nev = $factory->userName();
        $model->jelszo           = $factory->password();
        $model->email            = $factory->email();
        $model->felhasznaloi_jog = $factory->randomElement(array_keys(OptionsHelper::felhasznaloiJogokOptions()));
        return $model;
    }

    /**
     * @return void
     * php yii console/create-language-file
     */
    public function actionCreateLanguageFile()
    {
        $path    = Yii::getAlias("@app/views/index/lang.php");
        $options = [
            OptionsHelper::motortipusOptions(),
            OptionsHelper::motortipusOptions(),
            OptionsHelper::valtoOptions(),
            OptionsHelper::jarmutipusaOptions(),
            OptionsHelper::felhasznaloiJogokOptions(),
        ];
        $text = "<?php  ";
        foreach ($options as $item) {
            foreach ($item as $value) {
                $text .= "Yii::t('app',\"$value\");";
            }
        }

        file_put_contents($path, $text);

    }

}
