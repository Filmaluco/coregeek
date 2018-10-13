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

    //Basic information to pass the view
    protected $controller_Name = "notDefined";
    protected $current_Method= "notDefined";
    protected $parent_Path_Name = "notDefined";
    protected $parent_Path = "#";

    //Data that is passed to the views;
    protected $data;

    public function __construct() {
        parent::__construct();
        $this->load->library('user');

        //Set basic data to the view
        $this->data = array(
            'controller_Name' => $this->controller_Name,
            'current_Method' => $this->current_Method,
            'parent_Path_Name' => $this->parent_Path_Name,
            'parent_Path' => $this->parent_Path,
            'username' => $this->user->getUserName(),
            'user_NumberOfNotifications' => $this->user->getNumberOfNotifications()
        );

        //TODO:: add user permissions canEdit ...

    }

    /**
     * @param $var = value of the data we pretend to add to the view
     * @param string $key = name of the variable (ex: $key)
     */
    public function add_data($var, $key = 'default'){
        if(is_array($var)){
           $this->data = array_merge($this->data, $var);
        } else{
            $this->data[$key] = $var;
        }
    }

    /**
     * @return array
     * Returns all the data contained in the array
     */
    public function get_data(){
        return $this->data;
    }

}