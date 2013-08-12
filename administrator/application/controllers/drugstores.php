<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Drugstores extends CI_Controller {

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
        $this->load->library('ajax_grocery_CRUD');
        $crud = new ajax_grocery_CRUD();

        $crud->set_table('drugstores');
        $crud->set_relation('brand_id', 'drugstores_brands', 'title');
        $crud->set_relation('city_id', 'drugstores_cities', 'title');
        $crud->set_relation('district_id', 'drugstores_districts', 'title');
        $crud->set_relation_dependency('district_id', 'city_id', 'city_id');
        $crud->set_subject('аптеку');
        $crud->order_by('id', 'desc');
        $crud->display_as('brand_id', 'Сеть аптек');
        $crud->display_as('city_id', 'Город');
        $crud->display_as('district_id', 'Район города');
        $crud->display_as('district', 'Район города');
        $crud->display_as('address', 'Адрес');
        $crud->display_as('add_address1', 'Ориентир 1');
        $crud->display_as('add_address2', 'Ориентир 2');
        $crud->display_as('add_address3', 'Ориентир 3');
        $crud->display_as('phone1', 'Телефон 1');
        $crud->display_as('phone2', 'Телефон 2');
        $crud->display_as('phone3', 'Телефон 3');
        $output = $crud->render();
        $output->baseurl = 'http://' . $_SERVER['SERVER_NAME'] . '/administrator/orders/index';
        $output->siteurl = $output->baseurl . ($site ? '/' .$site : '');
        $this->load->view('drugstores.php', $output);
	}

    public function districts()
    {
        $crud = new grocery_CRUD();

        $crud->set_table('drugstores_districts');
        $crud->set_relation('city_id', 'drugstores_cities', 'title');
        $crud->set_subject('район города');
        $crud->display_as('title', 'Название района');
        $crud->display_as('city_id', 'Город');
        $crud->order_by('id');
        $output = $crud->render();

        $this->load->view('drugstores.php', $output);
    }

    public function cities()
    {
        $crud = new grocery_CRUD();

        $crud->set_table('drugstores_cities');
        $crud->set_relation('region_id', 'drugstores_regions', 'title');
        $crud->set_subject('город');
        $crud->display_as('title', 'Название');
        $crud->display_as('alias', 'Псеводним (для URL)');
        $crud->display_as('region_id', 'Область');
        $crud->order_by('id', 'desc');
        $output = $crud->render();

        $this->load->view('drugstores.php', $output);
    }

    public function regions()
    {
        $crud = new grocery_CRUD();

        $crud->set_language('russian');
        $crud->set_table('drugstores_regions');
        $crud->set_subject('область');
        $crud->unset_columns('alias');
        $crud->fields('title');
        $crud->display_as('title', 'Название');
        $crud->display_as('region_id', 'Область');
        $crud->order_by('id', 'desc');
        $output = $crud->render();

        $this->load->view('drugstores.php', $output);
    }

    public function brands()
    {
        $crud = new grocery_CRUD();

        $crud->set_language('russian');
        $crud->set_table('drugstores_brands');
        $crud->set_subject('сеть аптек');
        $crud->columns('title', 'logo');
        $crud->fields('title', 'logo');
        $crud->set_field_upload('logo', '../userfiles/drugstores/');
        $crud->display_as('title', 'Название');
        $crud->display_as('logo', 'Логотип');

        $output = $crud->render();

        $this->load->view('drugstores.php', $output);
    }

}