<?php defined('BASEPATH') OR exit('No direct script access allowed');

class PackageModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function check_location_service($where){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('vehicles_package_fare'));
			$this->db->join($this->db->dbprefix('vehicles'),$this->db->dbprefix('vehicles').'.vehicle_id ='.$this->db->dbprefix('vehicles_package_fare').'.fare_vehicle_id','inner');
			$this->db->where($where);
			$return = $this->db->get();
			foreach($return->result() as $key => $data){
				$return->result()[$key]->vehicle_icon = image_assets($data->vehicle_icon); 
                $return->result()[$key]->country = $this->CountryModel->_fetch_single(array('country_id'=>$data->fare_country_id));
			}
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function package_amount_calculate($where,$array){
		$total_distance = $array['total_distance'] ;
		$total_time = $array['total_time'];
		$bookdate = !empty($bookdate) ? $bookdate : date('Y-m-d H:i');

        $booking_start_date = date('Y-m-d H:i',strtotime($bookdate));
        $booking_end_date   = date('Y-m-d H:i',strtotime($bookdate));
		$base_price_not_apply_km = 0; // this variable use for befor km. aaply baseprice

        /*=======================get price=====================*/
        $this->db->select('
				vehicle_id,
				vehicle_name,
				vehicle_icon,'.$this->db->dbprefix('vehicles_package_fare').'.*');
		$this->db->from($this->db->dbprefix('vehicles_package_fare'));
		$this->db->join($this->db->dbprefix('vehicles'),$this->db->dbprefix('vehicles').'.vehicle_id ='.$this->db->dbprefix('vehicles_package_fare').'.fare_vehicle_id','left');
		$this->db->where('fare_kilometre_from <',$total_distance);
		$this->db->where('fare_kilometre_to >',$total_distance);
		$this->db->where($where);
		$result = $this->db->get();
		foreach($result->result() as $key => $data){
			$result->result()[$key]->vehicle_icon = image_assets($data->vehicle_icon); 
			$result->result()[$key]->country = $this->CountryModel->_fetch_single(array('country_id'=>$data->fare_country_id));
		}
		/*=======================get price=====================*/

		$total_amount = 0;
		foreach($result->result() as $key => $data){
			$result->result()[$key]->fare_total_time   = $total_time;
			$total_amount = $data->fare_base_price;

	        if($data->fare_kilometre_price > 0){
	        	$total_amount = ($data->fare_kilometre_price * $total_distance) + $data->fare_base_price;
	        }

			$result->result()[$key]->fare_total_amount_value = (string)$total_amount;
	        $result->result()[$key]->fare_total_distance = $total_distance .' Km.';
			$result->result()[$key]->fare_total_amount = currency_symbols(@$data->country->country_currency_symbols).$total_amount;
		}
		return $result;
	}

	public function single($total_distance,$where = null){
		/*=======================get price=====================*/
        $this->db->select('
				vehicle_id,
				vehicle_name,
				vehicle_icon,'.$this->db->dbprefix('vehicles_package_fare').'.*');
		$this->db->from($this->db->dbprefix('vehicles_package_fare'));
		$this->db->join($this->db->dbprefix('vehicles'),$this->db->dbprefix('vehicles').'.vehicle_id ='.$this->db->dbprefix('vehicles_package_fare').'.fare_vehicle_id','left');
		if($total_distance > 0){
			$this->db->where('fare_kilometre_from <',$total_distance);
			$this->db->where('fare_kilometre_to >',$total_distance);
		}
		
		if(!empty($where)){
			$this->db->where($where);
		}

		$result = $this->db->get();
		foreach($result->result() as $key => $data){
			$result->result()[$key]->vehicle_icon = image_assets($data->vehicle_icon); 
			$result->result()[$key]->country = $this->CountryModel->_fetch_single(array('country_id'=>$data->fare_country_id));
		}
		/*=======================get price=====================*/
		return $result->row();
	}
}