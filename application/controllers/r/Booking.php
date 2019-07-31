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

    public function add(){

        $data = $this->input->post();

        if(empty($data)){
            redirect('r/booking/book', 'refresh');
        }
        // Loads to control variables
        //--------------------------------------------------------------------------------------------------------------
        $client['name'] = $data['cliente_nome'];
        $client['email'] = $data['cliente_email'];
        $client['phone'] = str_replace("-", "", $data['cliente_telemovel']);

        //--------------------------------------------------------------------------------------------------------------
        $or['state'] = $data['or_estado'];
        $or['type'] = $data['or_tipo'];
        //--------------------------------------------------------------------------------------------------------------
        switch($or['state']){
            case '1':
                $repair['schedule_to_date'] = $data['or_data_entrega'];
                break;
            case '2':
                $repair['schedule_to_date'] = date("d/m/y");
                break;
        }
        $repair['device'] = $data['tipo'];
        $repair['brand'] = $data['marca'];
        $repair['model'] = $data['modelo'];
        $repair['color'] = $data['cor'];
        $repair['imei'] = $data['imei'];
        $repair['acessories'] = empty($data['acessorios']) ? '' : implode(",",$data['acessorios']);
        $repair['desc'] = $data['obs_equipamento'];
        $repair['obs'] = $data['obs_or'];
        $repair['price'] = $data['or_valor'];
        switch ($data['codeType']){
            case 'none':
                $repair['Unlock_Code'] = "s/ codigo";
                break;
            case 'alphanumeric':
                $repair['Unlock_Code'] = "codigo: " . $data['cod_bloqueio'];
                break;
            case 'pattern':
                $repair['Unlock_Code'] = "padrao: " . $data['password'];
                break;
        }

        // Loads to DB
        //--------------------------------------------------------------------------------------------------------------

        //Checks if client exists (otherwise inserts)
        $query = $this->db->get_where('Clients', $client);
        if(!$query->num_rows()){
            $this->db->insert('Clients', $client);
            $client['ID'] = $this->db->insert_id();
        }else{
            $client['ID'] = $query->row()->Client_ID;
        }
        //Create OR
        $this->db->insert('ORs', array('Client_ID' => $client['ID'],
                                        'Type_ID' => $or['type']));
        $repair['OR_ID'] = $this->db->insert_id();
        $repair['User_ID'] = $this->user->get_userID();

            //OR state
        $this->db->insert('OR_State', array('OR_ID' =>  $repair['OR_ID'],
                                            'State_ID'=>   $or['state'],
                                            'User_ID' => $repair['User_ID']));

        //todo: email this shit? helper class? libraries? model?


        $this->db->insert('Repair_Info', $repair);

        redirect('r/booking/details/'. $repair['OR_ID'], 'refresh');
    }

    public function details($OR_ID = 0){
        if(!$OR_ID){
            redirect('r/booking/book', 'refresh');
        }

    }

}