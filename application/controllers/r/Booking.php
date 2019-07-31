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
        //ORData already loads this 2:
        //$this->load->model('Client');
        //$this->load->model('Repair');
        //--
        $this->load->model('ORData');

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
        $client = new Client();
        $client->create_client( $data['cliente_nome'],
                                $data['cliente_email'], str_replace("-", "",
                                $data['cliente_telemovel']));
        //--------------------------------------------------------------------------------------------------------------
        $or_state = $data['or_estado'];
        $or_type = $data['or_tipo'];
        //--------------------------------------------------------------------------------------------------------------
        //todo (bug fix) schedule_to_date is being inserted as 0000-00-000

        switch($or_state){
            case '1':
                $data_entrega= strtotime($data['or_data_entrega']);
                $data_entrega = date('y-m-d',$data_entrega);
            case '2':
                $data_entrega = date("y/m/d");
                break;
        }



        switch ($data['codeType']){
            case 'none':
                $codigo = "s/ codigo";
                break;
            case 'alphanumeric':
                $codigo = "codigo: " . $data['cod_bloqueio'];
                break;
            case 'pattern':
                $codigo = "padrao: " . $data['password'];
                break;
        }

        $repair = new Repair(   $data['tipo'],
                                $data['marca'],
                                $data['modelo'],
                                $data['cor'],
                                $codigo,
                                $data['or_valor'],
                                $data['imei'],
                                empty($data['acessorios']) ? '' : implode(",",$data['acessorios']),
                                $data_entrega,
                                $data['obs_equipamento'],
                                $data['obs_or']
            );


        $or = new ORData();

        try {
            $or->create_ORData($or_type, $or_state, $client, $repair, $this->user->get_userID());
        } catch (Exception $e) {
            echo "Por favor contacte o administrador do sistema [" . e . "]";
        }

    }

    public function details($OR_ID = 0){
        if(!$OR_ID){
            redirect('r/booking/book', 'refresh');
        }

    }



}