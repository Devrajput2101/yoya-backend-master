<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('is_logged_out')){
    function is_logged_out(){
        // Get a reference to the controller object
        $ci =& get_instance();
        $session = $ci->session->has_userdata('user_id');
        if(!$session){
        	redirect('admin/login', 'refresh');
        }
    }   
}


if (!function_exists('is_logged_in')){
    function is_logged_in(){
        // Get a reference to the controller object
        $ci =& get_instance();
        $session = $ci->session->has_userdata('user_id');
        if($session){
        	redirect('admin/dashboard', 'refresh');
        }
    }   
}