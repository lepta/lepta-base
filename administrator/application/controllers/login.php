<?php
class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }
    
    public function index()
    {
        $messages = array();
        // check if there
        $login = $this->input->post('adminlogin');
        $pass = $this->input->post('adminpass');
        if ($login && $pass) {
            if ($this->User_model->login($login, $pass)) {
                header('Location: /administrator/orders/index/all');
                exit();
            } else {                
                $messages[] = "Wrong password. Try again";
            }
        }
        $this->load->view('login.php', array('messages' => $messages));
    }
    
    public function logout()
    {
        $this->User_model->logout();
        header('Location: /administrator/login');
        exit();
    }
}