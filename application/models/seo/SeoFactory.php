<?php
namespace application\models\seo;

use application\models\Drugstores;
use application\models\Leptaden;
use system\basic\BaseModel;

/**
 * Class SeoFactory
 * @package application\models\seo
 */
class SeoFactory extends BaseModel
{
    public static function factory($module)
    {
        $seo = null;
        if ($module instanceof Leptaden) {
            $seo = new SeoLeptaden();
        } else if ($module instanceof Drugstores) {
            $seo = new SeoDrugstores();
        }
        if (!is_null($seo)) {
            $seo->init($module);
        }
        return $seo;
    }
}