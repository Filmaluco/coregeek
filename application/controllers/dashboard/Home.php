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
        //Set Controller overall permissions
            //Group Permissions

        //This Controller requires a sideBar Menu
        $this->load->library('Navigation_Menu');
    }

    public function Index(){
        $this->load->view('dashboard/home/index/admin_index', $this->get_data());
    }

}