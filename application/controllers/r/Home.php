<?php
/**
 * Created by PhpStorm.
 * User: FilipeA
 * Date: 9/30/2018
 * Time: 22:53
 */

class Home extends AUTH_Controller
{

    public function __construct()
    {
        parent::__construct();
        //This Controller requires a sideBar Menu
        $this->load->library('navigation_menu');
        $this->load->helper('cookie');

        // REQUIRED ----------------------------------------------------------------------------------------------------
        $this->set_ControllerName('Home');
        $this->set_ParentPath(site_url('r/home'));
        $this->set_ParentPathName('Home');
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

        if($this->belongs_group('Admin')){
            $this->add_data("Admin", 'group');
            echo $this->load->view('dashboard/home/admin/index', $this->get_data(), true);
            die();
        }else{
            echo "User is not admin, please contact this website developer";
        }

    }

}