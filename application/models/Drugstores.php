<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Администратор
 * Date: 07.08.13
 * Time: 19:17
 * To change this template use File | Settings | File Templates.
 */

namespace application\models;


use system\basic\BaseModel;

class Drugstores extends BaseModel
{
    public function getList($region = null, $city = null)
    {
    }

    public function getRegions()
    {
        return $this->db->fetchPairs("SELECT alias, title FROM drugstores_regions");
    }

    public function getCities($regionId)
    {
        return $this->db->fetchPairs("SELECT alias, title FROM drugstores_cities WHERE region_id = " . intval($regionId));
    }
}