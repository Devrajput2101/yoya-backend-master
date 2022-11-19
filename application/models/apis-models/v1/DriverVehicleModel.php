<?php defined('BASEPATH') OR exit('No direct script access allowed');
class DriverVehicleModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function save($data){
		try {
			$this->db->set('dv_create_at',date('Y-m-d H:i:s'));
			$this->db->set('dv_update_at',date('Y-m-d H:i:s'));
			$return = $this->db->insert($this->db->dbprefix('drivers_vehicles'),$data);
			return $this->db->insert_id();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function update($where,$data){
		try {
			$this->db->set('dv_update_at',date('Y-m-d H:i:s'));
			return $this->db->where($where)->update($this->db->dbprefix('drivers_vehicles'),$data);
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function check_duplicate($where){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('drivers_vehicles'));
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