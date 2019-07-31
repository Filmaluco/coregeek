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
    protected $Invoice_Number;
    protected $Conditions_Read;
    protected $Read_on_Date;


    //We'll use a constructor, as you can't directly call a function
    // from a property definition.
    public function __construct()
    {
        // Assign the CodeIgniter super-object
        $CI =& get_instance();
        $CI->load->model('Client');
        $CI->load->model('Repair');
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


        $repair_info->create_repair($CI->db->insert_id(), $userID);

        //OR state
        $CI->db->insert('OR_State', array('OR_ID' =>  $repair_info->get_ORID(),
            'State_ID'=>   $status,
            'User_ID' => $userID));



        redirect('r/booking/details/'. $repair_info->get_RepairID(), 'refresh');

    }
}