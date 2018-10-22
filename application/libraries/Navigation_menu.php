<?php
/**
 * Created by PhpStorm.
 * User: FilipeA
 * Date: 10/10/2018
 * Time: 22:30
 */

class Navigation_Menu
{
    protected $CI;

    // We'll use a constructor, as you can't directly call a function
    // from a property definition.
    public function __construct()
    {
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
    }

    public function admin_menu(){
        return $this->CI->load->view('nav_menus/nav_menu_admin.php','',true);
    }

    public function default_menu(){
        return $this->CI->load->view('nav_menus/nav_menu_default.php','',true);
    }

}
