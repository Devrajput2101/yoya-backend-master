<?php defined('BASEPATH') OR exit('No direct script access allowed');
class StateModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function save($data){
		try {
			$return = $this->db->insert($this->db->dbprefix('state'),$data);
			return $this->db->insert_id();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
   public function update($where,$data){
		try {
			return $this->db->where($where)->update($this->db->dbprefix('state'),$data);
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	
	public function fetch_all_state(){
		try {
			$this->db->select($this->db->dbprefix('state').'.*,'.$this->db->dbprefix('country').'.country_name');
			$this->db->from($this->db->dbprefix('state'));
			$this->db->join($this->db->dbprefix('country'),$this->db->dbprefix('country').'.country_id ='.$this->db->dbprefix('state').'.state_country_id','left');
			$this->db->order_by('state_id','desc');
			$return = $this->db->get();
			return $return;
		}catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	public function fetch_state_by_id($state_id){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('state'));
			$this->db->where('state_id',$state_id);
			$checkuser = $this->db->get()->row();
			return $checkuser;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	
    public function _dropdownlist($where = null){
		try {
	        $this->db->from($this->db->dbprefix('state'));
	        if ($where != "") {
	            $this->db->where($where);
	        }
	        $this->db->where('state_status','1');
	        $this->db->order_by('','asc');
	        $query = $this->db->get();
	        $data[''] = '--Select State--';
	        foreach ($query->result_array() as $row) {
	            $data[$row['state_id']] = $row['state_name'];
	        }
	        return $data;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
    }
	
	    // get state method
    public function getState($country_id) {
    	try{
	        $this->db->select('state_id,state_name,state_country_id');
	        $this->db->from($this->db->dbprefix('state'));
	        $this->db->where('state_country_id',$country_id);
	        $query = $this->db->get();
	        return $query->result_array();
        } catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
    }
} 