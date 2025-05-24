<?php

namespace app\models\base;

use app\models\query\AutokDokumentumokQuery;
use Yii;
use yii\helpers\Url;

/**
 *
 * @property-read string $path
 * @property-read string $dokumentumUrl
 * @property-read Autok $autok
 */
class AutokDokumentumok extends \app\models\AutokDokumentumok
{
    public static function find()
    {
        return new AutokDokumentumokQuery(get_called_class());
    }

    public function getAutok()
    {
        return $this->hasOne(Autok::class, ["id" => "autok_id"]);
    }

    public function fields()
    {
        $fields                  = parent::fields();
        $fields["dokumentumUrl"] = fn () => $this->dokumentumUrl;
        return $fields;
    }

    public function softDelete()
    {
        unlink($this->path);
        return parent::softDelete();
    }

    public function getDokumentumUrl(): string
    {
        return Url::to(["/autok/index/dokumentumok", "id" => $this->id], true);
    }

    public function getPath()
    {
        $path = Yii::getAlias("@app/dokumentumok/" . $this->autok->longId . "/" . $this->filename);
        return $path;
    }

}
