<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->database();
		$this->load->helper('url');
		
		$this->load->library('grocery_CRUD');	
	}

	function index($site = null, $status = null)
	{
        $statuses = array(
            'new' => 'Новый заказ',
            'delivered_unpaid' => 'Доставлен, не оплачен',
            'delivered_paid' => 'Доставлен, оплачен',
            'undelivered_paid' => 'Оплачен, не доставлен',
            'confirmed' => 'Подтверждён, выполняется'
        );
			$crud = new grocery_CRUD();

            $crud->set_language('russian');
			$crud->set_table('orders');
			$crud->set_subject('заказ');
            $crud->columns('id', 'timestamp', 'customer_name', 'customer_phone', 'customer_email', 'shipment_city', 'shipment_street', 'shipment_building', 'shipment_apartment', 'items_price', 'items_amount', 'shipment_method', 'site', 'status');
            $crud->fields('id', 'customer_name', 'customer_phone', 'items_total', 'shipment_method', 'shipment_city', 'shipment_street', 'shipment_building', 'shipment_apartment', 'status');
            $crud->display_as('id', 'Номер заказа');
            $crud->display_as('timestamp', 'Дата');
            $crud->display_as('customer_name', 'Имя');
            $crud->display_as('customer_phone', 'Телефон');
            $crud->display_as('customer_email', 'Email');
            $crud->display_as('items_price', 'Цена');
            $crud->display_as('items_amount', 'Количество');
            $crud->display_as('shipment_method', 'Способ доставки');
            $crud->display_as('shipment_city', '&#1043;&#1086;&#1088;&#1086;&#1076;');
            $crud->display_as('shipment_street', '&#1059;&#1083;&#1080;&#1094;&#1072;');
            $crud->display_as('shipment_building', '&#1044;&#1086;&#1084;');
            $crud->display_as('shipment_apartment', '&#1054;&#1092;&#1080;&#1089;/&#1082;&#1074;&#1072;&#1088;&#1090;&#1080;&#1088;&#1072;');
            $crud->display_as('site', 'Сайт');
            $crud->display_as('status', 'Статус заказа');
            if (!empty($site) && $site != 'all') {
                $crud->where('site', htmlspecialchars($site));
            }
            if (!empty($status) && array_key_exists($status, $statuses)) {
                $crud->where('status', $statuses[$status]);
            }
            $output = $crud->render();
            $output->baseurl = 'http://' . $_SERVER['SERVER_NAME'] . '/administrator/orders/index';
            $output->siteurl = $output->baseurl . ($site ? '/' .$site : '');
            $this->load->view('orders.php', $output);
	}

}