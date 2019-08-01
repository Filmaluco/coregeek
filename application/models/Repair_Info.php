<?php
/**
 * Created by PhpStorm.
 * User: FilipeA
 * Date: 11/4/2018
 * Time: 23:12
 */

//todo email system (pending "boss" approval)
class Repair_Info
{


    protected $Repair_ID;
    protected $OR_ID;
    protected $User_ID;
    protected $Creation_Date;
    protected $Schedule_To_Date;
    protected $Device;
    protected $Brand;
    protected $Model;
    protected $Color;
    protected $IMEI;
    protected $Unlock_Code;
    protected $Acessories;
    protected $Desc;
    protected $Obs;
    protected $Price;

    /**
     * Repair constructor.
     * Required in the Form:
     * @param $device
     * @param $brand
     * @param $model
     * @param $color
     * @param $unlock_code
     * @param string $price
     *
     * Extra (all have default values)
     * @param string $imei
     * @param string $acessories
     * @param string $shedule
     * @param string $desc
     * @param string $obs
     */
    public function __construct( $device="", $brand="", $model="", $color="", $unlock_code="", /* required in the form*/
                                 $price = "0", $imei = "", $acessories="S/ Acessorios", $shedule="", $desc ="", $obs="")
    {
        $this->Device = $device;
        $this->Brand = $brand;
        $this->Model = $model;
        $this->Color = $color;
        $this->Unlock_Code = $unlock_code;

        $this->Price = $price;
        $this->IMEI = $imei;
        $this->Acessories = $acessories;
        $this->Schedule_To_Date = $shedule;
        $this->Desc = $desc;
        $this->Obs = $obs;
    }


    /**
     * Required for DB Constraints
     * @param $or_id
     * @param $user_id
     *
     * @throws Exception if it fails to create repair info
     */
    public function create_repair($or_id, $user_id){


        $CI =& get_instance();
        $CI->db->insert('Repair_Info', array( "OR_ID" => $or_id,
                                                    "User_ID" => $user_id,
                                                    "Device" => $this->Device,
                                                    "Brand" =>  $this->Brand,
                                                    "Model" =>  $this->Model,
                                                    "Color" =>  $this->Color,
                                                    "Unlock_Code" =>  $this->Unlock_Code,
                                                    "Price" =>  $this->Price,
                                                    "IMEI" =>  $this->IMEI,
                                                    "Acessories" =>  $this->Acessories,
                                                    "Schedule_To_Date" =>  $this->Schedule_To_Date,
                                                    "Desc" =>  $this->Desc,
                                                    "Obs" =>  $this->Obs,
            ));

        if(empty($CI->db->insert_id())){
            throw new Exception("Failed to create repair info");
        }

        $this->Repair_ID = $CI->db->insert_id();
        $this->OR_ID = $or_id;
        $this->User_ID = $user_id;

        $CI->db->select('Creation_Date');
        $this->Creation_Date = $CI->db->get_where('Repair_Info', array("Repair_ID=" => $this->Repair_ID))->row()->Creation_Date;
    }



    /**
     * @return mixed
     */
    public function get_RepairID()
    {
        return $this->Repair_ID;
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
    public function get_userID()
    {
        return $this->User_ID;
    }

    /**
     * @return mixed
     */
    public function get_creationDate()
    {
        return $this->Creation_Date;
    }

    /**
     * @return mixed
     */
    public function get_ScheduleDate()
    {
        return $this->Schedule_To_Date;
    }

    /**
     * @return mixed
     */
    public function get_device()
    {
        return $this->Device;
    }

    /**
     * @return mixed
     */
    public function get_brand()
    {
        return $this->Brand;
    }

    /**
     * @return mixed
     */
    public function get_model()
    {
        return $this->Model;
    }

    /**
     * @return mixed
     */
    public function get_color()
    {
        return $this->Color;
    }

    /**
     * @return mixed
     */
    public function get_IMEI()
    {
        return $this->IMEI;
    }

    /**
     * @return mixed
     */
    public function get_unlockCode()
    {
        return $this->Unlock_Code;
    }

    /**
     * @return mixed
     */
    public function get_acessories()
    {
        return $this->Acessories;
    }

    /**
     * @return mixed
     */
    public function get_desc()
    {
        return $this->Desc;
    }

    /**
     * @return mixed
     */
    public function get_obs()
    {
        return $this->Obs;
    }

    /**
     * @return mixed
     */
    public function get_price()
    {
        return $this->Price;
    }



}