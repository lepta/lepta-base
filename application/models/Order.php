<?php
namespace application\models;

use system\db\ActiveRecord;

/**
 * Class Order
 * @package application\models
 */
class Order extends ActiveRecord
{
    /**
     * @var array
     */
    protected $_allowedReferrerers = array('leptaden.com.ua');

    protected $_products = array('leptaden.com.ua' => 'Лептаден');

    protected $_shipmentMethods = array(
                                    'courier' => 'Курьером по Киеву',
                                    'ukrpost' => 'Укрпочта',
                                    'newpost' => 'Новая почта'
                                 );

    /**
     * @var string
     */
    protected $_table = 'orders';

    /**
     * @param array $orderData
     * @return mixed
     */
    public function store(array $orderData)
    {
        $this->site = htmlspecialchars($orderData['site']);
        $this->items_amount = (int)$orderData['items_amount'];
        $this->items_price = (float)$orderData['items_price'];
        $this->discount = $this->calculateDiscount( $this->items_amount );
        $total = $orderData['items_amount'] * $orderData['items_price'];
        $totalWithDiscount = (float)$total  - (float)$total * $this->discount / 100;
        $this->items_total = $totalWithDiscount;
        $this->customer_name = htmlspecialchars($orderData['customer_name']);
        $this->customer_phone = htmlspecialchars($orderData['customer_phone']);
        $this->customer_email = htmlspecialchars($orderData['customer_email']);
        $this->shipment_city = htmlspecialchars($orderData['shipment_city']);
        $this->shipment_street = htmlspecialchars($orderData['shipment_street']);
        $this->shipment_building = htmlspecialchars($orderData['shipment_building']);
        $this->shipment_apartment = htmlspecialchars($orderData['shipment_apartment']);
        $this->payment_method = htmlspecialchars($orderData['payment_method']);

        if (array_key_exists($orderData['shipment_method'], $this->_shipmentMethods)) {
            $this->shipment_method = $this->_shipmentMethods[$orderData['shipment_method']];
        } else {
            $this->_shipmentMethods = NULL;
        }

        $result = $this->insert(true);
        if ($result) {
            $this->setExtra('totalWithoutDiscount', $total);
            $this->setExtra('discountSum', sprintf('%.2f', $total * $this->discount / 100));
        }

        return $result;
    }

    /**
     * @param $referrer
     * @return bool
     */
    public function checkReferrer($referrer)
    {
        if (array_search(strtolower($referrer), $this->_allowedReferrerers) !== false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return string
     */
    public function getProductName()
    {
        if (array_key_exists($this->site, $this->_products)) {
            return $this->_products[$this->site];
        } else {
            return '';
        }
    }

    /**
     * @param $itemsAmount
     * @return int
     */
    public function calculateDiscount($itemsAmount)
    {
        if ($itemsAmount > 0 && $itemsAmount < 2) {
            return 0;
        } else if ($itemsAmount >= 2 && $itemsAmount < 6) {
            return 5;
        } else if ($itemsAmount >= 6 && $itemsAmount < 11) {
            return 10;
        } else if ($itemsAmount >= 20) {
            return 15;
        }
    }
}