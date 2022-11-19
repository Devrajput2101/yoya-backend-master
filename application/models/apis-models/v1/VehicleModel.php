<?php defined('BASEPATH') OR exit('No direct script access allowed');

class VehicleModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function fetch_vehicle_for_meter_where($where){
		try {	
			$this->db->select('
				vehicle_id,
				vehicle_name,
				vehicle_icon,
				vehicle_description,
				fare_base_price,
				fare_general_price,
				fare_business_price,
				fare_night_price,
				fare_extra_waiting_price,
				fare_stop_price,
				fare_commission,
				fare_time_free,
				fare_city_id,
				fare_state_id,
				fare_country_id');
			$this->db->from($this->db->dbprefix('vehicles'));
			$this->db->join($this->db->dbprefix('vehicles_fare'),$this->db->dbprefix('vehicles_fare').'.fare_vehicle_id ='.$this->db->dbprefix('vehicles').'.vehicle_id','inner');
			$this->db->where('vehicle_status','1');
			$this->db->where($where);
			$this->db->order_by('vehicle_name','asc');
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

	public function vehicle_amount_calculate_for_meter($where,$array){
		$total_distance = $array['total_distance'] ;
		$total_time = $array['total_time'];
		$base_price_not_apply_km = 4; // this variable use for befor km. aaply baseprice
		$bookdate = !empty($bookdate) ? $bookdate : date('Y-m-d H:i');


        $bussines_time_tart = date('Y-m-d H:i',strtotime(date('Y-m-d').' 10:00'));
        $bussines_time_end  = date('Y-m-d H:i',strtotime(date('Y-m-d').' 17:00'));
        $night_time_start   = date('Y-m-d H:i',strtotime(date('Y-m-d').' 17:00')); 
        $night_time_end     = date('Y-m-d H:i',strtotime(date('Y-m-d').' 02:00'));

        $booking_start_date = date('Y-m-d H:i',strtotime($bookdate));
        $booking_end_date   = date('Y-m-d H:i',strtotime($bookdate));

		$result = $this->fetch_vehicle_for_meter_where($where);
		foreach($result->result() as $key => $data){
			$result->result()[$key]->fare_total_time   = $total_time;

			if(strtotime($bussines_time_tart) <= strtotime($booking_start_date) && strtotime($bussines_time_end) >= strtotime($booking_end_date)){
				$fare_total_amount = $total_distance * $data->fare_base_price;
			}else if(strtotime($night_time_start) <= strtotime($booking_start_date) && strtotime($booking_end_date) >= strtotime($night_time_end)){
				$fare_total_amount = $total_distance * $data->fare_base_price;
			}else{
	            $fare_total_amount = $total_distance * $data->fare_base_price;
	        }
			$result->result()[$key]->fare_total_amount_value = $fare_total_amount;
			$result->result()[$key]->fare_total_amount = currency_symbols(@$data->country->country_currency_symbols).$fare_total_amount;
		}
		return $result;
	}

	public function fetch_vehicle_for_ride_where($where){
		try {
			$this->db->select('
				vehicle_id,
				vehicle_name,
				vehicle_icon,
				vehicle_description,
				fare_base_price,
				fare_general_price,
				fare_business_price,
				fare_night_price,
				fare_extra_waiting_price,
				fare_stop_price,
				fare_commission,
				fare_time_free,
				fare_under_distance,
				fare_country_id');
			$this->db->from($this->db->dbprefix('vehicles'));
			$this->db->join($this->db->dbprefix('vehicles_fare'),$this->db->dbprefix('vehicles_fare').'.fare_vehicle_id ='.$this->db->dbprefix('vehicles').'.vehicle_id','inner');
			$this->db->where('vehicle_status','1');
			$this->db->where($where);
			$this->db->order_by('vehicle_name','asc');
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

	public function vehicle_amount_calculate($where,$array){
		$total_distance = $array['total_distance'] ;
		$total_time = $array['total_time'];
		$base_price_not_apply_km = 0; // this variable use for befor km. aaply baseprice
		$bookdate = !empty($bookdate) ? $bookdate : date('Y-m-d H:i');


        $bussines_time_tart = date('Y-m-d H:i',strtotime(date('Y-m-d').' 10:00'));
        $bussines_time_end  = date('Y-m-d H:i',strtotime(date('Y-m-d').' 17:00'));
        $night_time_start   = date('Y-m-d H:i',strtotime(date('Y-m-d').' 17:00')); 
        $night_time_end     = date('Y-m-d H:i',strtotime(date('Y-m-d').' 02:00'));

        $booking_start_date = date('Y-m-d H:i',strtotime($bookdate));
        $booking_end_date   = date('Y-m-d H:i',strtotime($bookdate));

		$result = $this->fetch_vehicle_for_ride_where($where);
		$calculate_distance = 0;
		foreach($result->result() as $key => $data){
			//total time adding a keys
			$result->result()[$key]->fare_total_distance   = $total_distance;
			$result->result()[$key]->fare_total_time   = $total_time;
			//calculate time wise amount basicly 
			if(strtotime($bussines_time_tart) <= strtotime($booking_start_date) && strtotime($bussines_time_end) >= strtotime($booking_end_date)){
				//here is manipulate distance and not apply charge per km.
				$base_price_not_apply_km = $data->fare_under_distance;
				if($base_price_not_apply_km > $total_distance){
					$fare_total_amount = $data->fare_base_price;
				}else{
					$calculate_distance = $total_distance - $base_price_not_apply_km;
					$fare_total_amount = ($calculate_distance * $data->fare_business_price) + $data->fare_base_price;
				}
			}else if(strtotime($night_time_start) <= strtotime($booking_start_date) && strtotime($booking_end_date) >= strtotime($night_time_end)){
				//here is manipulate distance and not apply charge per km.
				$base_price_not_apply_km = $data->fare_under_distance;
				if($base_price_not_apply_km > $total_distance){
					$fare_total_amount = $data->fare_base_price;
				}else{
					$calculate_distance = $total_distance - $base_price_not_apply_km;
					$fare_total_amount = ($calculate_distance * $data->fare_night_price) + $data->fare_base_price;
				}
			}else{
	            //here is manipulate distance and not apply charge per km.
				$base_price_not_apply_km = $data->fare_under_distance;
				if($base_price_not_apply_km > $total_distance){
					$fare_total_amount = $data->fare_base_price;
				}else{
					$calculate_distance = $total_distance - $base_price_not_apply_km;
					$fare_total_amount = ($calculate_distance * $data->fare_general_price) + $data->fare_base_price;
				}
	        }

			$result->result()[$key]->fare_total_amount_value = $fare_total_amount;
			$result->result()[$key]->fare_total_amount = currency_symbols(@$data->country->country_currency_symbols).$fare_total_amount;
		}
		return $result;
	}
	
	public function fetch_vehicle_fare($where){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('vehicles_fare'));
			$this->db->where($where);
			$return = $this->db->get();
			return $return->row();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	
    public function fetch_vehicle_by_id($vehicle_id){
		try {
			$this->db->select('
				vehicle_id,
				vehicle_name,
				vehicle_icon,
				vehicle_description
				');
			$this->db->from($this->db->dbprefix('vehicles'));
			$this->db->where('vehicle_id',$vehicle_id);
			$return = $this->db->get();
			foreach($return->result() as $key => $data){
				$return->result()[$key]->vehicle_icon = image_assets($data->vehicle_icon); 
			}
			return $return->row();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
} 	
