<?php defined('BASEPATH') OR exit('No direct script access allowed');
class RentalModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function fetch_all($where = null){
		try {
			$this->db->select('rental_id,rental_name,rental_hour_text,rental_distance_text');
			$this->db->from($this->db->dbprefix('rental_packages'));
			if(!empty($where)){
				$this->db->where($where);
			}
			$this->db->where('rental_status','1');
			$this->db->order_by('rental_hour_value','asc');
			$result = $this->db->get();
			return $result;
	   	}catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_single($where = null){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('rental_packages'));
			if(!empty($where)){
				$this->db->where($where);
			}
			$this->db->where('rental_status','1');
			$this->db->order_by('rental_hour_value','asc');
			$result = $this->db->get()->row();
			return $result;
	   	}catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
}