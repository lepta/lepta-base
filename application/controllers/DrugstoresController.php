<?php
namespace application\controllers;

use application\helpers\Url;
use application\models\DrugstoreCity;
use application\models\DrugstoreRegion;
use application\models\Drugstores;
use system\basic\BaseController;
use system\basic\exceptions\WrongInputParamsException;

class DrugstoresController extends BaseController
{
    /**
     * renders drugstores page
     */
    public function indexAction()
    {
        //$regionAlias = $this->getParam('region', 'kiev-region');
        $cityAlias = $this->getParam('city', 'kiev');

        //$region = new DrugstoreRegion();
        //$region->findByParams(array('alias' => $regionAlias));

        $city = new DrugstoreCity();
        $city->findByParams(array('alias' => $cityAlias));

        if ($city->isVoid()) {
            throw new WrongInputParamsException('Wrong input city alias', 404);
        }
        $drugstores = new Drugstores();

        $this->view->assignValue('drugstores', $drugstores->getList($city->id) );
        $this->view->assignValue('regions', $drugstores->getRegions() );
        $this->view->assignValue('cities', $drugstores->getCities($city->region_id) );
        $this->view->assignValue('cityAlias', $cityAlias);
        $this->view->assignValue('regionId', $city->region_id);
        $this->view->render('pages/drugstores.html');
    }

    /**
     * returns list of cities tied to this region
     */
    public function getCitiesAction()
    {
        $input = $this->getInputSection('post');
        $regionId = intval($input['region']);

        $region = new DrugstoreRegion();
        $region->find($regionId);
        if (!$region->isVoid()) {
            $drugstores = new Drugstores();
            $cities = $drugstores->getCities($region->id);
            if ($cities) {
                $result = array('result' => 1, 'data' => $cities);
            } else {
                $result = array('result' => 0, 'data' => array());
            }
        } else {
            $result = array('result' => 0, 'data' => 'Invalid region identifier');
        }

        $this->getResponse()->setOutput(json_encode($result), 'json');
    }

    /**
     * prepares the redirect url for the page
     */
    public function getRedirectUrlAction()
    {
        $post = $this->getInputSection('post');
        $cityAlias = htmlspecialchars($post['city']);

        $this->getResponse()->setOutput(json_encode(array('result' => 1, 'data' => Url::getDrugstoresUrl($cityAlias))), 'json');
    }
}