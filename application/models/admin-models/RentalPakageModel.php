<?php defined('BASEPATH') OR exit('No direct script access allowed');

class RentalPakageModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function save($data){
		try {
			$return = $this->db->insert($this->db->dbprefix('rental_packages'),$data);
			return $this->db->insert_id();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function update($where,$data){
		try {
			return $this->db->where($where)->update($this->db->dbprefix('rental_packages'),$data);
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function delete($where){
		try {
			return $this->db->where($where)->delete($this->db->dbprefix('rental_packages'));
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}



	public function fetch_all(){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('rental_packages'));
			$this->db->order_by('rental_id','desc');
			$return = $this->db->get();
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function single($where){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('rental_packages'));
			if(!empty($where)){
				$this->db->where($where);
			}
			$return = $this->db->get()->row();
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function _dropdownlist($where = null){
        try {
	        $this->db->select('');
	        $this->db->from($this->db->dbprefix('rental_packages'));
	        if ($where != "") {
	            $this->db->where($where);
	        }
	        $this->db->where('rental_status','1');
	        $this->db->order_by('rental_hour_value','asc');
	        $query = $this->db->get();
	        $data[''] = '--Select Packages--';
	        foreach ($query->result_array() as $row) {
	            $data[$row['rental_id']] = $row['rental_name'];
	        }
	        return $data;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
    } 
}