<?php defined('BASEPATH') OR exit('No direct script access allowed');
class VehicleModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function save($data){
		try {
			$return = $this->db->insert($this->db->dbprefix('vehicles'),$data);
			return $this->db->insert_id();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

    public function update($where,$data){
		try {
			return $this->db->where($where)->update($this->db->dbprefix('vehicles'),$data);
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	
	public function fetch_all_vehicle(){
		try {
			$this->db->select($this->db->dbprefix('vehicles').'.*,'.$this->db->dbprefix('vehicles_type').'.vehicle_type_name');
			$this->db->from($this->db->dbprefix('vehicles'));
			$this->db->join($this->db->dbprefix('vehicles_type'),$this->db->dbprefix('vehicles_type').'.vehicle_type_id ='.$this->db->dbprefix('vehicles').'.vehicle_vehicle_type_id','left');
			$this->db->order_by('vehicle_id','desc');
			$return = $this->db->get();
			return $return;
		}catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_vehicle_by_id($vehicle_id){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('vehicles'));
			$this->db->where('vehicle_id',$vehicle_id);
			$checkuser = $this->db->get()->row();
			return $checkuser;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	
    public function _dropdownlist($where = null){
        try {
	        $this->db->select('');
	        $this->db->from($this->db->dbprefix('vehicles'));
	        if ($where != "") {
	            $this->db->where($where);
	        }
	        $this->db->where('vehicle_status','1');
	        $this->db->order_by('','asc');
	        $query = $this->db->get();
	        $data[''] = '--Select Vehicle--';
	        foreach ($query->result_array() as $row) {
	            $data[$row['vehicle_id']] = $row['vehicle_name'];
	        }
	        return $data;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
    }   
	
} 