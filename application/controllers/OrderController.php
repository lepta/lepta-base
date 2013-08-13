<?php
namespace application\controllers;

use application\helpers\MailingHelper;
use application\helpers\Url;
use application\models\Order;
use application\models\OrderValidator;
use system\basic\BaseController;
use system\basic\Config;
use system\basic\Redirector;
use system\basic\exceptions\AccessException;
use system\basic\exceptions\BaseException;
use system\basic\exceptions\WrongInputParamsException;

class OrderController extends BaseController
{

    public function storeAction()
    {
        $post = $this->getInputSection('post');
        if ($post) {
            $validator = new OrderValidator();
            $validator->validate('site', $post['site'])
                ->validate('items_amount', $post['items_amount'])
                ->validate('items_price', $post['items_price'])
                ->validate('discount', $post['discount'])
                ->validate('customer_name', $post['customer_name'])
                ->validate('customer_phone', $post['customer_phone'])
                ->validate('customer_email', $post['customer_email'])
                ->validate('shipment_method', $post['shipment_method'])
                ->validate('shipment_city', $post['shipment_city'])
                ->validate('shipment_street', $post['shipment_street'])
                ->validate('shipment_building', $post['shipment_building'])
                ->validate('shipment_apartment', $post['shipment_apartment'])
                ->validate('payment_method', $post['payment_method']);
            if ($validator->isValid()) {
                $order = new Order();
                if (/*$order->checkReferrer($_SERVER['HTTP_REFERER']) && */$order->store($post)) {
                    MailingHelper::sendOrderMail($order, $this->view);
                    $this->view->assignValue('base_domain', Url::getMainUrl());
                    $this->view->render('layouts/order.html');
                } else {
                    throw new BaseException('Error occured while storing the order', 503);
                }
            } else {
                //throw new WrongInputParamsException('order data is invalid', 503);
                $this->view->assignValue('base_domain', Config::getSectionParam('general', 'base_domain'));
                $this->view->render('layouts/order.html');
            }
        } else {
            throw new AccessException('Access denied', 403);
        }
    }
}