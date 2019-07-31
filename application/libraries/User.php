<?php
/**
 * Created by PhpStorm.
 * User: FilipeA
 * Date: 9/30/2018
 * Time: 22:51
 */

class User
{
    /**
     * @var CI_Controller
     * allows access to codeIgniter framework
     */
    protected $CI;

    /**
     * @var int
     * User Store ID
     */
    protected $store_id = "Not Defined";

    /**
     * @var int
     * User Store ID
     */
    protected $store_name = "Not Defined";

    /**
     * @var int
     * User User ID
     */
    protected $user_id = "Not Defined";

    /**
     * @var string
     * User current $token
     */
    protected $token = "Not Defined";

    /**
     * @var string
     * Username
     */
    protected $username = "Not Defined";

    /**
     * @var string
     * User email
     */
    protected $email = "Not Defined";

    /**
     * @var array
     * Contains this user notifications
     */
    protected $notifications = "Not Defined";

    /**
     * @var int
     * Number of not seen notifications
     */
    protected $notifications_count = "Not Defined";

    /**
     * @var array
     * Contains all groups this user belongs to
     */
    protected $groups = "Not Defined";

    /**
     * @var array
     * Contains all this user permissions
     */
    protected $permissions = "Not Defined";


    // We'll use a constructor, as you can't directly call a function
    // from a property definition.
    public function __construct()
    {
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
        $this->CI->load->library('user_agent');
        $this->CI->load->library('notification');
        $this->CI->load->helper('cookie');
        $this->CI->load->helper('date');
    }

