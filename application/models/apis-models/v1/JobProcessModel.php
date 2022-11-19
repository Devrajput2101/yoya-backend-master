<?php defined('BASEPATH') OR exit('No direct script access allowed');

class JobProcessModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function fetch_all_job_proccess_by_vehicle_type_id($ids = null){
		try {
			$this->db->select($this->db->dbprefix('job_process').'.job_process_id,job_process_name,job_process_icon,job_process_screen');
			$this->db->from($this->db->dbprefix('job_process'));
			$this->db->join($this->db->dbprefix('job_process_vehicle'),$this->db->dbprefix('job_process_vehicle').'.job_process_id ='.$this->db->dbprefix('job_process').'.job_process_id','left');
			$this->db->where($this->db->dbprefix('job_process').'.job_process_status','1');
			$this->db->where_in($this->db->dbprefix('job_process_vehicle').'.vehicle_type_id',$ids);
			$this->db->order_by('job_process_name','asc');
			$return = $this->db->get();

			foreach($return->result() as $key => $data){
				$return->result()[$key]->job_process_icon = image_assets($data->job_process_icon); 
			}
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_all_job_proccess_group(){
		try {
			$this->db->select('job_process_id,job_process_name,job_process_icon,job_process_screen');
			$this->db->from($this->db->dbprefix('job_process'));
			$this->db->where('job_process_status','1');
			$this->db->order_by('job_process_name','asc');
			$this->db->group_by('job_process_name');
			$return = $this->db->get();

			foreach($return->result() as $key => $data){
				$return->result()[$key]->job_process_icon = image_assets($data->job_process_icon); 
			}
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
} 