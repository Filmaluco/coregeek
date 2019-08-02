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
        $this->add_data($this->user->get_groups()[0], 'group');
        if($this->access_check()== AUTHENTICATION_ERROR){
            redirect('/login');
        }
        //--------------------------------------------------------------------------------------------------------------

         redirect('r/booking/search', 'refresh');

    }
    public function book(){
        // REQUIRED ----------------------------------------------------------------------------------------------------
        $this->set_CurrentMethod('Novo Booking');
        $this->set_group();
        $this->set_permissions(['Add']);
        $this->add_data($this->user->get_groups()[0], 'group'); //requires a group to the nav, this gets the first group... careful
        if($this->access_check()== AUTHENTICATION_ERROR){
            redirect('/login');
        }
        //--------------------------------------------------------------------------------------------------------------

        if($this->user->is_set_uniqueForm()){
            echo $this->load->view('dashboard/booking/book_form', $this->get_data(), true);
        }else{
            echo $this->load->view('dashboard/booking/book_wizard', $this->get_data(), true);
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
        switch($or_state){
            case '1':
                $data_entrega= strtotime($data['or_data_entrega']);
                $data_entrega = date('y-m-d',$data_entrega);
                break; //...
            case '2':
                $data_entrega = date("y/m/d");
                break;
            default:
                $data_entrega = "";
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
            default:
                $codigo = "";
        }

        $repair = new RepairInfo(   $data['tipo'],
                                $data['marca'],
                                $data['modelo'],
                                $data['cor'],
                                $codigo,
                                isset($data['or_valor']) ? $data['or_valor'] : 0,
                                isset($data['imei']) ? $data['imei'] : "",
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
        redirect('r/booking/details/'. $or->get_ORID(), 'refresh');
    }

    public function details($OR_ID = 0, $offset=0){
        if(!$OR_ID){
            redirect('r/booking/book', 'refresh');
        }

        // REQUIRED ----------------------------------------------------------------------------------------------------
        $this->set_CurrentMethod('Details');
        $this->set_group();
        $this->set_permissions(['View']);
        $this->add_data($this->user->get_groups()[0], 'group');
        if($this->access_check()== AUTHENTICATION_ERROR){
            redirect('/login');
        }
        //--------------------------------------------------------------------------------------------------------------

        $OR = new ORData();
        try{
            $OR->load_specific_ORData($OR_ID, $offset);
        }catch (Exception $e){
            redirect("r/booking", "refresh");
            die;
        }
        $this->add_data($OR, "OR");

        echo $this->load->view('dashboard/booking/details', $this->get_data(), true);


    }

    public function search($method = "onGoing"){
        // REQUIRED ----------------------------------------------------------------------------------------------------
        $this->set_CurrentMethod('Procura');
        $this->set_group();
        $this->set_permissions(['View']);
        $this->add_data($this->user->get_groups()[0], 'group');
        if($this->access_check()== AUTHENTICATION_ERROR){
            redirect('/login');
        }
        //--------------------------------------------------------------------------------------------------------------

        $query_str = 'SELECT 	ORs.OR_ID,
        Repair_State.Name as \'Estado\',
        CONCAT(Last_Repair.Brand, \' \',Last_Repair.Model) AS \'Dispositivo\',
        Clients.Name AS \'Cliente\',
        CONCAT(Clients.Email, \'/\', Clients.Phone) AS \'Contactos\',
        CONCAT(DATE_FORMAT(OR_State.Creation_Date, "%d, %M %Y"), \' por \', Users.Username) as \'UltimaAlteracao\'
        FROM ORs
        JOIN OR_State
        ON ORs.OR_ID = OR_State.OR_ID
        JOIN Repair_State
        ON OR_State.State_ID = Repair_State.State_ID
        JOIN (
            SELECT  OR_ID,
                    Repair_Info.Creation_Date,
                    Brand,
                    Model
            FROM Repair_Info
                   JOIN (SELECT Repair_ID, Max(Creation_Date) FROM Repair_Info GROUP BY Repair_ID) as B
                     ON Repair_Info.Repair_ID = B.Repair_ID
            GROUP BY OR_ID
            ) AS Last_Repair
         ON OR_State.OR_ID = Last_Repair.OR_ID
       JOIN Clients ON ORs.Client_ID = Clients.Client_ID
       JOIN Users ON OR_State.User_ID = Users.User_ID ';

        switch ($method){
            case "onGoing":
                $query_str .= "WHERE OR_State.State_ID < " . BOOKING_STATE_BOOKED_DELIVERED_S;
                break;
            case "finished":
                $query_str .= "WHERE OR_State.State_ID > " . BOOKING_STATE_BOOKED_DELIVERED_S;
                break;
            case "all":
                $query_str .= "WHERE OR_State.State_ID > 0";
                break;
        }

        $query = $this->db->query($query_str);

        $this->add_data($query, 'query_search');

        echo $this->load->view('dashboard/booking/search', $this->get_data(), true);
    }



}