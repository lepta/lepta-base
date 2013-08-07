<?php
namespace application\models;

use system\db\ActiveRecord;

/**
 * Class DrugstoreCity
 * @package application\models
 */
class DrugstoreCity extends ActiveRecord
{
    /**
     * @var string
     */
    protected $_table = 'drugstores_cities';

    /**
     * @return string | bool
     */
    public function getRegionAlias()
    {
        if ($this->isVoid()) {
            return false;
        }
        $region = new DrugstoreRegion();
        $region->find( $this->region_id );
        return $region->alias;
    }
}