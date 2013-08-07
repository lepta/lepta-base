<?php
namespace application\controllers;

use system\basic\BaseController;

class DrugstoresController extends BaseController
{
    public function indexAction()
    {
        $region = $this->getParam('region', null);
        $city = $this->getParam('city', null);

        $this->view->render('pages/drugstores.html');
    }
}