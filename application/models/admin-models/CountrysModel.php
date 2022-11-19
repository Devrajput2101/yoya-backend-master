<?php defined('BASEPATH') OR exit('No direct script access allowed');
class CountrysModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function save($data){
		try {
			$return = $this->db->insert($this->db->dbprefix('country'),$data);
			return $this->db->insert_id();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
   public function update($where,$data){
		try {
			return $this->db->where($where)->update($this->db->dbprefix('country'),$data);
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	
	public function fetch_all_country(){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('country'));
			$this->db->order_by('country_id','desc');
			$return = $this->db->get();
			return $return;
		}catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	public function fetch_country_by_id($country_id){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('country'));
			$this->db->where('country_id',$country_id);
			$checkuser = $this->db->get()->row();
			return $checkuser;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	
	public function get_country($where){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('country'));
			$this->db->where($where);
			return $this->db->get();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function _dropdownlist($where = null){
		try {
	        $this->db->from($this->db->dbprefix('country'));
	        if ($where != "") {
	            $this->db->where($where);
	        }
	        $this->db->where('country_status','1');
	        $this->db->order_by('','asc');
	        $query = $this->db->get();
	        $data[''] = '--Select Country--';
	        foreach ($query->result_array() as $row) {
	            $data[$row['country_id']] = $row['country_name'].' '.$row['country_iso_code'];
	        }
	        return $data;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
    }
} 