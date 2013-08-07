<?php
namespace application\controllers;

use application\models\Drugstores;
use application\models\DrugstoresValidator;
use system\basic\BaseController;

class DrugstoresController extends BaseController
{
    public function indexAction()
    {
        $region = $this->getParam('region', null);
        $city = $this->getParam('city', null);

        $this->view->assignValue('region', $region);
        $this->view->assignValue('city', $city);
        $this->view->render('pages/drugstores.html');
    }

    public function getCitiesAction()
    {
        $regionAlias = $this->getParam('region');
        $validator = new DrugstoresValidator();
        $validator->validate('region', $regionAlias);
        if ($validator->isValid()) {
            $drugstores = new Drugstores();
            $cities = $drugstores->getCities($regionAlias);
            if ($cities) {
                $result = array('result' => 1, 'data' => $cities);
            } else {
                $result = array('result' => 0, 'data' => array());
            }
        } else {
            $result = array('result' => 0, 'data' => $validator->getLastError()->getMessage() );
        }

        $this->getResponse()->setOutput(json_encode($result), 'json');
    }
}