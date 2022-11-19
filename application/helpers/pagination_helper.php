<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('query_string_pagination')){
    function query_string_pagination($length = null, $current_url = null){
        $ci =& get_instance(); 
        $ci->load->library('pagination');
        $config['base_url']   = current_url();
        $config['page_query_string'] = true;
        $config['total_rows'] = $length;
        $config['per_page']   = 10;
        $config["full_tag_open"]   = '<ul class="pagination justify-content-center">';
        $config["full_tag_close"]  = '</ul>';
        $config["first_tag_open"]  = '<li class="page-item page-link">';
        $config["first_tag_close"] = '</li>';
        $config["last_tag_open"]   = '<li class="page-item page-link">';
        $config["last_tag_close"]  = '</li>';
        $config["next_tag_open"]   = '<li class="page-item page-link">';
        $config["next_tag_close"]  = '</li>';
        $config["prev_tag_open"]   = '<li class="page-item page-link">';
        $config["prev_tag_close"]  = '</li>';
        $config["num_tag_open"]    = '<li class="page-item page-link">';
        $config["num_tag_close"]   = '</li>';
        $config["cur_tag_open"]    = '<li class="page-item active"><a class="page-link">';
        $config["cur_tag_close"]   = '</a></li>';
        $config['first_link']      = "Previous";
        $config['last_link']       = "Next";
        $ci->pagination->initialize($config);
        return @$ci->pagination->create_links();
    }   
}

