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
     * allows acess to codeIgniter framework
     */
    protected $CI;

    /**
     * @var int
     * User Store ID
     */
    protected $store_id = "Not Defined";

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
        $this->CI->load->helper('cookie');
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

        $cookie_time = strtotime('3 days', 0);      //sets cookie expiration date if not remember me
        $cookie_reminder = strtotime('2 days', 0);  //sets cookie refresh reminder timer (every 1 day refresh the token)

        $https = ENVIRONMENT == 'development' ? false : true;

        //Add token cookie
        if($remember_me){
            set_cookie("SID", $this->token, $cookie_time);
            set_cookie("SIDR", true, $cookie_reminder);
        }else{
           set_cookie("SID", $this->token, 0);
        }

        return LOGIN_SUCCESS;

    }

    public function logout(){
        delete_cookie('SID');
        delete_cookie('SIDR');
    }


    /**
     * @return string
     * returns username
     */
    public function getUserName()
    {
        return $this->username;
    }

    /**
     * @return string
     * returns the number of unread notifications
     */
    public function getNumberOfNotifications()
    {
        return $this->notifications_count;
    }

    //TODO:: shit ton (check evernote)


}