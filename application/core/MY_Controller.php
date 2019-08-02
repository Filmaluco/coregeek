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
    protected $parent_Path = "";

    protected $required_groups = array();
    protected $required_permissions = array();

    //Data that is passed to the views;
    protected $data;

    public function __construct() {
        parent::__construct();
        $this->load->library('user');
        $this->load->helper('cookie');


        if($this->user->authenticate() == AUTHENTICATION_ERROR){
            redirect('/login');
        }

        //Set basic data to the view
        $this->data = array(
            'controller_Name' => $this->controller_Name,
            'current_Method' => $this->current_Method,
            'parent_Path_Name' => $this->parent_Path_Name,
            'parent_Path' => $this->parent_Path,
            'username' => $this->user->get_userName(),
            'user_nr_notifications' => $this->user->get_nr_notifications(),
            'last_notifications' => $this->user->get_last_notifications(),
            'store_name' => $this->user->get_store_name()
        );

    }

    /**
     * @param $var = value of the data we pretend to add to the view
     * @param string $key = name of the variable (ex: $key)
     *
     * if $var is of type array will merge both the arrays, therefore there's no need to specify a $key
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

    /**
     * @param string $controller_Name
     */
    public function set_ControllerName($controller_Name)
    {
        $this->controller_Name = $controller_Name;
        $this->data['controller_Name'] = $controller_Name;
    }

    /**
     * @param string $current_Method
     */
    public function set_CurrentMethod($current_Method)
    {
        $this->current_Method = $current_Method;
        $this->data['current_Method'] = $current_Method;
    }

    /**
     * @param string $parent_Path_Name
     */
    public function set_ParentPathName($parent_Path_Name)
    {
        $this->parent_Path_Name = $parent_Path_Name;
        $this->data['parent_Path_Name'] = $parent_Path_Name;
    }

    /**
     * @param string $parent_Path
     */
    public function set_ParentPath($parent_Path)
    {
        $this->parent_Path = $parent_Path;
        $this->data['parent_Path'] = $parent_Path;
    }


    /**
     * @param $group_name
     * @return bool
     */
    public function belongs_group($group_name){
        return in_array($group_name, $this->user->get_groups());
    }

    /**
     * @param $var
     * will always clear the previous groups
     */
    public function set_group($var = array()){
        $this->required_groups = array();
        if(is_array($var)){
            $this->required_groups = array_merge($this->required_groups, $var);
        } else{
           array_push( $this->required_groups, $var);
        }
    }

    /**
     * @param $var
     * will always clear the previous permissions
     */
    public function set_permissions($var = array()){
        $this->required_permissions = array();
        if(is_array($var)){
            $this->required_permissions = array_merge($this->required_permissions, $var);
        } else{
            array_push( $this->required_permissions, $var);
        }
    }

    /**
     * @return int
     *          AUTHENTICATION_SUCCESS
     *          AUTHENTICATION_ERROR
     */
    public function access_check(){
        $flag = 0;

        //Checks if Groups are required
        if (empty($this->required_groups)){
            $flag = 1;
        }

        //If required groups
        if(!$flag){
            // Check if the User belongs to any required group
            foreach ($this->user->get_groups() as $group){
                if(in_array($group, $this->required_groups)){
                    $flag = 1;
                    break;
                }
            }
        }

        // Doesn't belong to any required group
        if(!$flag){
          return AUTHENTICATION_ERROR;
        }

        $flag = 0;

        //Check if requires any permissions
        if (empty($this->required_permissions)){
            $flag = 1;
        }

        //If requires permissions
        if(!$flag){
            // Check if the User belongs to any required group
            foreach ($this->user->get_permissions() as $permission){
                if(in_array($permission, $this->required_permissions)){
                    $flag = 1;
                    break;
                }
            }
        }

        if($flag){
           return AUTHENTICATION_SUCCESS;
        }// Else

        return AUTHENTICATION_ERROR;
    }


}