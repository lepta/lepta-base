<?php
namespace application\controllers;

use application\helpers\Url;
use application\models\Review;
use application\models\ReviewValidator;
use system\basic\BaseController;
use system\basic\Config;
use system\basic\Redirector;
use system\basic\Session;
use system\captcha\Captcha;

class ReviewController extends BaseController
{
    public function captchaAction()
    {
        $captcha = new Captcha(Config::getSection('captcha'));
        $this->_app->getResponse()->setHeader('Content-type: image/png', true);
        Session::set('captcha', $captcha->getCode());
        $captcha->render();
    }

    public function addAction()
    {
        $post = $this->getInputSection('post');
        $reviewValidator = new ReviewValidator();
        $reviewValidator->validate('author_age', $post['author_age'])
            ->validate('would_recommend', $post['would_recommend'])
            ->validate('captcha', $post['captcha']);

        if (/*$reviewValidator->isValid() && */$post['captcha'] === Session::get('captcha')) {
            $review = new Review();
            $review->author_name = htmlspecialchars($post['author_name']);
            $review->author_age  = intval($post['author_age']);
            $review->problem_description = htmlspecialchars($post['description']);
            $review->problem_solution = htmlspecialchars($post['solution']);
            $review->would_recommend = $post['would_recommend'];
            $review->setAvatar();
            $review->insert();
            Redirector::redirect(Url::getMainUrl('reviewSuccess'));
        } else {
            Redirector::redirect(Url::getMainUrl('reviewError'));
        }
    }
}