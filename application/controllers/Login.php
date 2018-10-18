<?php
/**
 * Created by PhpStorm.
 * User: FilipeA
 * Date: 9/30/2018
 * Time: 22:51
 */

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('user');
        $this->load->helper('form');

    }

    public function Index(){
        $this->load->view('/login/login');

    }

    public function Login(){

        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $remember_Me = $this->input->post('remember_Me');

        $login_return = $this->user->login($username, $password, $remember_Me);

        switch ($login_return){
            case LOGIN_SUCCESS:
                redirect('/home');
                break;
            case LOGIN_ERROR_PASSWORD:
                redirect('/login');
                break;
            case LOGIN_ERROR_NON_EXISTENT_USER:
                redirect('/login');
                break;
        }
    }

    public function Logout(){
        $this->user->logout();
        redirect('/login');
    }
}