<?php
/**
 * Created by PhpStorm.
 * User: FilipeA
 * Date: 7/31/2019
 * Time: 11:55
 */

class ORData
{
    //todo extract Repair class (latest)
    //todo extract Repair class (all of them)
    //todo extract Client class

    protected $OR_ID;
    protected $Client_ID;
    protected $Client;
    protected $Type_ID;
    protected $Type;
    protected $State_ID;
    protected $State;
    protected $State_Altered_Date;
    protected $State_Altered_By;
    protected $Invoice_Number;
    protected $Conditions_Read;
    protected $Read_on_Date;

    protected $repair_offset = 0;
    protected $last_repair_info;
    protected $repair_infos;
    protected $number_repairs;

    //We'll use a constructor, as you can't directly call a function
    // from a property definition.
    public function __construct($OR_ID = "0")
    {
        // Assign the CodeIgniter super-object
        $CI =& get_instance();
        $CI->load->model('Client');
        $CI->load->model('RepairInfo');

        if(!empty($OR_ID)){
            $this->load_ORData($OR_ID);
        }
    }


    /**
     * @param $type int with the correct type (1-Orçamentar | 2-Orçamentado | 3-Garantia)
     * @param $status "from" 1 to 17 (check DB documentation or constants)
     * @param $client Client class OR clientID
     * @param $repair_info RepairInfo class
     * @throws Exception if the class's are not correct
     */
    public function create_ORData($type, $status, $client, $repair_info, $userID){

        $CI =& get_instance();

        //Check if the client is from the class Client
        if(!($client instanceof Client)){
        //check if it's and ID then
            $client_info = new Client();
            try {
                $client_info->get_client_byID($client);
            }catch (Exception $e){
                throw new Exception("Incorrect arguments");
            }
        }else {$client_info = $client;}

        if(!($repair_info instanceof RepairInfo)) {
            throw new Exception("Incorrect arguments");
        }

        $this->Client = $client_info;
        $this->last_repair_info = $repair_info;
        $this->repair_offset = 0;
        $this->number_repairs = 1;

        //Create OR
        $CI->db->insert('ORs', array('Client_ID' => $client_info->get_ID(),
            'Type_ID' => $type));


        $this->OR_ID = $CI->db->insert_id();
        $this->Client_ID = $client_info->get_ID();
        try {
            $this->Type = $CI->db->get_where('Repair_Types', array("Type_ID=" => $type))->row()->Name;
            $this->State = $CI->db->get_where('Repair_State', array("State_ID=" => $status))->row()->Name;
        }catch (Exception $e){
            $this->Type = "/";
            $this->State = "/";
        }


        $repair_info->create_repair($this->OR_ID, $userID);

        //OR state
        $CI->db->insert('OR_State', array('OR_ID' =>  $this->OR_ID,
            'State_ID'=>   $status,
            'User_ID' => $userID));


    }

    /**
     * @param $OR_ID
     * @param bool $all 0 = only loads last repair_info
     * @throws Exception
     */
    private function load_ORData($OR_ID, $all=false)
    {
        $CI =& get_instance();

        //load last REPAIR
        try{
            $this->load_specific_ORData($OR_ID);
        }catch (Exception $e){
            throw new Exception($e);
        }
    }

    /**
     * @param $OR_ID
     * @param int $offset
     * @throws Exception
     */
    public function load_specific_ORData($OR_ID, $offset=0){
        $CI =& get_instance();
        //see if $OR exists's
        try {
            $result = $CI->db->get_where('ORs', array('OR_ID=' => $OR_ID))->row();
            $this->OR_ID = $OR_ID;
            $this->Type_ID = $result->Type_ID;
            $this->Type_ID = $CI->db->get_where('Repair_Types', array("Type_ID=" => $this->Type_ID))->row()->Name;

            //load ClientINFO
            $this->Client_ID = $result->Client_ID;
            $this->Client = new Client();
            $this->Client->get_client_byID($this->Client_ID);

            //load ORState //TODO: optimize with a sql search!
            $result = $CI->db->get_where('OR_State', array('OR_ID=' => $OR_ID))->row();
            $this->State_ID = $result->State_ID;
            $this->State = $CI->db->get_where('Repair_State', array("State_ID=" => $this->State_ID))->row()->Name;
            $this->State_Altered_Date = $result->Creation_Date;
            $this->State_Altered_By = $CI->db->get_where('Users', array("User_ID" => $result->User_ID))->row()->Username;

            //load number of repair info's
            $result = $CI->db->order_by('Creation_Date', 'DESC')->get_where('Repair_Info', array("OR_ID" => $this->OR_ID))->result();
            $this->repair_infos = $result;
            $this->last_repair_info = $result[0];
            $this->number_repairs = sizeof($result);

        }catch (Exception $e){
            throw new Exception('INVALID OR');
        }
        try{
            $this->get_repairInfo_byOffset($offset);
        }catch (Exception $e){
            throw new Exception('WRONG OFFSET');
        }
    }

    public function get_repairInfo_byOffset($offset){
        $temp =  $this->last_repair_info;
        if($offset < $this->number_repairs){
            $this->repair_offset = $offset;
            $this->last_repair_info = $this->repair_infos[$offset];
            return $this->last_repair_info;
        }else{
            $this->last_repair_info = $temp;
            throw new Exception('WRONG OFFSET');
        }
    }


    /**
     * @return mixed
     */
    public function get_ORID()
    {
        return $this->OR_ID;
    }

    /**
     * @return mixed
     */
    public function get_ClientID()
    {
        return $this->Client_ID;
    }

    /**
     * @return mixed
     */
    public function get_Client()
    {
        return $this->Client;
    }



    /**
     * @return mixed
     */
    public function get_State()
    {
        return $this->State;
    }

    /**
     * @return mixed
     */
    public function get_StateAlteredBy()
    {
        return $this->State_Altered_By;
    }




    /**
     * @return mixed
     */
    public function get_TypeID()
    {
        return $this->Type_ID;
    }

    /**
     * @return mixed
     */
    public function get_InvoiceNumber()
    {
        return $this->Invoice_Number;
    }

    /**
     * @return mixed
     */
    public function get_ConditionsRead()
    {
        return $this->Conditions_Read;
    }

    /**
     * @return mixed
     */
    public function get_ReadOnDate()
    {
        return $this->Read_on_Date;
    }

    /**
     * @return as $database object NOT as RepairInfo
     */
    public function get_LastRepairInfo()
    {
        //todo make sure its a RepairInfo object
        return $this->last_repair_info;
    }

    public function get_LastRepairUser_toString(){

        $CI =& get_instance();
        $result = $CI->db->get_where('Users', array("User_ID=" => $this->last_repair_info->User_ID))->row();

        return $result->Username;
    }







}