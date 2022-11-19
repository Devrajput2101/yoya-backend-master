<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . 'libraries/api-libraries/API_Controller.php'; // for load rest controller
class Package extends API_Controller {
    /**
     * @method : search()
     * @date : 2022-06-17
     * @about: This method use for fetch all vehicles type list with register
     * Package delivery
     */
    public function search() {
        try {
            $this->_apiConfig(['methods' => ['POST'],
                //'key' => ['header',$this->config->item('api_fixe_header_key')],
            ]);
            $post = json_decode(file_get_contents('php://input'));
            if (empty($post->user_id) || !isset($post->user_id)) {
                $this->api_return(array('status' => false, 'message' => lang('error_user_id_missing')), self::HTTP_BAD_REQUEST);
                exit();
            }
            if (empty($post->job_process_id) || !isset($post->job_process_id)) {
                $this->api_return(array('status' => false, 'message' => lang('error_job_process_id_missing')), self::HTTP_BAD_REQUEST);
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
            foreach ($post->drop_locations as $key => $data) {
                if (empty($data->drop_latitude) || !isset($data->drop_latitude)) {
                    $this->api_return(array('status' => false, 'message' => lang('error_drop_latitude_missing')), self::HTTP_BAD_REQUEST);
                    exit();
                }
                if (empty($data->drop_longitude) || !isset($data->drop_longitude)) {
                    $this->api_return(array('status' => false, 'message' => lang('error_drop_longitude_missing')), self::HTTP_BAD_REQUEST);
                    exit();
                }
                if (empty($data->drop_address) || !isset($data->drop_address)) {
                    $this->api_return(array('status' => false, 'message' => lang('error_drop_address_missing')), self::HTTP_BAD_REQUEST);
                    exit();
                }
                if (empty($data->drop_city) || !isset($data->drop_city)) {
                    $this->api_return(array('status' => false, 'message' => lang('error_drop_city_missing')), self::HTTP_BAD_REQUEST);
                    exit();
                }
            }
            //fetch city id by city name this city id use for fetch city wise price
            //get and apply for ride fare
            $cities = $this->CitiesModel->find_cites_by_name(trim($post->pickup_city))->row();
            if (empty($cities)) {
                $this->api_return(array('status' => false, 'message' => lang('error_service_not_available')), self::HTTP_BAD_REQUEST);
                exit();
            }
            //fetch all vehicles and check vehicle is avilable Or not
            $check_result = $this->PackageModel->check_location_service(array('fare_city_id' => $cities->city_id));
            if ($check_result->num_rows() <= 0) {
                $this->api_return(array('status' => false, 'message' => lang('error_service_not_available')), self::HTTP_BAD_REQUEST);
                exit();
            }
            //count drop stop point and minus last drop point for
            //apply drop charge if enable on database
            $count_drop = count($post->drop_locations) - 1;
            //calulate drop point distanse by pickup and destination points
            //one or multipel drop points count total distance
            $total_time_in_minutes = 0;
            $total_distance = 0;
            foreach ($post->drop_locations as $key => $data) {
                if ($count_drop > 0) {
                    $origin_latitude = $data->drop_latitude;
                    $origin_longitude = $data->drop_longitude;
                } else {
                    $origin_latitude = $post->pickup_latitude;
                    $origin_longitude = $post->pickup_longitude;
                }
                //destination lattitude and logintude
                $drop_longitude = $data->drop_longitude;
                $drop_latitude = $data->drop_latitude;
                //google map api for fecth distance and time and address in array type
                $google_distance = $this->_googole_distance_api($origin_latitude, $origin_longitude, $drop_latitude, $drop_longitude);
                //add tile and distance
                $total_time_in_minutes+= $google_distance['time_value'];
                $total_distance+= $google_distance['distance_value'];
                //add extra data in drop addray
                $post->drop_locations[$key]->total_time_in_minutes = $total_time_in_minutes;
                $post->drop_locations[$key]->total_distance = $total_distance;
            }
            //package amount calcution
            $result = $this->PackageModel->package_amount_calculate(
                array(
                    'fare_city_id' => $cities->city_id
                ), array(
                    'total_time' => $total_time_in_minutes,
                    'total_distance' => $total_distance
                )
            );
            //store a search request
            $request_data['request_user_id'] = $post->user_id;
            $request_data['request_process_id'] = $post->job_process_id;
            $request_data['request_pickup_latitude'] = $post->pickup_latitude;
            $request_data['request_pickup_longitude'] = $post->pickup_longitude;
            $request_data['request_pickup_address'] = $post->pickup_address;
            $request_data['request_pickup_city'] = $post->pickup_city;
            $request_data['request_pickup_city_id'] = $cities->city_id;
            $request_data['request_pickup_state_id'] = $cities->city_state_id;
            $request_data['request_pickup_country_id'] = $cities->city_country_id;
            $request_data['request_distance_value'] = $total_distance;
            $request_data['request_distance_text'] = $total_distance . ' Km.';
            $request_data['request_time_text'] = $total_time_in_minutes . ' minutes';
            $request_data['request_time_value'] = $total_time_in_minutes;
            $request_data['request_booking_type'] = 'package';
            if ($request_id = $this->RequestModel->save($request_data)) {
                //store a search drop request
                foreach ($post->drop_locations as $key => $data) {
                    $drop['drop_latitude'] = $data->drop_latitude;
                    $drop['drop_longitude'] = $data->drop_longitude;
                    $drop['drop_distance_addresses'] = $data->drop_address;
                    $drop['drop_city'] = $data->drop_city;
                    $drop['drop_time_value'] = $data->total_time_in_minutes;
                    $drop['drop_time_text'] = $data->total_time_in_minutes . ' minutes';
                    $drop['drop_distance_value'] = $data->total_distance;
                    $drop['drop_distance_text'] = $data->total_distance . ' Km.';
                    $drop['drop_request_id'] = $request_id;
                    $this->DropModel->save($drop);
                }
            }
            $this->api_return(array('status' => true, 'message' => lang('data_found'), 'data' => $result->result(), 'request_id' => $request_id), self::HTTP_OK);  exit;      
        }catch(Exception $e) {
            $this->api_return(array('status' => false, 'message' => $e->getMessage()), self::HTTP_SERVER_ERROR);
            exit();
        }
    }
    /**
     * @method : update()
     * @date : 2022-06-30
     * @about: This method use for update 
     * @package: user sender and reciver details
     * */
    public function update(){
        try
        {
            $this->_apiConfig([
                'methods' => ['POST'],
                //'key' => ['header',$this->config->item('api_fixe_header_key')],
            ]);
            $post = json_decode(file_get_contents('php://input'));
            if(empty($post->request_id) || !isset($post->request_id)){
                $this->api_return(array('status' =>false,'message' => lang('error_user_id_missing')),self::HTTP_BAD_REQUEST);exit();
            }
            
            //check request se
            if(!$this->RequestModel->is_exist(array('request_id'=>$post->request_id))){
                $this->api_return(array('status' =>false,'message' => lang('data_not_found')),self::HTTP_BAD_REQUEST);exit();
            }
            
            $package_data['package_sender_name'] = $post->sender_name;
            $package_data['package_sender_mobile'] = $post->sender_mobile;
            $package_data['package_receiver_name'] = $post->receiver_name;
            $package_data['package_receiver_mobile'] = $post->receiver_mobile;
            $request_data['request_package_details'] = json_encode($package_data);
            if($this->RequestModel->update(array('request_id'=>$post->request_id),$request_data)){
               $this->api_return(array('status' =>true,'message'=>"Request updated !"),self::HTTP_OK);exit();
            }else{
                $this->api_return(array('status' =>false,'message' =>lang('server_error')),self::HTTP_SERVER_ERROR);exit();
            }
        }catch (Exception $e) {
            $this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
        }
    }
     /**
     * @method : request()
     * @date : 2022-08-13
     * @about: This method use for update booking date and send request for package
     */
    public function request() {
        try {
            $this->_apiConfig(['methods' => ['POST'],
            //'key' => ['header',$this->config->item('api_fixe_header_key')],
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
            if(empty($post->payment_method) || !isset($post->payment_method)){
                $this->api_return(array('status' =>false,'message' => lang('error_payment_mode_missing')),self::HTTP_BAD_REQUEST);exit();
            }
            if(empty($post->booking_date) || !isset($post->booking_date)){
                $this->api_return(array('status' =>false,'message' => lang('error_booking_date_missing')),self::HTTP_BAD_REQUEST);exit();
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

            $request_time_value = $request->request_time_value;
            $request_pickup_city_id = $request->request_pickup_city_id;
            $request_distance_value = $request->request_distance_value;
            $vehicle_id = $post->vehicle_id;
            $booking_date_from = $request->request_booking_date;
			$booking_date_to = $request->request_booking_date_to;

            $result = $this->PackageModel->package_amount_calculate(
                array(
                    'vehicle_id'=>$vehicle_id,
                    'fare_city_id' => $request_pickup_city_id
                ), array(
                    'booking_date_from'=>$booking_date_from,
					'booking_date_to'=>$booking_date_to,
                    'total_time' => $request_time_value, 
                    'total_distance' => $request_distance_value
                    )
                )->row();
            if(empty($result)){
                $this->api_return(array('status' =>false,'message' => lang('data_not_found')),self::HTTP_BAD_REQUEST);exit();
            }

            $users = $this->UsersModel->fetch_user_data_for_request_by_id($post->user_id);
            $request_data['request_user_details'] = json_encode($users);
            $request_data['request_payments_mode']= json_encode($post->payment_method);
            $request_data['request_booking_date'] = date("Y-m-d H:i:s",strtotime($post->booking_date));
            $request_data['request_status']       = '1'; //for request is pendig or search
            $request_data['request_vehicle_id']   = $vehicle_id;
            $request_data['request_total_amount'] = @$result->fare_total_amount_value;


            $country_id  = $result->country->country_id;
			$total_amount = $result->fare_total_amount_value;
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
            if($this->RequestModel->update(array('request_id'=>$post->request_id),$request_data)){
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
        }catch(Exception $e) {
            $this->api_return(array('status' => false, 'message' => $e->getMessage()), self::HTTP_SERVER_ERROR);
            exit();
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
                            "screen"        =>"",
                            "data_id"       =>$request_id,
                        ));
            $this->pushnotification->sendMultiple($tokens);
        }
        if(!empty($request_log)){
            $this->RequestLogModel->insert_batch($request_log);
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
                //'key' => ['header',$this->config->item('api_fixe_header_key')],
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
                
            $booking['booking_order_id']               = $booking_id;
            $booking['booking_user_id']                = $request->request_user_id;
            $booking['booking_driver_id']              = $post->user_id;
            $booking['booking_driver_details']         = json_encode($driver_details);
            $booking['booking_vehicle_id']             = $request->request_vehicle_id;
            $booking['booking_process_id']             = $request->request_process_id;
            $booking['booking_user_details']           = $request->request_user_details;
            $booking['booking_total_amount']           = $request->request_total_amount;
            $booking['booking_amount_details']         = json_encode($request->request_amout_details);
            $booking['booking_pickup_latitude']        = $request->request_pickup_latitude;
            $booking['booking_pickup_longitude']       = $request->request_pickup_longitude;
            $booking['booking_pickup_city']            = $request->request_pickup_city;
            $booking['booking_pickup_city_id']         = $request->request_pickup_city_id;
            $booking['booking_pickup_state_id']        = $request->request_pickup_state_id;
            $booking['booking_pickup_country_id']      = $request->request_pickup_country_id;
            $booking['booking_pickup_address']         = $request->request_pickup_address;
            $booking['booking_distance_value']         = $request->request_distance_value;
            $booking['booking_distance_text']          = $request->request_distance_text;
            $booking['booking_time_value']             = $request->request_time_value;
            $booking['booking_time_text']              = $request->request_time_text;
            $booking['booking_payments_status']        = $request->request_payments_status;
            $booking['booking_payments_mode']          = $request->request_payments_mode;
            $booking['booking_transaction_id']         = $request->request_transaction_id;
            $booking['booking_booking_date']           = $request->request_booking_date;
            $booking['booking_types']                  = $request->request_booking_type;
            $booking['booking_status']                 = $booking_status['status'];
            $booking['booking_display_status']         = $booking_status['display_status'];
            $booking['booking_status_history']         = $booking_status['history'];
            $booking['booking_otp']                    = otp_generate(4);
            $booking['booking_request_id']              = $request->request_id;
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
	 * @method : start()
	 * @date : 2022-07-12
	 * @about: This method use for start bokking
	 * 
	 * */
	 public function start(){
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
           if(empty($post->pickup_longitude) || !isset($post->pickup_longitude)){
               $this->api_return(array('status' =>false,'message' => lang('error_pickup_longitude_missing')),self::HTTP_BAD_REQUEST);exit();
           }
           if(empty($post->pickup_latitude) || !isset($post->pickup_latitude)){
               $this->api_return(array('status' =>false,'message' => lang('error_pickup_latitude_missing')),self::HTTP_BAD_REQUEST);exit();
           }
           if(empty($post->booking_otp) || !isset($post->booking_otp)){
               $this->api_return(array('status' =>false,'message' => lang('error_otp_missing')),self::HTTP_BAD_REQUEST);exit();
           }
           $request_id = $post->request_id;
           $result = $this->BookingModel->fetch_booking(array('booking_request_id'=>$request_id));
           if(empty($result)){
               $this->api_return(array('status' =>false,'message' => lang('data_not_found')),self::HTTP_BAD_REQUEST);exit();
           }
           
           if($result->booking_otp == $post->booking_otp){
               $booking_status = $this->BookingModel->booking_status('booking_started',$result->booking_id);
               
               $chekpoint = $this->BookingModel->check_location_distance_point(array('booking_id'=>$result->booking_id,'booking_pickup_latitude'=>$post->pickup_latitude,'booking_pickup_longitude'=>$post->pickup_longitude));
               if($chekpoint->num_rows() <= 0){
                    //$this->api_return(array('status' =>false,'message' => 'You are not at pickup location. Kindly reach at puckup location to pickup the booking !'),self::HTTP_OK);exit;
               }
               
               $booking['booking_status'] = $booking_status['status'];
               $booking['booking_display_status'] = $booking_status['display_status'];
               $booking['booking_status_history'] = $booking_status['history'];
               if($this->BookingModel->update(array('booking_id'=>$result->booking_id),$booking)){
                    $result = $this->BookingModel->fetch_booking(array('booking_id'=>$result->booking_id));
                    $this->api_return(array('status' =>true,'message' => lang('booking_start'),'booking_id'=>$result->booking_id),self::HTTP_OK);exit();
               }else{
                   $this->api_return(array('status' =>false,'message' => lang('server_error')),self::HTTP_OK);exit();
               } 
           }else{
               $this->api_return(array('status' =>false,'message' => lang('error_otp_invaild')),self::HTTP_OK);exit();
           }
       }catch (Exception $e) {
               $this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
       }
    }
    /**
    * @method : complete()
    * @date : 2022-07-18
    * @about: This method use for complte booking
    * */
    public function complete(){
        try
       {	
           $this->_apiConfig([
               'methods' => ['POST'],
               'key' => ['header',$this->config->item('api_fixe_header_key')],
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
           
           $booking['booking_status'] = $booking_status['status'];
           $booking['booking_display_status'] = $booking_status['display_status'];
           $booking['booking_status_history'] = $booking_status['history'];
           //booking total calculation with extra time and Other charge
           $booking_amount = $result->booking_total_amount;
           $coupon_amount  = $result->booking_coupon_amount;
           $booking_vehicle_id = $result->booking_vehicle_id;
           $booking_pickup_city_id = $result->booking_pickup_city_id;
           $discountable_amount = $booking_amount - $coupon_amount;
           //total booking amount in search time 
   
           //get cuntry details 
           $country = $this->CountryModel->_fetch_single(array('country_id'=>$result->booking_pickup_country_id));
           $courrency_code = currency_symbols(@$country->country_currency_symbols);
           //get cuntry details 
           
           /*=================================customer =================================*/
	        $amount_details = [
	        	array(
	        		'label'=>'Trip Charge',
	        		'value'=>$courrency_code.(string)round($booking_amount),
	        		'is_customer_visible'=>true,
	        		'is_driver_visible'=>false
	        	)
	        ];
	        //if apply discount this booking
	        if($coupon_amount > 0){
	            array_push(
	            	$amount_details,
	            	array(
	            		'label'=>'Trip Discount',
	            		'value'=>$courrency_code.(string)round($coupon_amount),
	            		'is_customer_visible'=>true,
	            		'is_driver_visible'=>false
	            	)
	            );
	        }
	        //tax apply this booking
	        if(count($taxes) > 0){
	            array_push(
	            	$amount_details,
	            	array(
	            		'label'=>'Befor Tax',
	            		'value'=>$courrency_code.(string)round($discountable_amount),
	            		'is_customer_visible'=>true,
	            		'is_driver_visible'=>false
	            	)
	            );
	        }

	        $calculate_tax = 0;
	        $taxes_amount  = 0;
	        foreach($taxes as $key => $data){
	            $calculate_tax = round($discountable_amount / 100 * $data->tax_rate);
	            $taxes_amount  += $calculate_tax;
	            array_push(
	            	$amount_details,
	            	array(
	            		'label'=>$data->tax_name,
	            		'value'=>"+".$courrency_code.(string)round($calculate_tax),
	            		'is_customer_visible'=>true,
	            		'is_driver_visible'=>false
	            	)
	            );
	        }
			$taxable_amount = round($discountable_amount + $taxes_amount);
	        array_push(
	        	$amount_details,
	        	array(
	        		'label'=>'Subtotal',
	        		'value'=>$courrency_code.(string)$taxable_amount,
	        		'is_customer_visible'=>true,
	        		'is_driver_visible'=>false
	        	)
	        );
			//TO DO late calculation
			array_push(
	        	$amount_details,
	        	array(
	        		'label'=>'Grand Total',
	        		'value'=>$courrency_code.(string)$taxable_amount,
	        		'is_customer_visible'=>true,
	        		'is_driver_visible'=>false
	        	)
	        );
			/*=================================customer end=================================*/
			/*=================================driver start=================================*/
			array_push(
	        	$amount_details,
	        	array(
	        		'label'=>'Trip Charge',
	        		'value'=>$courrency_code.(string)$taxable_amount,
	        		'is_customer_visible'=>false,
	        		'is_driver_visible'=>true
	        	)
	        );
			$calculate_tax = 0;
	        $taxes_amount  = 0;
	        foreach($taxes as $key => $data){
	            $calculate_tax = round($discountable_amount / 100 * $data->tax_rate);
	            $taxes_amount  += $calculate_tax;
	            array_push(
	            	$amount_details,
	            	array(
	            		'label'=>$data->tax_name,
	            		'value'=>"-".$courrency_code.(string)round($calculate_tax),
	            		'is_customer_visible'=>false,
	            		'is_driver_visible'=>true
	            	)
	            );
	        }
			//fetch service charge and service charge apply start
			$fareCharge = $this->PackageModel->single(
                '0',//distance
	        	array(
					"fare_vehicle_id"=>$booking_vehicle_id,
					"fare_city_id"=>$booking_pickup_city_id
				)
			);
			//service charge apply end
			$service_charges = 0;
			if($fareCharge->fare_commission > 0){
				$service_charges = round($discountable_amount / 100 * $fareCharge->fare_commission);
				array_push(
					$amount_details,
					array(
						'label'=>'Fee',
						'value'=>'-'.$courrency_code.$service_charges,
						'is_customer_visible'=>false,
						'is_driver_visible'=>true
					)
				);
			}else{
				array_push(
					$amount_details,
					array(
						'label'=>'Fee',
						'value'=>'-'.$courrency_code.$service_charges,
						'is_customer_visible'=>false,
						'is_driver_visible'=>true
					)
				);
			}
			$total_trip_ammount = round($discountable_amount) - $service_charges;
			array_push(
	        	$amount_details,
	        	array(
	        		'label'=>'Subtotal',
	        		'value'=>$courrency_code.(string)round($total_trip_ammount),
	        		'is_customer_visible'=>false,
	        		'is_driver_visible'=>true
	        	)
	        );
			array_push(
	        	$amount_details,
	        	array(
	        		'label'=>'Grand Total',
	        		'value'=>$courrency_code.(string)$total_trip_ammount,
	        		'is_customer_visible'=>false,
	        		'is_driver_visible'=>true
	        	)
	        );
			/*=================================driver end=================================*/
       
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
        }else if(in_array('wallets',$payment_modes)){
            $this->WalletsModel->applied_service_charge($result);
            $this->WalletsModel->settelment_booking_amount($result);
            $this->WalletsModel->pay_booking_amount($result);
        }
    }
    /**
    * @method : cancel()
    * @date : 2022-07-19
    * @about: This method use for cancel booking
    * */
    public function cancel(){
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
           if(empty($post->cancelled_by) || !isset($post->cancelled_by)){
               $this->api_return(array('status' =>false,'message' => 'cancelled By missing or empty !'),self::HTTP_BAD_REQUEST);exit();
           }
           
           $booking_id = $post->booking_id;
           if($post->cancelled_by == 'driver'){
               $booking_status = $this->BookingModel->booking_status('booking_cancel_by_driver',$booking_id);
           }else{
               $booking_status = $this->BookingModel->booking_status('booking_cancel_by_customer',$booking_id);
           }
           $result = $this->BookingModel->fetch_booking(array('booking_id'=>$booking_id));
           $request_data['request_status'] = 3; //request is cancel
           $this->RequestModel->update(array('request_id'=>$result->booking_request_id),$request_data);
           //booking total calculation with extra time and Other charge
           $taxes  = $this->TaxesModel->fetch_taxes(array('tax_country_id'=>$result->booking_pickup_country_id))->result();
           $booking_amount = $result->booking_total_amount;
           $coupon_amount  = $result->booking_coupon_amount;
           $booking_vehicle_id = $result->booking_vehicle_id;
           $booking_pickup_city_id = $result->booking_pickup_city_id;
           $discountable_amount = $booking_amount - $coupon_amount;
           //total booking amount in search time 

           //get cuntry details 
           $country = $this->CountryModel->_fetch_single(array('country_id'=>$result->booking_pickup_country_id));
           $courrency_code = currency_symbols(@$country->country_currency_symbols);
           //get cuntry details 

            /*=================================customer =================================*/
	        $amount_details = [
	        	array(
	        		'label'=>'Trip Charge',
	        		'value'=>$courrency_code.(string)round($booking_amount),
	        		'is_customer_visible'=>true,
	        		'is_driver_visible'=>false
	        	)
	        ];
	        //if apply discount this booking
	        if($coupon_amount > 0){
	            array_push(
	            	$amount_details,
	            	array(
	            		'label'=>'Trip Discount',
	            		'value'=>$courrency_code.(string)round($coupon_amount),
	            		'is_customer_visible'=>true,
	            		'is_driver_visible'=>false
	            	)
	            );
	        }
	        //tax apply this booking
	        if(count($taxes) > 0){
	            array_push(
	            	$amount_details,
	            	array(
	            		'label'=>'Befor Tax',
	            		'value'=>$courrency_code.(string)round($discountable_amount),
	            		'is_customer_visible'=>true,
	            		'is_driver_visible'=>false
	            	)
	            );
	        }

	        $calculate_tax = 0;
	        $taxes_amount  = 0;
	        foreach($taxes as $key => $data){
	            $calculate_tax = round($discountable_amount / 100 * $data->tax_rate);
	            $taxes_amount  += $calculate_tax;
	            array_push(
	            	$amount_details,
	            	array(
	            		'label'=>$data->tax_name,
	            		'value'=>"+".$courrency_code.(string)round($calculate_tax),
	            		'is_customer_visible'=>true,
	            		'is_driver_visible'=>false
	            	)
	            );
	        }
			$taxable_amount = round($discountable_amount + $taxes_amount);
	        array_push(
	        	$amount_details,
	        	array(
	        		'label'=>'Subtotal',
	        		'value'=>$courrency_code.(string)$taxable_amount,
	        		'is_customer_visible'=>true,
	        		'is_driver_visible'=>false
	        	)
	        );
			//TO DO late calculation
			array_push(
	        	$amount_details,
	        	array(
	        		'label'=>'Grand Total',
	        		'value'=>$courrency_code.(string)$taxable_amount,
	        		'is_customer_visible'=>true,
	        		'is_driver_visible'=>false
	        	)
	        );
			/*=================================customer end=================================*/
			/*=================================driver start=================================*/
			array_push(
	        	$amount_details,
	        	array(
	        		'label'=>'Trip Charge',
	        		'value'=>$courrency_code.(string)$taxable_amount,
	        		'is_customer_visible'=>false,
	        		'is_driver_visible'=>true
	        	)
	        );
			$calculate_tax = 0;
	        $taxes_amount  = 0;
	        foreach($taxes as $key => $data){
	            $calculate_tax = round($discountable_amount / 100 * $data->tax_rate);
	            $taxes_amount  += $calculate_tax;
	            array_push(
	            	$amount_details,
	            	array(
	            		'label'=>$data->tax_name,
	            		'value'=>"-".$courrency_code.(string)round($calculate_tax),
	            		'is_customer_visible'=>false,
	            		'is_driver_visible'=>true
	            	)
	            );
	        }
			//fetch service charge and service charge apply start
			$fareCharge = $this->PackageModel->single(
                '0',//distance
	        	array(
					"fare_vehicle_id"=>$booking_vehicle_id,
					"fare_city_id"=>$booking_pickup_city_id
				)
			);
			//service charge apply end
			$service_charges = 0;
			if($fareCharge->fare_commission > 0){
				$service_charges = round($discountable_amount / 100 * $fareCharge->fare_commission);
				array_push(
					$amount_details,
					array(
						'label'=>'Fee',
						'value'=>'-'.$courrency_code.$service_charges,
						'is_customer_visible'=>false,
						'is_driver_visible'=>true
					)
				);
			}else{
				array_push(
					$amount_details,
					array(
						'label'=>'Fee',
						'value'=>'-'.$courrency_code.$service_charges,
						'is_customer_visible'=>false,
						'is_driver_visible'=>true
					)
				);
			}
			$total_trip_ammount = round($discountable_amount) - $service_charges;
			array_push(
	        	$amount_details,
	        	array(
	        		'label'=>'Subtotal',
	        		'value'=>$courrency_code.(string)round($total_trip_ammount),
	        		'is_customer_visible'=>false,
	        		'is_driver_visible'=>true
	        	)
	        );
			array_push(
	        	$amount_details,
	        	array(
	        		'label'=>'Grand Total',
	        		'value'=>$courrency_code.(string)$total_trip_ammount,
	        		'is_customer_visible'=>false,
	        		'is_driver_visible'=>true
	        	)
	        );
			/*=================================driver end=================================*/
           
           $booking['booking_amount_details'] = json_encode($amount_details);
           $booking['booking_tax_amount']     = $taxes_amount;
           
           $booking['booking_status'] = $booking_status['status'];
           $booking['booking_display_status'] = $booking_status['display_status'];
           $booking['booking_status_history'] = $booking_status['history'];
           $booking['booking_cancelled_by'] = $post->cancelled_by;
           if($this->BookingModel->update(array('booking_id'=>$booking_id),$booking)){
               $this->api_return(array('status' =>true,'message' => lang('booking_cancelled')),self::HTTP_OK);exit();
           }else{
               $this->api_return(array('status' =>false,'message' => lang('server_error')),self::HTTP_OK);exit();
           } 
       }catch (Exception $e) {
               $this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
       }
   }
}
