<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'libraries/api-libraries/API_Controller.php'; // for load rest controller

class Meter extends API_Controller {
	/**
	 * @method : search()
	 * @date : 2022-07-30
	 * @about: This method use for search vehicle 
	 * */
	public function search(){
		try
    	{	
    		$this->_apiConfig([
	            'methods' => ['POST'],
	            //'key' => ['header',$this->config->item('api_fixe_header_key')],
	        ]);

	        $post = json_decode(file_get_contents('php://input'));
    		if(empty($post->user_id) || !isset($post->user_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_user_id_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->pickup_latitude) || !isset($post->pickup_latitude)){
		        $this->api_return(array('status' =>false,'message' => lang('error_pickup_latitude_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->pickup_longitude) || !isset($post->pickup_longitude)){
		        $this->api_return(array('status' =>false,'message' => lang('error_pickup_longitude_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->pickup_address) || !isset($post->pickup_address)){
		        $this->api_return(array('status' =>false,'message' => lang('error_pickup_address_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->pickup_city) || !isset($post->pickup_city)){
		        $this->api_return(array('status' =>false,'message' => lang('error_pickup_city_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        foreach($post->drop_locations as $key => $data){
	        	if(empty($data->drop_latitude) || !isset($data->drop_latitude)){
			        $this->api_return(array('status' =>false,'message' => lang('error_drop_latitude_missing')),self::HTTP_BAD_REQUEST);exit();
		        }
		        if(empty($data->drop_longitude) || !isset($data->drop_longitude)){
			        $this->api_return(array('status' =>false,'message' => lang('error_drop_longitude_missing')),self::HTTP_BAD_REQUEST);exit();
		        }
		        if(empty($data->drop_address) || !isset($data->drop_address)){
			        $this->api_return(array('status' =>false,'message' => lang('error_drop_address_missing')),self::HTTP_BAD_REQUEST);exit();
		        }
		        if(empty($data->drop_city) || !isset($data->drop_city)){
			        $this->api_return(array('status' =>false,'message' => lang('error_drop_city_missing')),self::HTTP_BAD_REQUEST);exit();
		        }
	        }
	        $user_id = $post->user_id;//this is a driver id 
	        $vehicles = $this->VehicleModel->fetch_vehicle_for_meter_where(array('dv_user_id'=>$user_id));
	        if($vehicles->num_rows() <= 0){
	        	$this->api_return(array('status' =>false,'message' => lang('error_service_not_available')),self::HTTP_BAD_REQUEST);exit();
	        }
	        //count drop stop point and minus last drop point for 
	        //apply drop charge if enable on database 
	        $count_drop = count($post->drop_locations) - 1;
	        //calulate drop point distanse by pickup and destination points
	        //one or multipel drop points count total distance 
	        $total_time_in_minutes = 0;$total_distance = 0;
	        foreach($post->drop_locations as $key => $data){
	        	if($count_drop > 0){
	        		$origin_latitude  = $data->drop_latitude;
	        		$origin_longitude = $data->drop_longitude;
	        	}else{
	        		$origin_latitude  = $post->pickup_latitude;
	        		$origin_longitude = $post->pickup_longitude;
	        	}
	        	//destination lattitude and logintude 
	        	$drop_longitude = $data->drop_longitude;
	        	$drop_latitude  = $data->drop_latitude;
	        	//google map api for fecth distance and time and address in array type
	        	$google_distance = $this->_googole_distance_api($origin_latitude,$origin_longitude,$drop_latitude,$drop_longitude);

	        	//add tile and distance 
	        	$total_time_in_minutes += $google_distance['time_value'];
	        	$total_distance += $google_distance['distance_value'];
	        	//add extra data in drop addray 
	        	$post->drop_locations[$key]->total_time_in_minutes = $total_time_in_minutes; 
	        	$post->drop_locations[$key]->total_distance = $total_distance; 
	        }
	        //vehicle amount calcution 
	        $result = $this->VehicleModel->vehicle_amount_calculate_for_meter(
	        	array('dv_user_id'=>$user_id),
	        	array('total_time'=>$total_time_in_minutes,'total_distance'=>$total_distance));
	        $vehicle = $result->row();
	        //store a search request 
	        $request_data['request_user_id'] = $post->user_id;
	        $request_data['request_pickup_latitude'] = $post->pickup_latitude;
	        $request_data['request_pickup_longitude'] = $post->pickup_longitude;
	        $request_data['request_pickup_address'] = $post->pickup_address;
	        $request_data['request_pickup_city'] = $post->pickup_city;
	        $request_data['request_pickup_city_id'] = $vehicle->fare_city_id;
	        $request_data['request_pickup_state_id'] = $vehicle->fare_state_id;
	        $request_data['request_pickup_country_id'] = $vehicle->fare_country_id;
	        $request_data['request_distance_value'] = $total_distance;
	        $request_data['request_distance_text'] = $total_distance .' Km.';
	        $request_data['request_time_text'] = $total_time_in_minutes . ' minutes';
	        $request_data['request_time_value'] = $total_time_in_minutes;
	        $request_data['request_payments_mode'] = json_encode(['cash']);
	        $request_data['request_booking_date']  = date('Y-m-d H:i:s');
	        $request_data['request_booking_type'] = 'meter_ride';
	        $request_data['request_vehicle_id']   = $vehicle->vehicle_id;
	        $request_data['request_total_amount'] = $vehicle->fare_total_amount;
	        $request_data['request_amout_details'] = @json_encode($vehicle);
	        $request_data['request_status'] = '1'; //for request is pendig or search

	        if($request_id = $this->RequestModel->save($request_data)){
	        	//store a search drop request 
	        	foreach($post->drop_locations as $key => $data){
		        	$drop['drop_latitude'] = $data->drop_latitude;
			        $drop['drop_longitude'] = $data->drop_longitude;
			        $drop['drop_distance_addresses'] = $data->drop_address;
			        $drop['drop_city'] = $data->drop_city;
			        $drop['drop_time_value'] = $data->total_time_in_minutes;
			        $drop['drop_time_text'] = $data->total_time_in_minutes . ' minutes';
			        $drop['drop_distance_value'] = $data->total_distance;
			        $drop['drop_distance_text'] = $data->total_distance .' Km.';
			        $drop['drop_request_id'] = $request_id;
			        $this->DropModel->save($drop);
		        }
	        } 
	        $request = $this->RequestModel->fetch_single(array('request_id'=>$request_id));
	        $return = array(
	        	'vehicle'=>$result->row(),
	        	'request'=> $request
	        );
	        $this->api_return(array('status' =>true,'message' => lang('data_found'),'data'=>$return),self::HTTP_OK);exit();
    	} catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	} 

	/**
	 * @method : confirm()
	 * @date : 2022-08-01
	 * @about: This method use for confirm ride by meter ride
	 * */
	public function confirm(){
	  	try
    	{	
    		$this->_apiConfig([
	            'methods' => ['POST'],
	            //'key' => ['header',$this->config->item('api_fixe_header_key')],
	        ]);
	        $post = json_decode(file_get_contents('php://input'));
    		if(empty($post->request_id) || !isset($post->request_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_request_id_missing')),self::HTTP_BAD_REQUEST);exit();
	        }

	        $checkrequest = $this->BookingModel->fetch_booking(array('booking_request_id'=>$post->request_id));
	        if(!empty($checkrequest)){
	            $this->api_return(array('status' =>false,'message' => "Booking Already Accepted !"),self::HTTP_OK);exit();
	        }

	        $booking_status = $this->BookingModel->booking_status('booking_accepted');
	        $booking_id = $this->BookingModel->booking_id_ganrate();
	        $request = $this->RequestModel->fetch_single(array('request_id'=>$post->request_id));
	        $driver_details = $this->UsersModel->fetch_user_data_for_request_by_id($request->request_user_id);
	        $request_data['request_status'] = 2; //for request is accepted or search
		    $this->RequestModel->update(array('request_id'=>$post->request_id),$request_data);
		        
	        $booking['booking_order_id'] = $booking_id;
	        $booking['booking_user_id'] = $request->request_user_id;
	        $booking['booking_driver_id'] = $request->request_user_id;
	        $booking['booking_driver_details'] = json_encode($driver_details);
	        $booking['booking_vehicle_id'] = $request->request_vehicle_id;
	        $booking['booking_process_id'] = $request->request_process_id;
	        $booking['booking_user_details'] = $request->request_user_details;
	        $booking['booking_total_amount'] = $request->request_total_amount;
	        $booking['booking_amount_details'] = $request->request_coupon_details;
	        $booking['booking_pickup_latitude'] = $request->request_pickup_latitude;
	        $booking['booking_pickup_longitude'] = $request->request_pickup_longitude;
	        $booking['booking_pickup_city'] = $request->request_pickup_city;
	        $booking['booking_pickup_city_id']    = $request->request_pickup_city_id;
	        $booking['booking_pickup_state_id']   = $request->request_pickup_state_id;
	        $booking['booking_pickup_country_id'] = $request->request_pickup_country_id;
	        $booking['booking_pickup_address'] = $request->request_pickup_address;
	        $booking['booking_distance_value'] = $request->request_distance_value;
	        $booking['booking_distance_text'] = $request->request_distance_text;
	        $booking['booking_time_value'] = $request->request_time_value;
	        $booking['booking_time_text'] = $request->request_time_text;
	        $booking['booking_payments_status'] = $request->request_payments_status;
	        $booking['booking_payments_mode'] = $request->request_payments_mode;
	        $booking['booking_transaction_id'] = $request->request_transaction_id;
	        $booking['booking_booking_date'] = date('Y-m-d H:i:s');
	        $booking['booking_types'] = $request->request_booking_type;
	        $booking['booking_status'] = $booking_status['status'];
	        $booking['booking_display_status'] = $booking_status['display_status'];
	        $booking['booking_status_history'] = $booking_status['history'];
	        $booking['booking_otp'] = otp_generate(4);
	        $booking['booking_request_id']  = $request->request_id;

	        if($booking_id = $this->BookingModel->save($booking)){

	            $bookings_status = $this->BookingModel->booking_status('booking_accepted');
		        $bookings['booking_status'] = $booking_status['status'];
		        $bookings['booking_display_status'] = $booking_status['display_status'];
		        $bookings['booking_status_history'] = $booking_status['history'];
		        $this->BookingModel->update(array('booking_id'=>$booking_id),$bookings);

	            foreach($request->request_drop_locations as $key => $data){
		        	$drop['drop_latitude'] = $data->drop_latitude;
			        $drop['drop_longitude'] = $data->drop_longitude;
			        $drop['drop_distance_addresses'] = $data->drop_distance_addresses;
			        $drop['drop_city'] = $data->drop_city;
			        $drop['drop_time_value'] = $data->drop_time_value;
			        $drop['drop_time_text'] = $data->drop_time_text;
			        $drop['drop_distance_value'] = $data->drop_distance_value;
			        $drop['drop_distance_text'] = $data->drop_distance_text;
			        $drop['drop_booking_id'] = $booking_id;
			        $this->BookingDropModel->save($drop);
		        }
	
	            $result = $this->BookingModel->fetch_booking(array('booking_id'=>$booking_id));
	            $this->api_return(array('status' =>true,'message' => lang('request_accepted'),'data'=>$result),self::HTTP_OK);exit();
	        }else{
	            $this->api_return(array('status' =>false,'message' => lang('server_error')),self::HTTP_OK);exit();
	        }
	    } catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	}

	/**
	 * @method : complete()
	 * @date : 2022-08-01
	 * @about: This method use for complete ride by meter ride
	 * */
	public function complete(){
	  	try
    	{	
    		$this->_apiConfig([
	            'methods' => ['POST'],
	            //'key' => ['header',$this->config->item('api_fixe_header_key')],
	        ]);
	        $post = json_decode(file_get_contents('php://input'));
	        if(empty($post->booking_id) || !isset($post->booking_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_booking_id_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->pickup_longitude) || !isset($post->pickup_longitude)){
		        $this->api_return(array('status' =>false,'message' => lang('error_pickup_longitude_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->pickup_latitude) || !isset($post->pickup_latitude)){
		        $this->api_return(array('status' =>false,'message' => lang('error_pickup_latitude_missing')),self::HTTP_BAD_REQUEST);exit();
	        }

	        $booking_id = $post->booking_id;
	        $booking_status = $this->BookingModel->booking_status('booking_completed',$booking_id);
	        
	        $result = $this->BookingModel->fetch_booking(array('booking_id'=>$booking_id));
	        $request_data['request_status'] = 4; //request is complete
	        $this->RequestModel->update(array('request_id'=>$result->booking_request_id),$request_data);
	        $taxes  = $this->TaxesModel->fetch_taxes(array('tax_country_id'=>$result->booking_pickup_country_id))->result();
	        //get direction distance and time 
	        $google_distance = $this->_googole_distance_api(
	        	$result->booking_pickup_latitude,
	        	$result->booking_pickup_longitude,
	        	$post->pickup_longitude,
	        	$post->pickup_latitude
	        	);

	        $vehicle = $this->VehicleModel->vehicle_amount_calculate_for_meter(
	        	array('dv_user_id'=>$result->booking_driver_id),
	        	array('total_time'=>$google_distance['distance_value'],'total_distance'=>$google_distance['time_value']))->row();
	        //
	        $booking['booking_distance_value'] = $google_distance['distance_text'];
	        $booking['booking_distance_text'] = $google_distance['distance_value'];
	        $booking['booking_time_value'] = $google_distance['time_text'];
	        $booking['booking_time_text'] = $google_distance['time_value'];
	        $booking['booking_total_amount'] = $vehicle->fare_total_amount;
	        //
	        $booking['booking_status'] = $booking_status['status'];
	        $booking['booking_display_status'] = $booking_status['display_status'];
	        $booking['booking_status_history'] = $booking_status['history'];

	        
	        //booking total calculation with extra time and Other charge
	        $booking_amount = $vehicle->fare_total_amount;
	        $coupon_amount  = $result->booking_coupon_amount;
	        $discountable_amount = $booking_amount - $coupon_amount;
	        
	        //total booking amount in search time 
	        $amount_details = [array('label'=>'Trip Charge','value'=>(string)round($booking_amount),'is_customer_visible'=>true,'is_driver_visible'=>true)];
	        //if apply discount this booking
	        if($coupon_amount > 0){
	            array_push($amount_details,array('label'=>'Trip Discount','value'=>(string)round($coupon_amount),'is_customer_visible'=>true,'is_driver_visible'=>false));
	        }
	        //tax apply this booking
	        if(count($taxes) > 0){
	            array_push($amount_details,array('label'=>'Befor Tax','value'=>(string)round($discountable_amount),'is_customer_visible'=>true,'is_driver_visible'=>true));
	        }
	        $calculate_tax = 0;
	        $taxes_amount  = 0;
	        foreach($taxes as $key => $data){
	            $calculate_tax = round($discountable_amount / 100 * $data->tax_rate);
	            $taxes_amount  += $calculate_tax;
	            array_push($amount_details,array('label'=>$data->tax_name,'value'=>(string)round($calculate_tax),'is_customer_visible'=>true,'is_driver_visible'=>true));
	        }
	        array_push($amount_details,array('label'=>'Subtotal','value'=>(string)round($discountable_amount + $taxes_amount),'is_customer_visible'=>true,'is_driver_visible'=>true));
	        $booking['booking_amount_details'] = json_encode($amount_details);
	        $booking['booking_tax_amount']     = $taxes_amount;
	        if($this->BookingModel->update(array('booking_id'=>$booking_id),$booking)){
	            //settelment booking amount start
	            $result = $this->BookingModel->fetch_booking(array('booking_id'=>$booking_id));
	            $this->booking_amount_settelment($result);
	            //settelment booking amount end
	            $this->api_return(array('status' =>true,'message' => lang('booking_completed'),'data'=>$result),self::HTTP_OK);exit();
	        }else{
	            $this->api_return(array('status' =>false,'message' => lang('server_error')),self::HTTP_OK);exit();
	        } 
    	}catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	}

	public function booking_amount_settelment($result){
	     $payment_modes = json_decode($result->booking_payments_mode);
	     if(in_array('cash',$payment_modes)){
	         $this->WalletsModel->applied_service_charge($result);
	     }
	 }
}