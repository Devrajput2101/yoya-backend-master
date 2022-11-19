<?php defined('BASEPATH') OR exit('No direct script access allowed');
class RecentsearchModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}
	
	public function fetch_all_order_request_records(){
		try {
			$this->db->select($this->db->dbprefix('order_request').'.*,'.$this->db->dbprefix('users').'.user_name');
			$this->db->from($this->db->dbprefix('order_request'));
			$this->db->join($this->db->dbprefix('users'),$this->db->dbprefix('users').'.user_id ='.$this->db->dbprefix('order_request').'.request_user_id','left');
			$this->db->order_by('request_id','desc');
			$return = $this->db->get();
			return $return;
		}catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_all_order_request_where($where){
		try {
			$this->db->select($this->db->dbprefix('order_request').'.*,'.$this->db->dbprefix('users').'.user_name');
			$this->db->from($this->db->dbprefix('order_request'));
			$this->db->join($this->db->dbprefix('users'),$this->db->dbprefix('users').'.user_id ='.$this->db->dbprefix('order_request').'.request_user_id','left');
			$this->db->where($where);
			$this->db->order_by('request_id','desc');
			$return = $this->db->get();
			return $return;
		}catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
}