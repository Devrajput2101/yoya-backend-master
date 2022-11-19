<?php defined('BASEPATH') OR exit('No direct script access allowed');

class OutstationModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

    public function fetch_vehicle_for_ride_where($where){
		try {
			$this->db->select('
				vehicle_id,
				vehicle_name,
				vehicle_icon,
				vehicle_description,
                fare_country_id,
				fare_base_price,
				fare_per_km_price,
				fare_per_minutes_price,
				fare_night_price,
				fare_driver_allowance
				');
			$this->db->from($this->db->dbprefix('vehicles'));
			$this->db->join($this->db->dbprefix('vehicles_outstation_fare'),$this->db->dbprefix('vehicles_outstation_fare').'.fare_vehicle_id ='.$this->db->dbprefix('vehicles').'.vehicle_id','inner');
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
        $booking_date_from = $array['booking_date_from'];
        $booking_date_to = $array['booking_date_to'];
		$total_distance = $array['total_distance'] ;
		$total_time = $array['total_time'];
		$base_price_not_apply_km = 4; // this variable use for befor km. aaply baseprice
		$bookdate = !empty($booking_date_from) ? $booking_date_from : date('Y-m-d H:i');

        $night_time_start   = date('Y-m-d H:i',strtotime(date('Y-m-d').' 17:00')); 
        $night_time_end     = date('Y-m-d H:i',strtotime(date('Y-m-d').' 02:00'));

        $booking_start_date = date('Y-m-d H:i',strtotime($booking_date_from));
        $booking_end_date   = date('Y-m-d H:i',strtotime($booking_date_to));

		$result = $this->fetch_vehicle_for_ride_where($where);
		foreach($result->result() as $key => $data){
			$result->result()[$key]->fare_total_time   = $total_time;
			if(strtotime($night_time_start) <= strtotime($booking_start_date) && strtotime($booking_end_date) >= strtotime($night_time_end)){
				$fare_total_amount = ($total_distance * $data->fare_per_km_price) + $data->fare_driver_allowance + $data->fare_night_price;
			}else{
	            $fare_total_amount = ($total_distance * $data->fare_per_km_price) + $data->fare_driver_allowance;
	        }
            $result->result()[$key]->fare_total_amount = currency_symbols(@$data->country->country_currency_symbols).$fare_total_amount;
            $result->result()[$key]->fare_total_amount_value = $fare_total_amount;
		}
		return $result;
	}
}