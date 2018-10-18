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
        $this->user->login('CoreGeek', ':2GeekCore18:', true);
        redirect('/home');
    }
}