<?php
/**
 * Created by PhpStorm.
 * User: FilipeA
 * Date: 9/30/2018
 * Time: 22:53
 */

class Profile extends AUTH_Controller
{

    public function __construct()
    {
        parent::__construct();
        //This Controller requires a sideBar Menu
        $this->load->library('navigation_menu');
        $this->load->helper('cookie');
        $this->load->helper('form');
        $this->load->library('form_validation');

        // REQUIRED ----------------------------------------------------------------------------------------------------
        $this->set_ControllerName('User');
        $this->set_ParentPath(site_url('r/user'));
        $this->set_ParentPathName('User');
        //--------------------------------------------------------------------------------------------------------------

    }

    public function Index(){

        // REQUIRED ----------------------------------------------------------------------------------------------------
        $this->set_CurrentMethod('Home');
        $this->set_group();
        $this->set_permissions();
        if($this->access_check()== AUTHENTICATION_ERROR){
            redirect('/login');
        }
        //--------------------------------------------------------------------------------------------------------------

        echo $this->load->view('dashboard/profile/index', $this->get_data(), true);

    }

    public function Lockout(){

        // REQUIRED ----------------------------------------------------------------------------------------------------
        $this->set_CurrentMethod('Home');
        $this->set_group();
        $this->set_permissions();
        if($this->access_check()== AUTHENTICATION_ERROR){
            redirect('/login');
        }
        //--------------------------------------------------------------------------------------------------------------

        echo $this->load->view('dashboard/profile/lockout', $this->get_data(), true);

    }

}