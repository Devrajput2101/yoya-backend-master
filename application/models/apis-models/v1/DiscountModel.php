<?php defined('BASEPATH') OR exit('No direct script access allowed');
class DiscountModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function fetch_discount($where){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('discount'));
			$this->db->where($where);
			$return = $this->db->get()->row();
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	
	public function check_duplicate($where){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('discount'));
			$this->db->where($where);
			$checkuser = $this->db->get()->num_rows();
			if($checkuser > 0){
				return true;
			}
			return false;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
}