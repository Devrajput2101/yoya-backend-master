<?php defined('BASEPATH') OR exit('No direct script access allowed');

class SmsModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	/*This function use to get sms template details */
    public function get_template_by_slug($slug){
    	try{
    		$this->db->select('*');
			$this->db->where('slug',$slug);
			$query=$this->db->get($this->db->dbprefix('sms_template'));
			return $query->row_array();
    	} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
        
    }
} 