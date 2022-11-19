<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'libraries/api-libraries/API_Controller.php'; // for load rest controller

class Vehicles extends API_Controller {
	/**
	 * @method : index()
	 * @date : 2022-06-17
	 * @about: This method use for fetch all vehicles type list
	 * 
	 * */
	public function index(){
		try
    	{	
    		$this->_apiConfig([
	            'methods' => ['GET'],
	            'key' => ['header',$this->config->item('api_fixe_header_key')],
	        ]);
    		$results = $this->VehicleTypeModel->fetch_all_vehicle_type();
    		if($results->num_rows() <= 0){
    			$this->api_return(array('status' =>false,'message' =>"Data Not Found !"),self::HTTP_OK);exit();
    		}
    		$this->api_return(array('status' =>true,'message' =>"Data Found !","data"=>$results->result()),self::HTTP_OK);exit();
    	}catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	}
	/**
	 * @method : search()
	 * @date : 2022-06-17
	 * @about: This method use for search all vehicles
	 * */
	public function search(){
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
	        if(empty($post->job_process_id) || !isset($post->job_process_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_job_process_id_missing')),self::HTTP_BAD_REQUEST);exit();
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

	        //fetch city id by city name this city id use for fetch city wise price 
	        //get and apply for ride fare 
	        $cities = $this->CitiesModel->find_cites_by_name(trim($post->pickup_city))->row();
	        if(empty($cities)){
	        	$this->api_return(array('status' =>false,'message' => lang('error_service_not_available')),self::HTTP_BAD_REQUEST);exit();
	        }	
	
	        //fetch all vehicles and check vehicle is avilable Or not 
	        $check_result = $this->VehicleModel->fetch_vehicle_for_ride_where(array('fare_city_id'=>$cities->city_id));
	        if($check_result->num_rows() <= 0){
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
	        $result = $this->VehicleModel->vehicle_amount_calculate(
	        	array(
					'fare_city_id'=>$cities->city_id
				),
	        	array(
					'total_time'=>$total_time_in_minutes,
					'total_distance'=>$total_distance,
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
	        $request_data['request_distance_text'] = $total_distance .' Km.';
	        $request_data['request_time_text'] = $total_time_in_minutes . ' minutes';
	        $request_data['request_time_value'] = $total_time_in_minutes;

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
	        $this->api_return(array('status' =>true,'message' => lang('data_found'),'data'=>$result->result(),'request_id'=>$request_id),self::HTTP_OK);exit();
    	}catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	}
}