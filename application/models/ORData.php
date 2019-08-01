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
    protected $Invoice_Number;
    protected $Conditions_Read;
    protected $Read_on_Date;

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
        $CI->load->model('Repair_Info');

        if(!empty($OR_ID)){
            $this->load_ORData($OR_ID);
        }
    }


    /**
     * @param $type int with the correct type (1-Orçamentar | 2-Orçamentado | 3-Garantia)
     * @param $status "from" 1 to 17 (check DB documentation)
     * @param $client Client class OR clientID
     * @param $repair_info Repair_Info class
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

        if(!($repair_info instanceof Repair_Info)) {
            throw new Exception("Incorrect arguments");
        }

        $this->Client = $client_info;
        $this->last_repair_info = $repair_info;

        //Create OR
        $CI->db->insert('ORs', array('Client_ID' => $client_info->get_ID(),
            'Type_ID' => $type));


        $this->OR_ID = $CI->db->insert_id();
        $this->Client_ID = $client_info->get_ID();
        try {
            $this->Type_ID = $CI->db->get_where('Repair_Types', array("Type_ID=" => $type))->row()->Name;
            $this->State_ID = $CI->db->get_where('Repair_State', array("Type_ID=" => $status))->row()->Name;
        }catch (Exception $e){
            $this->Type_ID = "/";
            $this->State_ID = "/";
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
     */
    private function load_ORData($OR_ID, $all=false)
    {
        //see if $OR exists's
        //load ClientINFO
        //load ORState
        //load last REPAIR
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




}