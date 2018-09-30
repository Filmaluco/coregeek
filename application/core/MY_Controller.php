<?php
/**
 * Created by PhpStorm.
 * User: FilipeA
 * Date: 9/30/2018
 * Time: 22:47
 */

class MY_Controller extends CI_Controller
{
    public function __construct() {
        parent::__construct();
    }
}

class AUTH_Controller extends MY_Controller{

    public function __construct() {
        parent::__construct();

        $this->load->library('CORE_auth');
    }

}