<?php
namespace application\controllers;

use application\models\Leptaden;
use application\models\ReviewManager;
use application\models\seo\SeoFactory;
use application\models\seo\SeoLeptaden;
use system\basic\BaseController;
use system\basic\Redirector;

class AdminController extends BaseController {

    public function indexAction()
    {
		$model = new Leptaden();
		$content = $model->getContent();
        $reviewsManager = new ReviewManager();
		$seo = SeoFactory::factory($model);		
		$this->view->assignValue('meta', $seo->getMetaData() );
		$this->view->assignValue('content', $content);
		$this->view->assignValue('reviews', $reviewsManager->getList());
        $this->view->render('layouts/index.html');
    }

    public function loginAction()
    {

    }

    public function savecontentAction()
    {
        $post = $this->getInputSection('post');
        if ($post && $post['content']) {
            foreach ($post['content'] as $contentSection => $contentParams) {

            }
        }
    }

    public function savemetaAction()
    {
        $post = $this->getInputSection('post');
        if ($post) {
            $seo = new SeoLeptaden();
            $seo->findByParams(array('page' => 'leptaden'));
            $seo->meta_title = htmlspecialchars($post['meta_title']);
            $seo->meta_description = htmlspecialchars($post['meta_description']);
            $seo->meta_keywords = htmlspecialchars($post['meta_keywords']);
            $seo->meta_robots = htmlspecialchars($post['meta_robots']);
            $seo->update();
        }
        Redirector::redirect('/admin/');
    }

    public function savereviewAction()
    {

    }

    public function deletereviewAction()
    {
        $post = $this->getInputSection('post');
        if ($post && $post['reviewId']) {

        }
    }
}