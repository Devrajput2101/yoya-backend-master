<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('referral_code')) {
    //The first parameter specifies the type of string, the second parameter specifies the length.
    function referral_code($length = null) {
        if (empty($length)) {
            $length = 6;
        }
        $string = random_string('alpha', $length);
        return strtoupper($string);
    }
}
if (!function_exists('user_name')) {
    //The first parameter specifies the type of string, the second parameter specifies the length.
    function user_name($username) {
        $string = random_string('alpha', 5);
        $string = $string . '@' . substr($username, 0, 5);
        return strtolower($string);
    }
}
if (!function_exists('otp_generate')) {
    //The first parameter specifies the type of string, the second parameter specifies the length.
    function otp_generate() {
        $string = random_string('numeric', 4);
        $string = 1234;
        return $string;
    }
}
if (!function_exists('api_url')) {
    //The first parameter specifies the type of string, the second parameter specifies the length.
    function api_url($file_path) {
        $url = rtrim(base_url(), "/");
        $url = $url . $file_path;
        if (empty($file_path)) {
            $url = '';
        }
        return $url;
    }
}

if (!function_exists('discount_code')) {
    //The first parameter specifies the type of string, the second parameter specifies the length.
    function discount_code($length = null) {
        if (empty($length)) {
            $length = 6;
        }
        $string = random_string('alpha', $length);
        return strtoupper($string);
    }
}

if (!function_exists('image_assets')) {
    function image_assets($id) {
        // Get a reference to the controller object
        $ci = & get_instance();
        $return = '';
        if (!empty($id)) {
            $image = $ci->db->where('id', $id)->get($ci->db->dbprefix('uploads'))->row();
            if (!empty($image)) {
                $return = base_url($image->file_name);
            }
        }
        return $return;
    }
}

//The first parameter specifies the type of date formet, the second parameter specifies the date.
if (!function_exists('dateFormat')) {
    function dateFormat($date = null, $format = 'd M Y H:i') {
        $formetdate = date($format, strtotime($date));
        return $formetdate;
    }
}


//The first parameter specifies the type of date formet, the second parameter specifies the date.
if (!function_exists('api_date_take')) {
    function api_date_take($date = null, $format = 'Y-m-d H:i') {
        $formetdate = date($format, strtotime($date));
        return $formetdate;
    }
}

//The first parameter specifies the type of date formet, the second parameter specifies the date.
if (!function_exists('api_date_give')) {
    function api_date_give($date = null, $format = 'd M Y H:i') {
        $formetdate = date($format, strtotime($date));
        return $formetdate;
    }
}

//The function use for check image exist or not..
if (!function_exists('uploads_image')) {
    function uploads_image($file_path = null) {
        
        if(empty($file_path)){
            return base_url('back-end/images/sample/image.png');exit;
        }

        if (file_exists(ltrim($file_path,'/')) && !is_numeric($file_path)) {
            return base_url($file_path);exit;
        } else if (is_numeric($file_path)) {

            return image_assets($file_path);
        }else {
            return base_url('back-end/images/sample/image.png');exit;

        }
    }
}

//this function use for print ar make curency code 
if (!function_exists('currency_symbols')) {
    function currency_symbols($string = null) {
        if(!empty($string)){
            $string  = $string;  
        }else{
            $string  = '';  
        }
        return $string;
    }
}

//this function use for print and die code
if (!function_exists('dd')) {
    function dd($string = null) {
        print '<pre>';
        print_r($string);
        exit;
    }
}
//this function chek date is vaildate or not 
if (!function_exists('is_old_date')) {
    function is_old_date($date,$current_date = null ) {
        if(empty($current_date)){
            $current_date = date('Y-m-d');
        }
        $current_date = strtotime($current_date);
        $compare_date = strtotime($date);
        if($current_date > $compare_date){
            return true;
        }else{
            return false;
        }
        
    }
}

//this function use for check time and duration     
if (!function_exists('tow_date_compare')) {
    function tow_date_compare($date,$current_date = null ) {
        if(empty($current_date)){
            $current_date = date('Y-m-d H:i');
        }
        $current_date = strtotime($current_date);
        $compare_date = strtotime($date);
        $hourdiff = (round(($current_date - $compare_date)/3600, 1));
        return $hourdiff;
    }
}

//this function use for check time and duration     
if (!function_exists('number_format')) {
    function number_format($number,$decimal = null) {
        if($decimal != null){
            $number = number_format($number,$decimal,",",".");
        }else{
            $number = number_format($number,0,",",".");
        }
        return $number;
    }
}

