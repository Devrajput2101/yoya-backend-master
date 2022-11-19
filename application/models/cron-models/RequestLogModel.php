<?php defined('BASEPATH') OR exit('No direct script access allowed');
class RequestLogModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function insert_batch($data){
		try {
			return $this->db->insert_batch($this->db->dbprefix('order_request_logs'),$data);
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
}