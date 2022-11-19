<?php defined('BASEPATH') OR exit('No direct script access allowed');
class RequestModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function save($data){
		try {
			$this->db->set('request_create_at',date('Y-m-d H:i:s'));
			$this->db->set('request_update_at',date('Y-m-d H:i:s'));
			$return = $this->db->insert($this->db->dbprefix('order_request'),$data);
			return $this->db->insert_id();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function update($where,$data){
		try {
			$this->db->set('request_update_at',date('Y-m-d H:i:s'));
			return $this->db->where($where)->update($this->db->dbprefix('order_request'),$data);
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function is_exist($where){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('order_request'));
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

	public function fetch_single($where){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('order_request'));
			$this->db->where($where);
			$return = $this->db->get();
			foreach($return->result() as $key => $data){
				$return->result()[$key]->request_amout_details  = !empty($data->request_amout_details) ? json_decode($data->request_amout_details): ''; 
				$return->result()[$key]->request_drop_locations = $this->DropModel->fetch_drop_point(array('drop_request_id'=>$data->request_id))->result();
			}
			return $return->row();
        
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	
	public function chekc_request_stage($where){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('order_request'));
			$this->db->where($where);
			return $this->db->get();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
}