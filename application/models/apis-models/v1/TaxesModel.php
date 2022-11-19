<?php defined('BASEPATH') OR exit('No direct script access allowed');
class TaxesModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function fetch_taxes($where){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('taxes'));
			$this->db->where($where);
			$return = $this->db->get();
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
}