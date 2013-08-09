<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('grocery_CRUD');
        $this->load->model('User_model');
        if (!$this->User_model->isLogged()) {
            header('Location: /administrator/login');
            exit();
        }
	}
	
	function _example_output($output = null)
	{
		$this->load->view('index.php',$output);
	}

	function index()
	{
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}	
	
	function content()
	{
        $crud = new grocery_CRUD();

        $crud->set_language('russian');
        $crud->set_table('content');
        $crud->set_subject('контент');
        $crud->field_type('text', 'text');
        $crud->unset_columns('section', 'alias');
        $crud->unset_edit_fields('section', 'alias');
        $crud->display_as('title', 'Заголовок раздела');
        $crud->display_as('text', 'Текст раздела');

        $output = $crud->render();

        $this->_example_output($output);
	}
	
	function meta()
	{
        $crud = new grocery_CRUD();

        $crud->set_table('seo');
        $crud->set_subject('Мета данные');
        $crud->field_type('meta_description', 'text');
        $crud->unset_texteditor('meta_description');
        $crud->unset_edit_fields('page');
        $crud->unset_columns('page');
        $crud->display_as('meta_title', 'Мета title');
        $crud->display_as('meta_description', 'Мета description');
        $crud->display_as('meta_keywords', 'Мета keywords');
        $crud->display_as('meta_robots', 'robots');

        $output = $crud->render();

        $this->_example_output($output);
	}
	
	function reviews()
	{
        $crud = new grocery_CRUD();

        $crud->set_table('reviews');
        $crud->set_subject('отзыв');
        $crud->field_type('text', 'text');
        $crud->unset_edit_fields('author_name');
        $crud->unset_columns('author_name');
        $crud->set_field_upload('img', '../userfiles/reviews/');
        $crud->display_as('text', 'Текст отзыва');
        $crud->display_as('img', 'Изображение');

        $output = $crud->render();

        $this->_example_output($output);
	}

    function faq()
    {
        $crud = new grocery_CRUD();

        $crud->set_table('faq');
        $crud->set_subject('вопрос/ответ');
        $crud->display_as('question', 'Текст вопроса');
        $crud->display_as('answer', 'Текст ответа');
        $crud->display_as('is_visible', 'Состояние');

        $output = $crud->render();

        $this->_example_output($output);
    }
}