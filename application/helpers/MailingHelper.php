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
        $mailer->AddAddress('kuzmenko.m@smartclick.com.ua');
        $mailer->MsgHTML($administartorMail);
        $mailer->Send();
        return;
    }
}