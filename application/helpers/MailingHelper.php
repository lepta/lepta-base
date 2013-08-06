<?php
namespace application\helpers;

use application\models\Order;
use system\basic\View;
use system\mailer\Mailer;

class MailingHelper {

    private static $_messageBodyTemplate = '
            Hello {#customerName#}{#nl#}{#nl#}

            Your request for a new password has been received.{#nl#}
            To initiate the password reset process please follow the link below:{#nl#}{#nl#}
            {#restoreLink#}{#nl#}{#nl#}
            If clicking the link above doesn\'t work, please copy and paste the URL in a new browser window instead.{#nl#}
            Note: If you\'ve received this mail in error, it\'s likely that another user entered your email address by mistake while trying to reset a password. If you didn\'t initiate the request, you don\'t need to take any further action and can safely disregard this email.{#nl#}{#nl#}

            If you have any questions, please don\'t hesitate to get in touch.{#nl#}{#nl#}

            Sincerely,{#nl#}
            The PPTStar Support Team,{#nl#}
            {#supportEmail#}';

    /**
     * @param $customerName
     * @param $email
     * @param $key
     * @return bool
     */
    public static function sendPasswordRestoreMail($customerName, $email, $key)
    {
        $mailer = new Mailer();
        $mailer->AddAddress($email);
        $mailer->CharSet = 'UTF-8';
        $mailer->SetFrom('noreply@pptstar.com', 'PPTStar');
        $mailer->Subject = 'Whoops! Let\'s reset your password.';
        $mailer->IsHTML(true);
        $mailer->Body = str_replace(
                            array('{#nl#}', '{#customerName#}', '{#restoreLink#}', '{#supportEmail#}'),
                            array('<br />', $customerName, Url::getProfileUrl('confirmrestore') . 'key/' . $key . '/', 'support@pptstar.com'),
                            self::$_messageBodyTemplate
                        );
        $mailer->AltBody = str_replace(
                            array('{#nl#}', '{#customerName#}', '{#restoreLink#}', '{#supportEmail#}'),
                            array("\r\n", $customerName, Url::getProfileUrl('confirmrestore') . 'key/' . $key . '/', 'support@pptstar.com'),
                            self::$_messageBodyTemplate
                        );

        return $mailer->Send();
    }

    /**
     * @param $name
     * @param $email
     * @param $subject
     * @param $feedback
     * @return bool
     */
    public static function sendFeedbackMail($name, $email, $subject, $feedback)
    {
        $mailer = new Mailer();
        $mailer->AddAddress('feedback@pptstar.com');
        $mailer->CharSet = 'UTF-8';
        $mailer->SetFrom($email, $name);
        $mailer->Subject = $subject;
        $mailer->IsHTML(true);
        $mailer->Body = $feedback;
        $mailer->AltBody = $feedback;

        return $mailer->Send();
    }

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
        $mailer->IsSendmail();
        $mailer->CharSet = 'UTF-8';
        $mailer->Subject = 'Заказ №' . $order->id . ' с сайта ' . $order->site;
        $mailer->SetFrom($mailFrom, 'ZAKAZ LEPTADEN');
        $mailer->AddReplyTo($mailFrom);
        $mailer->AddAddress($order->customer_email, $order->customer_name);
        $mailer->MsgHTML($customerMail);
        $mailer->Send();

        $mailer->ClearAddresses();
        $mailer->AddAddress('kuzmenko.m@smartclick.com.ua');
		/*
        $mailer->AddAddress('registrator73@gmail.com');
        $mailer->AddAddress('glazko.a@profilab.com.ua');
        $mailer->AddAddress('kovalskaya.v@orgpro.com.ua');		
		*/
        $mailer->MsgHTML($administartorMail);
        $mailer->Send();
        return;
    }
}