<?php
/**
 * Class User_model
 */
class User_model extends CI_Model {

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }
    /**
     * @param $pass
     * @return bool
     */
    public function login($login, $pass) {
        if ($login === 'leptaden' && $pass === 'leptaden123') {
            $userdata = array('isLogged' => true);
            $this->session->set_userdata($userdata);
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * @return bool
     */
    public function logout() {
        $userdata = array('isLogged' => false);
        $this->session->unset_userdata($userdata);
        if ($this->isLogged()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @return bool
     */
    public function isLogged() {
        $isLogged = $this->session->userdata("isLogged");
        if (!$isLogged) {
            return false;
        } else {
            return true;
        }
    }
}