<?php
namespace application\models;


use system\basic\BaseModel;
use system\basic\exceptions\WrongInputParamsException;

/**
 * Class Drugstores
 * @package application\models
 */
class Drugstores extends BaseModel
{
    /**
     * @param $cityId
     * @return array
     * @throws \system\basic\exceptions\WrongInputParamsException
     */
    public function getList($cityId)
    {
        if (empty($cityId)) {
            throw new WrongInputParamsException('Drugstores::getList expects regionId and cityId to be not null');
        }

        $list = $this->db->fetchAll(
                            "SELECT
                                d.id,
                                b.title as title,
                                b.logo,
                                d.district,
                                d.address,
                                d.phone
                            FROM drugstores d
                            INNER JOIN drugstores_brands b ON (b.id = d.brand_id)
                            INNER JOIN drugstores_cities c ON (c.id = d.city_id)
                            WHERE c.id = " . intval($cityId)
                        );
        if ($list) {
            $resultList = array();
            foreach($list as $listItem) {
                $key = !empty($listItem['district']) ? $listItem['district'] : 'none';
                $resultList[$key][] = $listItem;
            }
            return $resultList;
        } else {
            return array();
        }
    }

    /**
     * @return mixed
     */
    public function getRegions()
    {
        return $this->db->fetchPairs("SELECT alias, title FROM drugstores_regions");
    }

    /**
     * @param $regionId
     * @return mixed
     */
    public function getCities($regionId)
    {
        return $this->db->fetchPairs("SELECT alias, title FROM drugstores_cities WHERE region_id = " . intval($regionId));
    }
}