    /**
     * @param $username = user's login username
     * @param $password = user's password
     * @param $remember_me = keeps session active between visits
     * @return int
     *      LOGIN_SUCCESS
     *      LOGIN_ERROR_NON_EXISTENT_USER
     *      LOGIN_ERROR_PASSWORD
     */
    public function login($username, $password, $remember_me = false){

        $username =$this->CI->db->escape_str($username);
        $password = $this->CI->db->escape_str($password);

        //Get User's info
        $query = $this->CI->db
            ->select("*")
            ->from("Users")
            ->where("Username", $username)
            ->get();

        //Check if the user even exist's
        if($query->num_rows() != 1){
            return LOGIN_ERROR_NON_EXISTENT_USER;
        }

        $user_info = $query->row();

        //Check if its the user correct password
        if(!password_verify($password, $user_info->Password)){
            return LOGIN_ERROR_PASSWORD;
        }

        //Get Device information
        $device_info = $this->CI->agent->is_mobile() == true ? "Mobile: " : "";
        $device_info .=  $this->CI->agent->browser();

        //Set User variables
        $this->store_id = $user_info->Store_ID;
        $this->user_id = $user_info->User_ID;
        $this->username = $user_info->Username;


        $cstrong = True;
        $this->token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));

        //Add token to the DB
        $this->CI->db
                    ->set([ 'Name' => $device_info,
                            'User_ID' => $this->user_id,
                            'Token_Key' => $this->token])
                    ->insert('UserTokens');

        $cookie_time = strtotime(COOKIE_TIME_ACCESS, 0);      //sets cookie token
        $cookie_reminder = strtotime(COOKIE_TIME_ACCESS, 0);  //sets cookie remind me

        $https = ENVIRONMENT == 'development' ? false : true;

        //Add token cookie
        if($remember_me){
            set_cookie("SID", $this->token, $cookie_time);
            set_cookie("SIDR", $this->token, $cookie_reminder);
        }else{
           set_cookie("SID", $this->token, 0);
        }

        return LOGIN_SUCCESS;

    }

    /**
     * @return void
     */
    public function logout(){

        $this->CI->db
                    ->set([ 'Status' => 0])
                    ->where('Token_Key', $this->CI->input->cookie('SID'))
                    ->update('UserTokens');

        delete_cookie('SID');
        delete_cookie('SIDR');

    }

    /**
     * @return int
     *      AUTHENTICATION_SUCCESS
     *      AUTHENTICATION_ERROR
     *
     * Validates user TOKEN and Loads user basic info, if necessary updates user token.
     */
    public function authenticate(){

        //Check if theres a token cookie
        if(!$this->CI->input->cookie('SID')){
            return AUTHENTICATION_ERROR;
        }

        //Gets the token cookie
        $this->token = $this->CI->input->cookie('SID');

        //Obtains token info
        $token_info = $this->CI->db->get_where('UserTokens', ['Token_Key' => $this->token], 1);
        $token_info = $token_info->row();

        //Checks if token is valid
        if($token_info->Status == TOKEN_INVALID){
            return AUTHENTICATION_ERROR;
        }

        //Load Basic Info ---------------------------------------------------------------------------------------------
        $this->user_id = $token_info->User_ID;

        $user_details = $this->CI->db->get_where('Users', ['User_ID' => $this->user_id],1);
        $user_details = $user_details->row();

        $this->username = $user_details->Username;
        $this->store_id = $user_details->Store_ID;

        $user_details = $this->CI->db->get_where('Stores', ['Store_ID' => $this->store_id],1);
        $user_details = $user_details->row();
        $this->store_name = $user_details->Name;

        //Load Notifications -------------------------------------------------------------------------------------------
        //count total of notifications not seen
        $user_notifications_info = $this->CI->db->get_where('UserNotifications', ['User_ID' => $this->user_id, 'Seen' => 0]);
        $this->notifications_count = $user_notifications_info->num_rows();


        //gets last LOAD_LAST_NOTIFICATIONS

        $last_notifications = $this->CI->db->query('SELECT N.*
                                                    FROM UserNotifications userN
                                                      JOIN Notifications N ON (userN.Notification_ID = N.Notification_ID)
                                                    WHERE userN.User_ID = '.$this->user_id.' AND
                                                          userN.Seen = 0
                                                    ORDER BY N.Creation_Date DESC
                                                    LIMIT '.LOAD_LAST_NOTIFICATIONS.';');

        $all_notifications = array();
        foreach ($last_notifications->result() as $info){
            $newNotification = new Notification();
            try {
                $newNotification->load($info->Notification_ID, $this->user_id);
            } catch (Exception $e) {
                $this->notifications_count--;
                continue;
            }
            array_push($all_notifications, $newNotification);
        }

        $this->notifications = $all_notifications;


        //Load Groups Info ---------------------------------------------------------------------------------------------
        $this->groups = array();
        $user_groups = $this->CI->db->query('
                                                SELECT Groups.*
                                                FROM Groups
                                                RIGHT JOIN UserGroups
                                                on Groups.Group_ID = UserGroups.Group_ID
                                                    and UserGroups.User_ID in (    
                                                        SELECT Users.User_ID
                                                        FROM Users
                                                        WHERE Users.User_ID = '.$this->user_id.' )');

        foreach ($user_groups->result() as $groups){
            array_push($this->groups, $groups->Name);
        }

        //Load Permissions Info ----------------------------------------------------------------------------------------
        $this->permissions = array();

        //Loads Permission's he has access (and where not denied)
        $granted_permissions = $this->CI->db->query('
                                                SELECT Permissions.Name
                                                FROM Permissions
                                                    RIGHT JOIN GroupPermissions
                                                    on Permissions.Permission_ID = GroupPermissions.Permission_ID
                                                        and GroupPermissions.Group_ID in (
                                                            SELECT Groups.Group_ID
                                                            FROM Groups
                                                            RIGHT JOIN UserGroups
                                                            on Groups.Group_ID = UserGroups.Group_ID
                                                                and UserGroups.User_ID in (    
                                                                    SELECT Users.User_ID
                                                                    FROM Users
                                                                    WHERE Users.User_ID = '.$this->user_id.'
                                                                ) 
                                                        )
                                                WHERE NOT Permissions.Permission_ID in (
                                                    SELECT Override_UserPermissions.Permission_ID
                                                    FROM Override_UserPermissions
                                                        LEFT JOIN Users
                                                        ON Override_UserPermissions.User_ID in (
                                                        SELECT Users.User_ID
                                                        FROM Users
                                                        WHERE Users.User_ID = 1
                                                    )
                                                    WHERE NOT Override_UserPermissions.Status = 1
                                                )');

        foreach ($granted_permissions->result() as $granted){
            array_push($this->permissions, $granted->Name);
        }

        // Loads Override Permissions Granted
        $overrided_permissions = $this->CI->db->query('
                                                SELECT Permissions.Name
                                                FROM Permissions
                                                    RIGHT JOIN GroupPermissions
                                                    on Permissions.Permission_ID = GroupPermissions.Permission_ID
                                                        and GroupPermissions.Group_ID in (
                                                            SELECT Groups.Group_ID
                                                            FROM Groups
                                                            RIGHT JOIN UserGroups
                                                            on Groups.Group_ID = UserGroups.Group_ID
                                                                and UserGroups.User_ID in (    
                                                                    SELECT Users.User_ID
                                                                    FROM Users
                                                                    WHERE Users.User_ID = '.$this->user_id.'
                                                                ) 
                                                        )
                                                WHERE Permissions.Permission_ID in (
                                                    SELECT Override_UserPermissions.Permission_ID
                                                    FROM Override_UserPermissions
                                                        LEFT JOIN Users
                                                        ON Override_UserPermissions.User_ID in (
                                                        SELECT Users.User_ID
                                                        FROM Users
                                                        WHERE Users.User_ID = 1
                                                    )
                                                    WHERE Override_UserPermissions.Status = 1
                                                )');

        foreach ($overrided_permissions->result() as $granted){
            array_push($this->permissions, $granted->Name);
        }


        //Checks if it's a reminder token
        if($this->CI->input->cookie('SIDR')){
            $token_info_data = new DateTime($token_info->Creation_Date);

            $token_info_data->modify('+1 day');
            $token_info_data = $token_info_data->format('Y-m-d');


            //If the token creation date is 1 or more days older
            if($token_info_data <= date('Y-m-d')){
                //Destroy old Cookie -----------------------------------------------------------------------------------
                $this->CI->db
                    ->set([ 'Status' => 0])
                    ->where('Token_Key', $this->CI->input->cookie('SID'))
                    ->update('UserTokens');

                delete_cookie('SID');

                //Set new one ------------------------------------------------------------------------------------------
                $cstrong = True;
                $this->token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));


                //Get Device information
                $device_info = $this->CI->agent->is_mobile() == true ? "Mobile: " : "";
                $device_info .=  $this->CI->agent->browser();
                //Add token to the DB
                $this->CI->db
                    ->set([ 'Name' => $device_info,
                            'User_ID' => $this->user_id,
                            'Token_Key' => $this->token])
                    ->insert('UserTokens');

                //Create cookies
                $cookie_time = strtotime(COOKIE_TIME_ACCESS, 0);      //sets cookie token
                $cookie_reminder = strtotime(COOKIE_TIME_ACCESS, 0);  //sets cookie remind me

                set_cookie("SID", $this->token, $cookie_time);
                set_cookie("SIDR", $this->token, $cookie_reminder);
            }
        }

        return AUTHENTICATION_SUCCESS;
    }

    //todo get all OR's made by user
    //todo get all OR's modified by user

    /**
     * @return string
     * returns Store name
     */
    public function get_store_name(){
        return $this->store_name;
    }

    /**
     * @return int userID
     * returns int with the user ID
     */
    public function get_userID(){
        return $this->user_id;
    }

    /**
     * @return string
     * returns username
     */
    public function get_userName()
    {
        return $this->username;
    }

    /**
     * @return string
     * returns the number of unread notifications
     */
    public function get_nr_notifications()
    {
        return $this->notifications_count;
    }

    /**
     * @return array of Notification
     * returns array with the last Notifications
     */
    public function get_last_notifications(){
        return $this->notifications;
    }

    /**
     * @return array strings
     * returns array with the user group names
     */
    public function get_groups(){
        return $this->groups;
    }

    /**
     * @return array strings
     * returns array with the user permissions
     */
    public function get_permissions(){
        return $this->permissions;
    }





}