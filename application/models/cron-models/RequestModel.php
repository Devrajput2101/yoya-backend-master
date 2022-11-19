<?php defined('BASEPATH') OR exit('No direct script access allowed');
class RequestModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}
	
	public function fetch_recently_request(){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('order_request'));
			$this->db->where('date(request_update_at) >=', date('Y-m-d'));
            $this->db->where('date(request_update_at) <=', date('Y-m-d'));
			$return = $this->db->get();
			return $return->result();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
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

	public function fetch_recently_request_outstation(){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('order_request'));
			$this->db->where('date(request_update_at) >=', date('Y-m-d'));
            $this->db->where('date(request_update_at) <=', date('Y-m-d'));
			$this->db->where('request_status','1');
			$this->db->where('request_mode','outstation');
			$return = $this->db->get();
			return $return->result();
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
				$return->result()[$key]->request_drop_locations = $this->DropModel->fetch_drop_point(array('drop_request_id'=>$data->request_id))->result();
			}
			return $return->row();
        
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
}