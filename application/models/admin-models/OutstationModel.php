<?php defined('BASEPATH') OR exit('No direct script access allowed');
class OutstationModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function save($data){
		try {
			$return = $this->db->insert($this->db->dbprefix('vehicles_outstation_fare'),$data);
			return $this->db->insert_id();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
   	public function update($where,$data){
		try {
			return $this->db->where($where)->update($this->db->dbprefix('vehicles_outstation_fare'),$data);
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	public function delete($where){
		try {
			return $this->db->where($where)->delete($this->db->dbprefix('vehicles_outstation_fare'));
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	public function fetch_all_vehiclefare(){
		try {
			$this->db->select($this->db->dbprefix('vehicles_outstation_fare').'.*,'.$this->db->dbprefix('vehicles').'.vehicle_name,'.$this->db->dbprefix('country').'.country_name,'.$this->db->dbprefix('state').'.state_name,'.$this->db->dbprefix('cities').'.city_name');
			$this->db->from($this->db->dbprefix('vehicles_outstation_fare'));
			$this->db->join($this->db->dbprefix('country'),$this->db->dbprefix('country').'.country_id ='.$this->db->dbprefix('vehicles_outstation_fare').'.fare_country_id','left');
			$this->db->join($this->db->dbprefix('state'),$this->db->dbprefix('state').'.state_id ='.$this->db->dbprefix('vehicles_outstation_fare').'.fare_state_id','left');
			$this->db->join($this->db->dbprefix('cities'),$this->db->dbprefix('cities').'.city_id ='.$this->db->dbprefix('vehicles_outstation_fare').'.fare_city_id','left');
			$this->db->join($this->db->dbprefix('vehicles'),$this->db->dbprefix('vehicles').'.vehicle_id ='.$this->db->dbprefix('vehicles_outstation_fare').'.fare_vehicle_id','left');
			$this->db->order_by('fare_id','desc');
			$return = $this->db->get();
			return $return;
		}catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function single(){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('vehicles_outstation_fare'));
			$this->db->order_by('fare_id','desc');
			if(!empty($where)){
				$this->db->where($where);
			}
			$return = $this->db->get()->row();
			return $return;
		}catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
} 