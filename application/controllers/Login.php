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
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->user->logout();

    }

    public function Index(){
        $this->load->view('/login/login');

    }

    public function Login(){

        //Define Rules
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[2]|max_length[30]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[30]');

        //If rules are not met
        if(!$this->form_validation->run()){
            $data = [
                'errors' => validation_errors('<span class="form-text text-danger"><i class="icon-cancel-circle2 mr-2"></i>', '</span>')
            ];

            $this->session->set_flashdata($data);
            redirect('/login');
        }

        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $remember_Me = $this->input->post('remember_Me');

        $login_return = $this->user->login($username, $password, $remember_Me);

        switch ($login_return){
            case LOGIN_SUCCESS:
                redirect('/home');
                break;
            case LOGIN_ERROR_PASSWORD:
                $data = [
                    'errors' => '<span class="form-text text-danger"><i class="icon-cancel-circle2 mr-2"></i> Incorrect Password </span>'
                ];

                $this->session->set_flashdata($data);
                redirect('/login');
                break;
            case LOGIN_ERROR_NON_EXISTENT_USER:
                $data = [
                    'errors' => '<span class="form-text text-danger"><i class="icon-cancel-circle2 mr-2"></i> User not found </span>'
                ];

                $this->session->set_flashdata($data);
                redirect('/login');
                break;
        }
    }

    public function Logout(){
        $this->user->logout();
        redirect('/login');
    }
}