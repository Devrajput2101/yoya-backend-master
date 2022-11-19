<?php defined('BASEPATH') OR exit('No direct script access allowed');
class CancelreasonModel extends CI_Model {

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
	
	public function fetch_all($where){
	    try {
			$this->db->select('reason_id,reason_content');
			$this->db->from($this->db->dbprefix('cancel_reason'));
			$this->db->where($where);
			return $this->db->get();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
}