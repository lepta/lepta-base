<?php
namespace application\helpers;

use application\models\Order;
use system\basic\View;
use system\mailer\Mailer;

class MailingHelper {
    /**
     * @param Order $order
     * @param View $view
     */
    public static function sendOrderMail(Order $order, View $view)
    {
        $orderDate = new \DateTime($order->timestamp, new \DateTimeZone('Europe/Kiev'));
        $order->setExtra('date', $orderDate->format('d.m.Y'));
        $view->assignValue('order', $order->getParams());
        $view->assignValue('productName', $order->getProductName());
        $customerMail = $view->render('mail/customer.html', true);
        $administartorMail = $view->render('mail/administrator.html', true);

		$mailFrom = 'zakaz@' . $order->site;
        $mailer = new Mailer();
        $mailer->IsHTML(true);
        $mailer->CharSet = 'UTF-8';
        $mailer->Subject = 'Заказ №' . $order->id . ' с сайта ' . $order->site;
        $mailer->SetFrom($mailFrom, 'ZAKAZ LEPTADEN');
        $mailer->AddReplyTo($mailFrom);
        $mailer->AddAddress($order->customer_email, $order->customer_name);
        $mailer->MsgHTML($customerMail);
        $mailer->Send();

        $mailer->ClearAddresses();
        $mailer->AddAddress('zakaz@orgpro.com.ua');
        $mailer->AddAddress('registrator73@gmail.com');
        $mailer->AddAddress('goldobin.da@mail.ru');
        $mailer->AddAddress('glazko.a@profilab.com.ua');
        $mailer->AddAddress('kovalskaya.v@orgpro.com.ua');
        $mailer->MsgHTML($administartorMail);
        $mailer->Send();
        return;
    }

    public static function setReviewEmail($site)
    {
        $mailFrom = 'info@' . $site;
        $mailer = new Mailer();
        $mailer->IsHTML(true);
        $mailer->CharSet = 'UTF-8';
        $mailer->Subject = 'Новый отзыв с сайта ' . $site;
        $mailer->SetFrom($mailFrom, 'REVIEW LEPTADEN');
        $mailer->AddReplyTo($mailFrom);
        $mailer->AddAddress('zakaz@orgpro.com.ua');
        $mailer->AddAddress('registrator73@gmail.com');
        $mailer->AddAddress('goldobin.da@mail.ru');
        $mailer->AddAddress('glazko.a@profilab.com.ua');
        $mailer->AddAddress('kuzmenko.m@smartclick.com.ua');
        $mailer->MsgHTML('<p>На сайте ' . $site . ' опублкован новый отзыв. <a href="http://' . $site . '/administrator/index/reviews">Перейти в административную панель</a></p>');
        $mailer->Send();
        return;
    }
}