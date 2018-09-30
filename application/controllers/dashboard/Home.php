<?php
/**
 * Created by PhpStorm.
 * User: FilipeA
 * Date: 9/30/2018
 * Time: 22:53
 */

class Home extends AUTH_Controller
{

    public function Index(){
        $this->load->view('dashboard/home/index');
    }

}