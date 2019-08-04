<?php
/**
 * Created by PhpStorm.
 * User: FilipeA
 * Date: 9/30/2018
 * Time: 22:51
 */

class API extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('user');
    }

    public function Index(){
    }

    public function OR_BOOK(){

        if(!isset( $_POST['data'])) {
            die();
        }else{
            $arr = $_POST['data'];


            if($this->user->validates_user_by_token($arr['token']) != AUTHENTICATION_SUCCESS){die();}



            if( !(in_array(AUTH_PERMISSIONS_EDIT_BASIC_BOOKING, $this->user->get_permissions()) ||
                in_array(AUTH_PERMISSIONS_EDIT_FULL_BOOKING, $this->user->get_permissions())) ){die();}



            if(!is_numeric($arr['codFunc'])){die;}
            if(!isset($this->db->get_where('Users', array('User_ID=' => $arr['codFunc']))->row()->Username)){die;}

            header('Content-type: application/json');
            $response = array();
            $response['success'] = 0;
            $response['general_message'] = 0;
            $response['errors']  = 0;

            exit(json_encode($response));
        }
    }

    public function OR_STATE(){

        if(!isset( $_POST['data'])) {
            die();
        }else{
            $arr = $_POST['data'];

            if($this->user->validates_user_by_token($arr['token']) != AUTHENTICATION_SUCCESS){die();}
            if( !(in_array(AUTH_PERMISSIONS_EDIT_BASIC_BOOKING, $this->user->get_permissions()) ||
                in_array(AUTH_PERMISSIONS_EDIT_FULL_BOOKING, $this->user->get_permissions()) )){die();}

            if(!is_numeric($arr['codFunc'])){die;}
            if(!isset($this->db->get_where('Users', array('User_ID=' => $arr['codFunc']))->row()->Username)){die;}

            header('Content-type: application/json');
            $response = array();
            $response['success'] = 0;
            $response['general_message'] = 0;
            $response['errors']  = 0;
            $data = array(
                'OR_ID' => $arr['orID'],
                'State_ID' => $arr['stateID'],
                'User_ID'=> $arr['codFunc']
            );

            $this->db->insert('OR_State', $data);

            exit(json_encode($response));
        }
    }



}