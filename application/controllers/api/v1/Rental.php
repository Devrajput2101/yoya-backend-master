<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'libraries/api-libraries/API_Controller.php'; // for load rest controller

class Rental extends API_Controller {
	/**
	 * @method : packages()
	 * @date : 2022-09-25
	 * @about: This method use for fetch packages list
	 * 
	 * */

	public function packages(){
		try
    	{	
    		$this->_apiConfig([
	            'methods' => ['GET'],
	            //'key' => ['header',$this->config->item('api_fixe_header_key')],
	        ]);
    		$results = $this->RentalModel->fetch_all();
    		if($results->num_rows() <= 0){
    			$this->api_return(array('status' =>false,'message' =>lang('data_not_found')),self::HTTP_NOT_FOUND);exit();
    		}
    		$this->api_return(array('status' =>true,'message' =>lang('data_found'),"data"=>$results->result()),self::HTTP_OK);exit();
    	}catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	}

	/**
	 * @method : vehicles()
	 * @date : 2022-09-27
	 * @about: This method use for fetch vehicles fare list
	 * 
	 * */
	public function vehicles(){
		try
    	{	
    		$this->_apiConfig([
	            'methods' => ['POST'],
	            //'key' => ['header',$this->config->item('api_fixe_header_key')],
	        ]);
    		$post = json_decode(file_get_contents('php://input'));
	        if(empty($post->city_name) || !isset($post->city_name)){
		        $this->api_return(array('status' =>false,'message' => lang('error_pickup_city_missing')),self::HTTP_BAD_REQUEST);exit();
	        }

	        $city_name = strtolower($post->city_name);
	        $find_cities = $this->CitiesModel->find_cites_by_name($city_name);
	        if($find_cities->num_rows() <= 0){
	        	$this->api_return(array('status' =>true,'message' => lang('data_not_found'),'data'=>array()),self::HTTP_OK);exit();
	        }
	        $city_id = $find_cities->row()->city_id;

	        $result = $this->RentalFareModel->fetch_packages_fare(array('fare_city_id'=>$city_id));
	        if(empty($result)){
	        	$this->api_return(array('status' =>true,'message' => lang('data_not_found'),'data'=>array()),self::HTTP_OK);exit();
	        }
	        $this->api_return(array('status' =>true,'message' => lang('data_found'),'data'=>$result),self::HTTP_OK);exit();
    	}catch(Exception $e){
    		$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
    	}
	}

