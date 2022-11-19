<?php defined('BASEPATH') OR exit('No direct script access allowed');
class CustomerModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}


	public function save($data){
		try {
			$return = $this->db->insert($this->db->dbprefix('customers'),$data);
			return $this->db->insert_id();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_all_customer(){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('customers'));
			$this->db->join($this->db->dbprefix('users'),$this->db->dbprefix('users').'.user_id ='.$this->db->dbprefix('customers').'.customer_user_id','left');
			$return = $this->db->get();
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
} 