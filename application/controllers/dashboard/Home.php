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
            //TODO:: set Group Acess
            //TODO:: check user Group

        //This Controller requires a sideBar Menu
        $this->load->library('Navigation_Menu');
        $this->load->helper('cookie');

    }

    public function Index(){
        //TODO:: Check permission View
        $this->load->view('dashboard/home/index/admin_index', $this->get_data());

        //$hash = \password_hash(':2GeekCore18:', PASSWORD_DEFAULT);
        //echo 'HASH: '. $hash . '</br>';
    }

}