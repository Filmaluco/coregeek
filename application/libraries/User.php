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
            echo "User does not Exist";
            return LOGIN_ERROR_NON_EXISTENT_USER;
        }

        $user_info = $query->row();

        //Check if its the user correct password
        if(!password_verify($password, $user_info->Password)){
            echo "Incorrect Password";
            return LOGIN_ERROR_PASSWORD;
        }

        $this->store_id = $user_info->Store_ID;
        $this->user_id = $user_info->User_ID;
        $this->username = $user_info->Username;


        //TODO -> Implement:

        $cstrong = True;
        $this->token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));



        $r = $this->CI->db
                          ->set([ 'User_ID' => $this->user_id,
                                  'Token_Key' => $this->token])
                          ->insert('UserTokens');








        //check remember me
            //Add token as cookie (temp)
            //Add token as cookie (remb)
                //Add time cookie (3days)

        return LOGIN_SUCCESS;

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