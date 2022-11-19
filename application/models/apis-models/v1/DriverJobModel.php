<?php defined('BASEPATH') OR exit('No direct script access allowed');
class DriverJobModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function save($data){
		try {
			$this->db->set('job_create_at',date('Y-m-d H:i:s'));
			$this->db->set('job_update_at',date('Y-m-d H:i:s'));
			$return = $this->db->insert($this->db->dbprefix('drivers_jobprocess'),$data);
			return $this->db->insert_id();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function update($where,$data){
		try {
			$this->db->set('job_update_at',date('Y-m-d H:i:s'));
			return $this->db->where($where)->update($this->db->dbprefix('drivers_jobprocess'),$data);
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
}