<?php defined('BASEPATH') OR exit('No direct script access allowed');

class RentalFareModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function fetch_all($where = null){
		try {
			$this->db->select('
				fare_id,
				fare_vehicle_id,
				fare_base_price,
				fare_general_price,
				fare_per_minutes,
				fare_country_id,
				fare_city_id'
				);
			$this->db->from($this->db->dbprefix('rental_package_fare'));
			if(!empty($where)){
				$this->db->where($where);
			}
			$this->db->where('fare_status','1');
			$this->db->order_by('fare_general_price','asc');
			$this->db->order_by('fare_per_minutes','asc');

			$result = $this->db->get();
				foreach ($result->result() as $key => $value) {
					$result->result()[$key]->vehicle = $this->VehicleModel->fetch_vehicle_by_id($value->fare_vehicle_id);
					$result->result()[$key]->country = $this->CountryModel->_fetch_single(array('country_id'=>$value->fare_country_id));
				}
			return $result;
	   	}catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_single($where = null){
		try {
			$this->db->select('
				fare_id,
				fare_vehicle_id,
				fare_base_price,
				fare_general_price,
				fare_per_minutes,
				fare_country_id,
				fare_city_id'
				);
			$this->db->from($this->db->dbprefix('rental_package_fare'));
			if(!empty($where)){
				$this->db->where($where);
			}
			$this->db->where('fare_status','1');
			$this->db->order_by('fare_general_price','asc');
			$this->db->order_by('fare_per_minutes','asc');

			$result = $this->db->get();
				foreach ($result->result() as $key => $value) {
					$result->result()[$key]->vehicle = $this->VehicleModel->fetch_vehicle_by_id($value->fare_vehicle_id);
					$result->result()[$key]->country = $this->CountryModel->_fetch_single(array('country_id'=>$value->fare_country_id));
				}
			return $result->row();
	   	}catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_packages_fare($where = null){
		try {
			$result = $this->RentalModel->fetch_all()->result();	
				foreach($result as $key => $data){
					if(!empty($where)){
						$fare_reults = $this->fetch_all(array('fare_city_id'=>$where['fare_city_id'],'fare_rental_id'=>$data->rental_id))->result();
						$result[$key]->rental_fares = $fare_reults;
						// apply country wise cournecy code
						foreach ($fare_reults as $keys => $value) {
							$fare_reults[$keys]->fare_base_price = currency_symbols(@$value->country->country_currency_symbols).$value->fare_base_price;
							$fare_reults[$keys]->fare_general_price = currency_symbols(@$value->country->country_currency_symbols).$value->fare_general_price;
						}
					}else{
						$result[$key]->rental_fares = $this->fetch_all(array('fare_package_id'=>$data->rental_id))->result();
					}
				}
			return $result;
	   	}catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
}