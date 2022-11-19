<?php defined('BASEPATH') OR exit('No direct script access allowed');
class DriverModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}


	public function save($data){
		try {
			$this->db->set('driver_create_at',date('Y-m-d H:i:s'));
			$this->db->set('driver_update_at',date('Y-m-d H:i:s'));
			$return = $this->db->insert($this->db->dbprefix('drivers'),$data);
			return $this->db->insert_id();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function under_radius_driver($pickup_latitude,$pickup_longitude,$vehicle_id = null){
		try {
			//Note: The provided distance is in Miles. If you need Kilometers, use 6371 instead of 3959.
	        //To convert to miles, multiply by 3961.
	        //To convert to kilometers, multiply by 6373.
	        //To convert to meters, multiply by 6373000.
	        //To convert to feet, multiply by (3961 * 5280) 20914080.
	        $under_radious = 500;
	    	$this->db->select("user_id,user_name,user_devoice_token,(6371 * acos(cos(radians(".$pickup_latitude.")) * cos( radians(user_latitude)) * cos(radians(user_longitude) - radians(".$pickup_longitude.")) + sin(radians(".$pickup_latitude.")) * sin(radians(user_latitude)))) AS distance");
			$this->db->from($this->db->dbprefix('drivers'));
			$this->db->join($this->db->dbprefix('users'),$this->db->dbprefix('users').'.user_id ='.$this->db->dbprefix('drivers').'.driver_user_id','left');
			$this->db->where('user_type','driver');
			//$this->db->where('user_job_status','1');
			//$this->db->having('distance <='.$under_radious);
			$result  = $this->db->get();
			return $result;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
} 