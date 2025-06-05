<?php

namespace app\models\index;

use app\models\base\Autok;
use app\widgets\autokitem\AutokitemWidget;

final class LandingAutok extends Autok
{
    public function fields()
    {
        $fields                     = parent::fields();
        $fields["template"]         = fn () => AutokitemWidget::widget(['model' => $this]);
        $fields["hirdetes_leirasa"] = fn () => $this->hirdetesLeirasa;
        $fields["oldal"]            = fn () => $this->oldalLink;
        return $fields;
    }

}
