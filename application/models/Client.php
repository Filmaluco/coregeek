<?php
/**
 * Created by PhpStorm.
 * User: FilipeA
 * Date: 7/31/2019
 * Time: 11:55
 */

class Client
{


    /**
     * @var $Client_ID
     * Contains the client ID
     */
    protected $Client_ID;
    /**
     * @var $Name
     * Client full name (required)
     */
    public $Name;
    /**
     * @var $Phone
     * client mobile phone number
     */
    protected $Phone;
    /**
     * @var $Email
     * client email (required)
     */
    public $Email;
    /**
     * @var $Obs
     * Observations about this client
     */
    protected $Obs;



    /**
     * Creates and validates client
     *
     * @param $name full name
     * @param $email
     * @param string $phone mobile phone number
     * @param string $obs observations
     */
    public function create_client($name, $email, $phone = "", $obs=""){
        try {
            $this->get_client_byEmail($email);
        }catch (Exception $e){
            $CI =& get_instance();
            $CI->db->insert('Clients', array("Name" => $name,
                                                "Email" => $email,
                                                "Phone" => $phone,
                                                "Obs" => $obs));
            $this->Client_ID = $CI->db->insert_id();
            $this->Name = $name;
            $this->Email = $email;
            $this->Phone = $name;
            $this->Obs = $obs;
        }
    }

    /**
     * @param $id from the desired client
     * @return object with the client data
     * @throws Exception if ID is not valid
     */
    public function get_client_byID($id){

        $CI =& get_instance();

        $result = $CI->db->get_where('Clients', array('Client_ID=' => $id ))->row();
        if(!$result){
            throw new Exception('User does not exist');
        }
        $this->Client_ID = $result->Client_ID;
        $this->Name = $result->Name;
        $this->Phone = $result->Phone;
        $this->Email = $result->Email;
        $this->Obs = $result->Obs;
        return $this;
    }

    /**
     * @param $email from the desired client
     * @return object with the client data
     * @throws Exception if ID is not valid
     */
    public function get_client_byEmail($email){
        $CI =& get_instance();

        $result = $CI->db->get_where('Clients', array('Email=' => $email ))->row();
        if(!$result){
            throw new Exception('User does not exist');
        }
        $this->Client_ID = $result->Client_ID;
        $this->Name = $result->Name;
        $this->Phone = $result->Phone;
        $this->Email = $result->Email;
        $this->Obs = $result->Obs;
        return $this;
    }


    /**
     * @return mixed
     */
    public function get_ID()
    {
        return $this->Client_ID;
    }

    /**
     * @return mixed
     */
    public function get_name()
    {
        return $this->Name;
    }

    /**
     * @return mixed
     */
    public function get_phone()
    {
        return $this->Phone;
    }

    /**
     * @return mixed
     */
    public function get_email()
    {
        return $this->Email;
    }

    /**
     * @return mixed
     */
    public function get_obs()
    {
        return $this->Obs;
    }



}