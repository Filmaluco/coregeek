<?php
/**
 * Created by PhpStorm.
 * User: FilipeA
 * Date: 10/19/2018
 * Time: 10:51
 */

class Notification
{

    /**
     * @var CI_Controller
     * allows acess to codeIgniter framework
     */
    protected $CI;

    /**
     * @var int
     * Notification ID
     */
    protected $id = "Not Defined";

    /**
     * @var string
     * Notification content of the notification / text
     */
    protected $message = "Not Defined";

    /**
     * @var DateTime
     * Notification creation date
     */
    protected $creation_date = "Not Defined";

    /**
     * @var DateTime
     * Notification time limit
     */
    protected $expiration_date = "Not Defined";

    /**
     * @var boolean
     * Notification seen by the current User
     */
    protected $seen = 'Not Defined';

    public function __construct()
    {
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();

    }

    /**
     * @return int
     */
    public function get_ID()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function get_Message()
    {
        return $this->message;
    }

    /**
     * @return DateTime
     */
    public function get_Creation_Date()
    {
        return $this->creation_date;
    }

    /**
     * @return DateTime
     */
    public function get_Expiration_Date()
    {
        return $this->expiration_date;
    }

    /**
     * @return bool
     */
    public function isSeen()
    {
        return $this->seen;
    }



    /**
     * @param $notificationID
     * @param $user_id
     * @throws Exception => if the user has no access to the notification OR notification does not exist
     *
     * TODO: complex increase description
     */
    public function load($notificationID, $user_id)
    {

        $this->id = $notificationID;

        //Check if the user has acess to such a notification
        $flag = 0; // Flag to controll if the user belongs to the list of users with access to the notification
        $access_to = $this->CI->db->get_where('UserNotifications', ['Notification_ID' => $this->id]);
        foreach ($access_to->result() as $row){
            if($row->User_ID == $user_id){
                $this->seen = $row->Seen;
                $flag = 1;
                break;
            }
        }

        if(!$flag){
            throw new Exception("Can't access notification");
        }

        //Load all the notification information
        $notification_info = $this->CI->db->get_where('Notifications', ['Notification_ID' => $this->id],1);
        $notification_info = $notification_info->row();

        $this->message = $notification_info->Message;
        $this->creation_date = $notification_info->Creation_Date;
        $this->expiration_date = $notification_info->Expiration_Date;


    }

    public function get_time_since(){
        $now = new DateTime();
        $creation_date = new DateTime($this->creation_date);


        $since_start = date_diff($now, $creation_date);

        if($since_start->days >= 1){
            return $since_start->format("%d days and %h hours ago");
        }//Else
            return $since_start->format("%i minutes ago");
    }

    /**
     * Sets notification as Seen
     */
    public function mark_as_read(){
        $this->CI->db
            ->set([ 'Seen' => 1])
            ->where('Token_Key', $this->CI->input->cookie('SID'))
            ->update('UserNotifications');
    }




}