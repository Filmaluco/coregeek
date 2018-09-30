<?php
/**
 * Created by PhpStorm.
 * User: FilipeA
 * Date: 9/30/2018
 * Time: 22:51
 */

class CORE_auth
{
    protected $CI;

    // We'll use a constructor, as you can't directly call a function
    // from a property definition.
    public function __construct()
    {
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
    }
}