<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('asset_url()'))
{
    function assets_url()
    {
        return base_url().'assets';
    }

    function check_numeric_array($array) {
        $allNumeric = true;
        foreach($array as $value) {
            if (!(is_numeric($value))) {
                return false;
            }
        }
        return true;
    }
}

//TODO:: add function to get Menu