	/**
	 * @method : request()
	 * @date : 2022-09-27
	 * @about: This method use for send request for rental
	 * 
	 * */
	public function request(){
		try
    	{	
    		$this->_apiConfig([
	            'methods' => ['POST'],
	            //'key' => ['header',$this->config->item('api_fixe_header_key')],
	        ]);
    		$post = json_decode(file_get_contents('php://input'));
            if (empty($post->user_id) || !isset($post->user_id)) {
                $this->api_return(array('status' => false, 'message' => lang('error_user_id_missing')), self::HTTP_BAD_REQUEST);
                exit();
            }
            if (empty($post->pickup_latitude) || !isset($post->pickup_latitude)) {
                $this->api_return(array('status' => false, 'message' => lang('error_pickup_latitude_missing')), self::HTTP_BAD_REQUEST);
                exit();
            }
            if (empty($post->pickup_longitude) || !isset($post->pickup_longitude)) {
                $this->api_return(array('status' => false, 'message' => lang('error_pickup_longitude_missing')), self::HTTP_BAD_REQUEST);
                exit();
            }
            if (empty($post->pickup_address) || !isset($post->pickup_address)) {
                $this->api_return(array('status' => false, 'message' => lang('error_pickup_address_missing')), self::HTTP_BAD_REQUEST);
                exit();
            }
            if (empty($post->pickup_city) || !isset($post->pickup_city)) {
                $this->api_return(array('status' => false, 'message' => lang('error_pickup_city_missing')), self::HTTP_BAD_REQUEST);
                exit();
            }
            if(empty($post->payment_method) || !isset($post->payment_method)){
		        $this->api_return(array('status' =>false,'message' => lang('error_payment_mode_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->booking_date) || !isset($post->booking_date)){
		        $this->api_return(array('status' =>false,'message' => lang('error_booking_date_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->vehicle_id) || !isset($post->vehicle_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_vehicle_type_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->city_id) || !isset($post->city_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_vehicle_type_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        $city_id = $post->city_id;
	        //fetch city id by city name this city id use for fetch city wise price 
	        //get and apply for ride fare 
	        $cities = $this->CitiesModel->fetch_single(array('city_id'=>$city_id))->row();
	        if(empty($cities)){
	        	$this->api_return(array('status' =>false,'message' => lang('error_service_not_available')),self::HTTP_BAD_REQUEST);exit();
	        }
	        //fetch single package details 
	        $rental_id = $post->rental_id;
	        $rental = $this->RentalModel->fetch_single(array('rental_id'=>$rental_id));
	        if(empty($cities)){
	        	$this->api_return(array('status' =>false,'message' =>"invalid rental package id !"),self::HTTP_BAD_REQUEST);exit();
	        }
	        //get package fare 
	        $result = $this->RentalFareModel->fetch_single(
	        	array(
	        		'fare_city_id'=>$city_id,
	        		'fare_rental_id'=>$rental_id
	        	)
	        );
	        if(empty($result)){
	        	$this->api_return(array('status' =>false,'message' =>"fare data not found !"),self::HTTP_BAD_REQUEST);exit();
	        }
	        $total_distance = $rental->rental_distance_value;
	        $total_time  	= $rental->rental_hour_value * 60; //canvert hour to minutes
	        $base_price = $result->fare_base_price;
			$country_id  = $result->country->country_id;
			//amount details manipulation
			$total_amount = $base_price;
			$courrency_code = currency_symbols(@$result->country->country_currency_symbols);
			$amount_details = [
	        	array(
	        		'label'=>'Base Fare',
	        		'value'=>$courrency_code.(string)round($result->fare_base_price),
	        		'is_customer_visible'=>true,
	        		'is_driver_visible'=>true
	        	)
	        ];
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
	        $request_data['request_user_id'] = $post->user_id;
	        $request_data['request_pickup_latitude'] = $post->pickup_latitude;
	        $request_data['request_pickup_longitude'] = $post->pickup_longitude;
	        $request_data['request_pickup_address'] = $post->pickup_address;
	        $request_data['request_pickup_city'] = $post->pickup_city;
	        $request_data['request_pickup_city_id'] = $cities->city_id;
	        $request_data['request_pickup_state_id'] = $cities->city_state_id;
	        $request_data['request_pickup_country_id'] = $cities->city_country_id;
	        $request_data['request_distance_value'] = $total_distance;
	        $request_data['request_distance_text'] = $total_distance .' Km.';
	        $request_data['request_time_text'] = $total_time . ' minutes';
	        $request_data['request_time_value'] = $total_time;
	        $request_data['request_vehicle_id']   = $post->vehicle_id;
	        $request_data['request_payments_mode']   = json_encode($post->payment_method);
	        $request_data['request_total_amount'] = $base_price;
	        $request_data['request_package_details'] = json_encode(array('rental_id'=>$rental_id,'city_id'=>$city_id));
	        $request_data['request_mode'] = 'rental_cab';
	        $request_data['request_booking_type'] = 'current_ride';
	        $request_data['request_booking_date'] = $post->booking_date;
	        $request_data['request_status'] = 1;
			
	        if($request_id = $this->RequestModel->save($request_data)){
	        	if(in_array('cash',$post->payment_method,true)){
		        	/*==============================================
		        	  ===================send request===============*/
		        	  $this->under_radius_send_request($request_id);
		        	/*==============================================
		        	  ===================send request===============*/
		        	$result = $this->RequestModel->fetch_single(array('request_id'=>$request_id));
	        		$this->api_return(array('status' =>true,'message' => lang('ride_request_send'),'data'=>$result,'request_id'=>$request_id),self::HTTP_OK);exit();
		        }else{
		        	$this->api_return(array('status' =>false,'message' =>lang('server_error')),self::HTTP_SERVER_ERROR);exit();
		        }
	        }else{
	        	$this->api_return(array('status' =>false,'message' => lang('server_error')),self::HTTP_SERVER_ERROR);exit();
	        }
    	}catch(Exception $e){
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
		$vehicle_id      = $result->request_vehicle_id;

		$drivers = $this->DriverModel->under_radius_driver(
			$pickup_latitude,
			$pickup_longitude,
			$vehicle_id
		);

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
    	                    "screen" 		=>"",
    	                    "data_id"		=>$request_id,
    	                ));
    	    $this->pushnotification->sendMultiple($tokens);
		}
		if(!empty($request_log)){
		    $this->RequestLogModel->insert_batch($request_log);
		}
	}
}