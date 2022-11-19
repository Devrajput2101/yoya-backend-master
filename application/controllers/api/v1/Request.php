<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'libraries/api-libraries/API_Controller.php'; // for load rest controller

class Request extends API_Controller {
    	/**
	 * @method : vehicle_update()
	 * @date : 2022-06-30
	 * @about: This method use for vehicle_update 
	 * 
	 * */
	public function vehicle_update(){
		try
    	{
    		$this->_apiConfig([
	            'methods' => ['POST'],
	            'key' => ['header',$this->config->item('api_fixe_header_key')],
	        ]);
	        $post = json_decode(file_get_contents('php://input'));
    		if(empty($post->user_id) || !isset($post->user_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_user_id_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->request_id) || !isset($post->request_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_user_id_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->vehicle_id) || !isset($post->vehicle_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_vehicle_type_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
            $request_id = $post->request_id;
	        //check request se
	        if(!$this->RequestModel->is_exist(array('request_id'=>$request_id))){
	        	$this->api_return(array('status' =>false,'message' => lang('data_not_found')),self::HTTP_BAD_REQUEST);exit();
	        }
	        
	        $request = $this->RequestModel->fetch_single(array('request_id'=>$request_id));
	        if(empty($request)){
	            $this->api_return(array('status' =>false,'message' =>lang('server_error')),self::HTTP_SERVER_ERROR);exit();
	        }
	        
	        $cities = $this->CitiesModel->find_cites_by_name(trim($request->request_pickup_city))->row();
	        if(empty($cities)){
	            $this->api_return(array('status' =>false,'message' =>lang('server_error')),self::HTTP_SERVER_ERROR);exit();
	        }
			$vehicle_id = $post->vehicle_id;
            //vehicle amount calcution 
	        $result = $this->VehicleModel->vehicle_amount_calculate(
	        	array(
					'vehicle_id'=>$vehicle_id,
					'fare_city_id'=>@$cities->city_id
				),
	        	array(
					'total_time'=>@$request->request_time_value,
					'total_distance'=>@$request->request_distance_value
				),
				)->row();
	        if(empty($result)){
	            $this->api_return(array('status' =>false,'message' =>lang('server_error')),self::HTTP_SERVER_ERROR);exit();
	        }
			
			//amount details and taxs ====================================================
			$country_id  = $result->country->country_id;
			//amount details manipulation ================================================
			$total_amount = $result->fare_total_amount_value;
			$courrency_code = currency_symbols(@$result->country->country_currency_symbols);
			$amount_details = [
	        	array(
	        		'label'=>'Base Fare',
	        		'value'=>$courrency_code.(string)round($result->fare_base_price),
	        		'is_customer_visible'=>true,
	        		'is_driver_visible'=>true
				),
				array(
	        		'label'=>'Trip',
	        		'value'=>$courrency_code.(string)round($total_amount),
	        		'is_customer_visible'=>true,
	        		'is_driver_visible'=>true
	        	)
	        ];
			//service charge apply 
			if($result->fare_commission > 0){
				$service_charges = round($total_amount / 100 * $result->fare_commission);
				array_push(
					$amount_details,
					array(
						'label'=>'Fee',
						'value'=>$courrency_code.$service_charges,
						'is_customer_visible'=>false,
						'is_driver_visible'=>true
					)
				);
			}
			$taxes  = $this->TaxesModel->fetch_taxes(array('tax_country_id'=>$country_id))->result();
			//tax apply this booking
	        $calculate_tax = 0;
	        $taxes_amount  = 0;
	        foreach($taxes as $key => $data){
	            $calculate_tax = round($total_amount / 100 * $data->tax_rate);
	            $taxes_amount  += $calculate_tax;
	        }
			if($taxes_amount > 0){
				array_push(
					$amount_details,
					array(
						'label'=>'Taxes',
						'value'=>$courrency_code.(string)round($taxes_amount),
						'is_customer_visible'=>true,
						'is_driver_visible'=>false
					)
				);
			}
			$request_data['request_amout_details'] = json_encode($amount_details);
			$total_amount = $total_amount;
			//amount details manipulation ===================================================
	        $users = $this->UsersModel->fetch_user_data_for_request_by_id($post->user_id);
	        $request_data['request_user_details'] = json_encode($users);
	        $request_data['request_booking_type'] = 'current_ride';
	        $request_data['request_vehicle_id']   = $post->vehicle_id;
	        $request_data['request_total_amount'] = $total_amount;
			$request_data['request_tax_amount'] = $taxes_amount; //for request is pendig or search
	        $request_data['request_status'] = '1'; //for request is pendig or search
			
	        if($this->RequestModel->update(array('request_id'=>$post->request_id),$request_data)){
		        $this->api_return(array('status' =>true,'message' =>lang('ride_request_send'),'request_id'=>$post->request_id),self::HTTP_OK);exit();
	        }else{
	        	$this->api_return(array('status' =>false,'message' =>lang('server_error')),self::HTTP_SERVER_ERROR);exit();
	        }
    	}catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	}
	/**
	 * @method : update()
	 * @date : 2022-06-30
	 * @about: This method use for update time and payment methods 
	 * 
	 * */
	public function update(){
		try
    	{
    		$this->_apiConfig([
	            'methods' => ['POST'],
	            'key' => ['header',$this->config->item('api_fixe_header_key')],
	        ]);
	        $post = json_decode(file_get_contents('php://input'));
    		if(empty($post->user_id) || !isset($post->user_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_user_id_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->request_id) || !isset($post->request_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_user_id_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->payment_method) || !isset($post->payment_method)){
		        $this->api_return(array('status' =>false,'message' => lang('error_payment_mode_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->booking_date) || !isset($post->booking_date) || is_old_date($post->booking_date)){
		        $this->api_return(array('status' =>false,'message' => lang('error_booking_date_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->vehicle_id) || !isset($post->vehicle_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_vehicle_type_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
			$request_id = $post->request_id;
	        //check request se
	        if(!$this->RequestModel->is_exist(array('request_id'=>$request_id))){
	        	$this->api_return(array('status' =>false,'message' => lang('data_not_found')),self::HTTP_BAD_REQUEST);exit();
	        }
			
	        $request_data['request_payments_mode']= json_encode($post->payment_method);
	        $request_data['request_booking_date'] = date("Y-m-d H:i:s",strtotime($post->booking_date));
	        $request_data['request_booking_type'] = 'current_ride';
	        $request_data['request_vehicle_id'] = $post->vehicle_id;
            $request_data['request_status'] 	= '1'; //for request is pendig or search

	        if($this->RequestModel->update(array('request_id'=>$request_id),$request_data)){
	        	if(in_array('cash',$post->payment_method,true)){
		        	/*==============================================
		        	  ===================send request===============*/
		        	  $this->under_radius_send_request($post->request_id);
		        	/*==============================================
		        	  ===================send request===============*/
		        	$this->api_return(array('status' =>true,'message' =>lang('ride_request_send'),'request_id'=>$post->request_id),self::HTTP_OK);exit();
		        }else if(in_array('wallets',$post->payment_method,true)){
		        	/*==============================================
		        	  ===================send request===============*/
		        	  $this->under_radius_send_request($post->request_id);
		        	/*==============================================
		        	  ===================send request===============*/
		        	$this->api_return(array('status' =>true,'message' =>lang('ride_request_send'),'request_id'=>$post->request_id),self::HTTP_OK);exit();
		        }else{
		        	$this->api_return(array('status' =>false,'message' =>lang('server_error')),self::HTTP_SERVER_ERROR);exit();
		        }
	        }else{
	        	$this->api_return(array('status' =>false,'message' =>lang('server_error')),self::HTTP_SERVER_ERROR);exit();
	        }
    	}catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	}
	/**
	 * @method : under_radius_send_request()
	 * @date : 2022-06-30
	 * @about: This method use for send request 
	 * */
	public function under_radius_send_request($request_id){
		$result = $this->RequestModel->fetch_single(array('request_id'=>$request_id));
		$pickup_latitude = $result->request_pickup_latitude;
		$pickup_longitude= $result->request_pickup_longitude;

		$drivers = $this->DriverModel->under_radius_driver($pickup_latitude,$pickup_longitude);
		$request_log   = array();
		$tokens   = array();
		foreach($drivers->result() as $key => $data){
	        array_push($tokens,$data->user_devoice_token);
	        array_push($request_log,array(
	        	'log_request_id'=>$request_id,
	        	'log_user_id'=>$data->user_id,
	        	'log_user_name'=>$data->user_name,
	        	'log_create_at'=>date("Y-m-d H:i:s"),
	        	'log_user_by'=>$result->request_user_id
	        ));
		}
		
		if(!empty($tokens)){
		    $this->load->library('pushnotification/pushnotification');
    	    $config['notification_serverkey'] = $this->data['config']['google_fcm_key'];
    	    
    	    $this->pushnotification->initialize($config);
    		$this->pushnotification->subject("New Ride Request Recived !");
    	        $this->pushnotification->message("New Ride Request Recived !");
    	        $this->pushnotification->data(
    	                array(
    	                    "click_action"  =>"FLUTTER_NOTIFICATION_CLICK",
    	                    "sound"         =>"default", 
    	                    "screen" 		=>"cab",
    	                    "data_id"		=>$request_id,
    	                ));
    	    $this->pushnotification->sendMultiple($tokens);
		}
		if(!empty($request_log)){
		    $this->RequestLogModel->insert_batch($request_log);
		}
		
	}

	/**
	 * @method : driver_request_log()
	 * @date : 2022-08-01
	 * @about: This method use for fetch driver request log
	 * */
	public function driver_request_log(){
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
	        $result = $this->RequestLogModel->fetch_request_log(array('log_user_id'=>$post->user_id));
	        if($result->num_rows() <= 0){
		        $this->api_return(array('status' =>false,'message' => lang('data_not_found')),self::HTTP_BAD_REQUEST);exit();
	        }
	        $this->api_return(array('status' =>true,'message' => lang('data_found'),'data'=>$result->result()),self::HTTP_OK);exit();
	    }catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	}
	/**
	 * @method : accepte()
	 * @date : 2022-08-01
	 * @about: This method use for accepte driver request
	 * */
	public function accepte(){
		try
    	{
    		$this->_apiConfig([
	            'methods' => ['POST'],
	            'key' => ['header',$this->config->item('api_fixe_header_key')],
	        ]);
	        $post = json_decode(file_get_contents('php://input'));
    		if(empty($post->user_id) || !isset($post->user_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_user_id_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->request_id) || !isset($post->request_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_request_id_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        //check request se
	        if(!$this->RequestModel->is_exist(array('request_id'=>$post->request_id))){
	        	$this->api_return(array('status' =>false,'message' => lang('data_not_found')),self::HTTP_BAD_REQUEST);exit();
	        }
	        
	        $checkrequest = $this->BookingModel->fetch_booking(array('booking_request_id'=>$post->request_id));
	        if(!empty($checkrequest)){
	            $this->api_return(array('status' =>false,'message' => "Booking Already Accepted !"),self::HTTP_OK);exit();
	        }
	        
	        $booking_status = $this->BookingModel->booking_status('booking_accepted');
	        $booking_id = $this->BookingModel->booking_id_ganrate();
	        $request = $this->RequestModel->fetch_single(array('request_id'=>$post->request_id));
	        $driver_details = $this->UsersModel->fetch_user_data_for_request_by_id($post->user_id);
	        
	        $request_data['request_status'] = 2; //for request is accepted or search
		    $this->RequestModel->update(array('request_id'=>$post->request_id),$request_data);
		    
	        $booking['booking_order_id'] = $booking_id;
	        $booking['booking_user_id'] = $request->request_user_id;
	        $booking['booking_driver_id'] = $post->user_id;
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
	        $booking['booking_booking_date'] = $request->request_booking_date;
	        $booking['booking_types'] = $request->request_booking_type;
	        $booking['booking_status'] = $booking_status['status'];
	        $booking['booking_display_status'] = $booking_status['display_status'];
	        $booking['booking_status_history'] = $booking_status['history'];
	        $booking['booking_otp'] = otp_generate(4);
	        $booking['booking_request_id']  = $request->request_id;
			$booking['booking_tax_amount']  = $request->request_tax_amount;

	        if($booking_id = $this->BookingModel->save($booking)){
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
	    }catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	}
	/**
	 * @method : index()
	 * @date : 2022-07-12
	 * @about: This method use for fetch request details by request id
	 * */
	 public function index(){
	     try
    	{
    		$this->_apiConfig([
	            'methods' => ['POST'],
	            'key' => ['header',$this->config->item('api_fixe_header_key')],
	        ]);
	        $post = json_decode(file_get_contents('php://input'));
	        if(empty($post->request_id) || !isset($post->request_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_user_id_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
            $request_id = $post->request_id;
	        //check request se
	        if(!$this->RequestModel->is_exist(array('request_id'=>$request_id))){
	        	$this->api_return(array('status' =>false,'message' => lang('data_not_found')),self::HTTP_BAD_REQUEST);exit();
	        }
	        
	        $request = $this->RequestModel->fetch_single(array('request_id'=>$request_id));
	        $request->request_discountable_amount = $request->request_total_amount - $request->request_coupon_amount;
		    $this->api_return(array('status' =>true,'message' =>lang('data_found'),'data'=>$request),self::HTTP_OK);exit();
    	}catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	 }
	 
	 /**
	 * @method : cancel()
	 * @date : 2022-07-28
	 * @about: This method use for fetch request details by request id
	 * */
	 public function cancel(){
	     try
    	{
    		$this->_apiConfig([
	            'methods' => ['POST'],
	            'key' => ['header',$this->config->item('api_fixe_header_key')],
	        ]);
	        $post = json_decode(file_get_contents('php://input'));
	        if(empty($post->request_id) || !isset($post->request_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_user_id_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
            $request_id = $post->request_id;
	        //check request se
	        if(!$this->RequestModel->is_exist(array('request_id'=>$request_id))){
	        	$this->api_return(array('status' =>false,'message' => lang('data_not_found')),self::HTTP_BAD_REQUEST);exit();
	        }
	        
	        $request_data['request_status'] = 3; //for request is pendig or search
		    $this->RequestModel->update(array('request_id'=>$request_id),$request_data);
		    $this->api_return(array('status' =>true,'message' =>'Request cancelled !'),self::HTTP_OK);exit();
    	}catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	 }
}