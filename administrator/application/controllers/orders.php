<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('grocery_CRUD');
        $this->load->model('User_model');
        if (!$this->User_model->isLogged()) {
            header('Location: /administrator/login');
        }
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
            $crud->display_as('shipment_city', 'Город');
            $crud->display_as('shipment_street', 'Улица');
            $crud->display_as('shipment_building', 'Здание');
            $crud->display_as('shipment_apartment', 'Квартира/офис');
            $crud->display_as('site', 'Сайт');
            $crud->display_as('status', 'Статус заказа');
            if (!empty($site) && $site != 'all') {
                $crud->where('site', htmlspecialchars($site));
            }
            if (!empty($status) && array_key_exists($status, $statuses)) {
                $crud->where('status', $statuses[$status]);
            }
            $crud->order_by('id', 'desc');
            $output = $crud->render();
            $output->baseurl = 'http://' . $_SERVER['SERVER_NAME'] . '/administrator/orders/index';
            $output->siteurl = $output->baseurl . ($site ? '/' .$site : '');
            $this->load->view('orders.php', $output);
	}

}