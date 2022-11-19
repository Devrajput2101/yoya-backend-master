<?php defined('BASEPATH') OR exit('No direct script access allowed');

class JobprocessCitesModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function save($data){
		try {
			$return = $this->db->insert($this->db->dbprefix('job_process_cities'),$data);
			return $this->db->insert_id();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

    public function update($where,$data){
		try {
			return $this->db->where($where)->update($this->db->dbprefix('job_process_cities'),$data);
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}	

	public function fetch_all(){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('job_process_cities'));
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
			$this->db->from($this->db->dbprefix('job_process_cities'));
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