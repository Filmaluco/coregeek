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
        $this->add_data($this->user->get_mainGroup(), 'group');
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

        $this->set_permissions([AUTH_PERMISSIONS_VIEW_BOOKING]);
        if($this->access_check()== AUTHENTICATION_ERROR){
            redirect('/r/home');
        }

    }

    public function index(){
        // REQUIRED ----------------------------------------------------------------------------------------------------
        $this->set_CurrentMethod('Home');
        $this->set_group();
        $this->set_permissions([AUTH_PERMISSIONS_VIEW_BOOKING]);
        $this->add_data($this->user->get_mainGroup(), 'group');
        if($this->access_check()== AUTHENTICATION_ERROR){
            redirect('/r/home');
        }
        $this->add_data($this->user->get_mainGroup(), 'group');
        //--------------------------------------------------------------------------------------------------------------

         redirect('r/booking/search', 'refresh');

    }
    public function book(){
        // REQUIRED ----------------------------------------------------------------------------------------------------
        $this->set_CurrentMethod('Novo Booking');
        $this->set_group();
        $this->set_permissions([AUTH_PERMISSIONS_ADD_BOOKING]);
        $this->add_data($this->user->get_mainGroup(), 'group'); //requires a group to the nav, this gets the first group... careful
        if($this->access_check()== AUTHENTICATION_ERROR){
            $data = [
                'errors' => '<span class="form-text text-danger"><i class="icon-cancel-circle2 mr-2"></i> Sem permissoes suficientes </span>'
            ];

            $this->session->set_flashdata($data);
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

        // REQUIRED ----------------------------------------------------------------------------------------------------
        $this->set_permissions([AUTH_PERMISSIONS_ADD_BOOKING]);
        if($this->access_check()== AUTHENTICATION_ERROR){
            $data = [
                'errors' => '<span class="form-text text-danger"><i class="icon-cancel-circle2 mr-2"></i> Sem permissoes suficientes </span>'
            ];

            $this->session->set_flashdata($data);
            redirect('/login');
        }
        //--------------------------------------------------------------------------------------------------------------


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
            $or->create_ORData($or_type, $or_state, $client, $repair, $data['cod_func']);
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
        $this->set_permissions([AUTH_PERMISSIONS_VIEW_BOOKING]);
        $this->add_data($this->user->get_mainGroup(), 'group');
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

    public function edit($OR_ID = 0){
        // REQUIRED ----------------------------------------------------------------------------------------------------
        $this->set_CurrentMethod('Edit');
        $this->set_group();
        $this->set_permissions([AUTH_PERMISSIONS_EDIT_BASIC_BOOKING]);
        $this->add_data($this->user->get_mainGroup(), 'group');
        if($this->access_check()== AUTHENTICATION_ERROR){
            redirect('/r/home');
        }
        $this->add_data($this->user->get_mainGroup(), 'group');
        //--------------------------------------------------------------------------------------------------------------

        $OR = new ORData();
        try{
            $OR->load_specific_ORData($OR_ID, 0);
        }catch (Exception $e){
            redirect("r/booking", "refresh");
            die;
        }
        $this->add_data($OR, "OR");

        if($this->has_permission(AUTH_PERMISSIONS_EDIT_FULL_BOOKING)){
            //todo update
            echo $this->load->view('dashboard/booking/edit_basic', $this->get_data(), true);
        }else{
            echo $this->load->view('dashboard/booking/edit_basic', $this->get_data(), true);
        }
    }

    public function update(){
        $data = $this->input->post();

        if(!is_numeric($data['or_id'])){die();}
        if(!is_numeric($data['cod_func'])){die();}
        if(!is_numeric($data['state'])){die();}
        if(!is_numeric($data['or_valor'])){die();}

        $oldOR = new ORData($data['or_id']);
        $oldRepairInfo = $oldOR->get_LastRepairInfo();

       if($this->has_permission(AUTH_PERMISSIONS_EDIT_FULL_BOOKING)){

       }

       if($data['state'] != $oldOR->get_StateID()){
           $oldOR->update_OR_state($data['cod_func'], $data['state']);
       }


        $obs =$oldRepairInfo->Obs .' '.$data['obs_or'];

       $date= date('y-d-m', strtotime($data['or_data_entrega']));

        $newRepairInfo = new RepairInfo($oldRepairInfo->Device, $oldRepairInfo->Brand, $oldRepairInfo->Model, $oldRepairInfo->Color, $oldRepairInfo->Unlock_Code, $data['or_valor'], $oldRepairInfo->IMEI, $oldRepairInfo->Acessories, $date, $oldRepairInfo->Desc,  $obs );
        $newRepairInfo->create_repair($data['or_id'],$data['cod_func'] );

        redirect('r/booking/details/'. $data['or_id'], 'refresh');
    }

    public function search($method = "onGoing"){
        // REQUIRED ----------------------------------------------------------------------------------------------------
        $this->set_CurrentMethod('Procura');
        $this->set_group();
        $this->set_permissions([AUTH_PERMISSIONS_VIEW_BOOKING]);
        if($this->access_check()== AUTHENTICATION_ERROR){
            redirect('/login');
        }
        $this->add_data($this->user->get_mainGroup(), 'group');
        //--------------------------------------------------------------------------------------------------------------

        $query_str = 'SELECT 	ORs.OR_ID,
        Repair_State.Name as Estado,
        CONCAT(Last_Repair.Brand, \' \',Last_Repair.Model) AS Dispositivo,
        Clients.Name AS Cliente,
        CONCAT(Clients.Email, \'/\', Clients.Phone) AS \'Contactos\',
        CONCAT(DATE_FORMAT(t.Creation_Date, "%d, %M %Y"), \' por \', Users.Username) as UltimaAlteracao
FROM ORs
       JOIN (SELECT  a.*
             FROM    OR_State a
                       INNER JOIN
                         (
                         SELECT  State_ID, MAX(Creation_Date)maxDate
                         FROM OR_State
                         GROUP BY OR_ID
                         ) b  WHERE
                 a.Creation_Date = b.maxDate) t
         ON ORs.OR_ID = t.OR_ID
       JOIN Repair_State
         ON t.State_ID = Repair_State.State_ID
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
         ON t.OR_ID = Last_Repair.OR_ID
       JOIN Clients ON ORs.Client_ID = Clients.Client_ID
       JOIN Users ON t.User_ID = Users.User_ID ';

        switch ($method){
            case "onGoing":
                $query_str .= "WHERE t.State_ID < " . BOOKING_STATE_BOOKED_DELIVERED_S;
                break;
            case "finished":
                $query_str .= "WHERE t.State_ID > " . BOOKING_STATE_BOOKED_DELIVERED_S;
                break;
            case "all":
                $query_str .= "WHERE t.State_ID > 0";
                break;
        }

        $query_str .= ' ORDER BY ORs.OR_ID';

        $query = $this->db->query($query_str);

        $this->add_data($query, 'query_search');

        echo $this->load->view('dashboard/booking/search', $this->get_data(), true);
    }



}