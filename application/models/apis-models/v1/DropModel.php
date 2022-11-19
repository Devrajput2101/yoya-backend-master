<?php defined('BASEPATH') OR exit('No direct script access allowed');
class DropModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function save($data){
		try {
			$return = $this->db->insert($this->db->dbprefix('order_request_drop'),$data);
			return $this->db->insert_id();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function update($where,$data){
		try {
			return $this->db->where($where)->update($this->db->dbprefix('order_request_drop'),$data);
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_drop_point($where){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('order_request_drop'));
			$this->db->where($where);
			$return = $this->db->get();
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
}