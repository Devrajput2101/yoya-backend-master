<?php defined('BASEPATH') OR exit('No direct script access allowed');

class JobprocessVehicleModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function save($data){
		try {
			$return = $this->db->insert($this->db->dbprefix('job_process_vehicle'),$data);
			return $this->db->insert_id();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

    public function update($where,$data){
		try {
			return $this->db->where($where)->update($this->db->dbprefix('job_process_vehicle'),$data);
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}	

	public function fetch_all(){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('job_process_vehicle'));
			$this->db->join($this->db->dbprefix('vehicles_type'),$this->db->dbprefix('vehicles_type').'.vehicle_type_id ='.$this->db->dbprefix('job_process_vehicle').'.vehicle_type_id','left');
			$this->db->join($this->db->dbprefix('job_process'),$this->db->dbprefix('job_process').'.job_process_id ='.$this->db->dbprefix('job_process_vehicle').'.job_process_id','left');
			$this->db->order_by('process_id','desc');
			$return = $this->db->get();
			return $return;
		}catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_single($where){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('job_process_vehicle'));
			$this->db->order_by('process_id','desc');
			$this->db->where($where);
			$return = $this->db->get()->row();
			return $return;
		}catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

} 