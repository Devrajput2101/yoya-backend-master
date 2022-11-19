<?php defined('BASEPATH') OR exit('No direct script access allowed');
class VehicleTypeModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function save($data){
		try {
			$return = $this->db->insert($this->db->dbprefix('vehicles_type'),$data);
			return $this->db->insert_id();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}


   public function update($where,$data){
		try {
			return $this->db->where($where)->update($this->db->dbprefix('vehicles_type'),$data);
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	
	public function fetch_all_vehicle_type(){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('vehicles_type'));
			$this->db->order_by('vehicle_type_id','desc');
			$return = $this->db->get();
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_single_customer($user_id){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('customers'));
			$this->db->join($this->db->dbprefix('users'),$this->db->dbprefix('users').'.user_id ='.$this->db->dbprefix('customers').'.customer_user_id','left');
			$this->db->where('customer_user_id',$user_id);
			$return = $this->db->get()->row();
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	
	public function fetch_vehicle_by_id($vehicle_id){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('vehicles_type'));
			$this->db->where('vehicle_type_id',$vehicle_id);
			$checkuser = $this->db->get()->row();
			return $checkuser;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function _dropdownlist($where = null){
        $this->db->select('*');
        if($where != null) {
        	$this->db->where($where);
        }
        $this->db->order_by('vehicle_type_name','asc');
        $query = $this->db->get($this->db->dbprefix('vehicles_type'));
        $data[''] = "--Select Vehicles type--";
        foreach ($query->result_array() as $row) {
            $data[$row['vehicle_type_id']] = $row['vehicle_type_name'];
        }
        return $data;
    }


} 