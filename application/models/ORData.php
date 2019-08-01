<?php
/**
 * Created by PhpStorm.
 * User: FilipeA
 * Date: 7/31/2019
 * Time: 11:55
 */

class ORData
{


    //todo create or (with client class and repair class)
    //todo get BY ID
    //todo extract Repair class (latest)
    //todo extract Repair class (all of them)
    //todo extract Client class

    protected $OR_ID;
    protected $Client_ID;
    protected $Type_ID;
    protected $Type;
    protected $State_ID;
    protected $State;
    protected $Invoice_Number;
    protected $Conditions_Read;
    protected $Read_on_Date;


    //We'll use a constructor, as you can't directly call a function
    // from a property definition.
    public function __construct($OR_ID = "0")
    {
        // Assign the CodeIgniter super-object
        $CI =& get_instance();
        $CI->load->model('Client');
        $CI->load->model('Repair');

        if(!empty($OR_ID)){
            $this->load_ORData($OR_ID);
        }
    }


    /**
     * @param $type int with the correct type (1-Orçamentar | 2-Orçamentado | 3-Garantia)
     * @param $status "from" 1 to 17 (check DB documentation)
     * @param $client Client class OR clientID
     * @param $repair_info Repair class
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

        if(!($repair_info instanceof Repair)) {
            throw new Exception("Incorrect arguments");
        }

        //Create OR
        $CI->db->insert('ORs', array('Client_ID' => $client->get_ID(),
            'Type_ID' => $type));


        $this->OR_ID = $CI->db->insert_id();
        $this->Client_ID = $client->get_ID();
        $this->Type_ID = $type; //todo: load string from type
        $this->State_ID = $status; //todo: load string from state


        $repair_info->create_repair($this->OR_ID, $userID);

        //OR state
        $CI->db->insert('OR_State', array('OR_ID' =>  $this->OR_ID,
            'State_ID'=>   $status,
            'User_ID' => $userID));


    }

    private function load_ORData($OR_ID)
    {
        //see if $OR exists's
        //load ClientINFO
        //load ORState
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