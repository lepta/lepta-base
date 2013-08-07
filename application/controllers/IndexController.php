<?php
namespace application\controllers;

use application\models\Leptaden;
use application\models\ReviewManager;
use application\models\seo\SeoFactory;
use system\basic\BaseController;

class IndexController extends BaseController {

    public function indexAction()
    {
		$model = new Leptaden();
		$content = $model->getContent();
        $reviewsManager = new ReviewManager();
		$seo = SeoFactory::factory($model);		
		$this->view->assignValue('meta', $seo->getMetaData() );
		$this->view->assignValue('content', $content);
		$this->view->assignValue('reviews', $reviewsManager->getList());
        // for correct menu rendering
        $this->view->assignValue('page', 'index');
        $this->view->render('pages/index.html');
    }
}