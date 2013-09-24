<?php
namespace application\models;


class OrderValidator extends Validator
{
    protected $_validationRules = array(
        'site' => array(
            'value' => array(
                'range' => array(
                    'leptaden.com.ua'
                )
            )
        ),

        'items_amount' => array(
            'numeric',
            'value' => array(
                '>=' => 1
            )
        ),

        'items_price' => array(
            'not_empty'
        ),

        'discount' => array(
            'numeric',
            'value' => array(
                '<=' => 5
            )
        ),

        'customer_name' => array(
            'not_empty',
        ),

        'customer_phone' => array(
            'not_empty',
        ),

        'customer_email' => array(
            'email'
        ),

        'shipment_city' => array(
            'not_empty'
        ),

        'shipment_street' => array(
            'not_empty'
        ),

        'shipment_building' => array(
            'not_empty'
        ),

        'shipment_apartment' => array(
            'not_empty'
        ),

        'payment_method' => array(
            'value' => array(
                'range' => array('Наличными', 'Безналичный расчет'),
                '_message' => 'Неверно указан способ оплаты'
            )
        )
    );
}