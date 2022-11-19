<?php defined('BASEPATH') OR exit('No direct script access allowed');

class VehicleTypeModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function fetch_all_vehicle_type(){
		try {
			$this->db->select('vehicle_type_id ,vehicle_type_name,vehicle_type_icon');
			$this->db->from($this->db->dbprefix('vehicles_type'));
			$this->db->where('vehicle_type_status','1');
			$this->db->order_by('vehicle_type_name','asc');
			$return = $this->db->get();

			foreach($return->result() as $key => $data){
				$return->result()[$key]->vehicle_type_icon = image_assets($data->vehicle_type_icon); 
			}
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
} 