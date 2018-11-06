<?php
/**
 * Created by PhpStorm.
 * User: FilipeA
 * Date: 11/2/2018
 * Time: 11:11
 */

class Booking extends AUTH_Controller
{
    public function __construct()
    {
        // REQUIRED ----------------------------------------------------------------------------------------------------
        parent::__construct();
        $this->set_ControllerName('Booking');
        $this->set_ParentPath(site_url('r/booking'));
        $this->set_ParentPathName('Booking');
        //--------------------------------------------------------------------------------------------------------------
        //This Controller requires a sideBar Menu
        $this->load->library('navigation_menu');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    public function index(){
        // REQUIRED ----------------------------------------------------------------------------------------------------
        $this->set_CurrentMethod('Home');
        $this->set_group();
        $this->set_permissions(['View']);
        if($this->access_check()== AUTHENTICATION_ERROR){
            redirect('/login');
        }
        //--------------------------------------------------------------------------------------------------------------

        if($this->belongs_group('Admin')){
            $this->add_data("Admin", 'group');
            echo $this->load->view('dashboard/booking/admin/index', $this->get_data(), true);
            die();
        }else{
            echo "User is not admin, please contact this website developer";
        }
    }
    public function book(){
        // REQUIRED ----------------------------------------------------------------------------------------------------
        $this->set_CurrentMethod('Novo Booking');
        $this->set_group();
        $this->set_permissions(['Add']);
        if($this->access_check()== AUTHENTICATION_ERROR){
            redirect('/login');
        }
        //--------------------------------------------------------------------------------------------------------------

        if($this->belongs_group('Admin')){
            $this->add_data("Admin", 'group');
            echo $this->load->view('dashboard/booking/admin/book', $this->get_data(), true);
            die();
        }else{
            echo "User is not admin, please contact this website developer";
        }
    }

    private function add(){

    }

}