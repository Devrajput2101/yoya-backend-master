<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'libraries/api-libraries/API_Controller.php'; // for load rest controller

class Stage extends API_Controller {
    
    /**
	 * @method : customer()
	 * @date : 2022-07-23
	 * @about: This method use for check application stage 
	 * */
	 public function customer(){
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
	        $stages = array('stage'=>'idle','message'=>'Your request and booking is clear !');
	        
	        $bookings = $this->BookingModel->check_booking_stage(array('booking_user_id'=>$post->user_id),array('booking_accepted'));
	        if($bookings->num_rows() > 0){
	            $stages = array('stage'=>'booking_accepted','message'=>'your booking is accepted Or on the way please stay this page !');
	        }
	        
	        $bookings = $this->BookingModel->check_booking_stage(array('booking_user_id'=>$post->user_id),array('booking_started','booking_reached'));
	        if($bookings->num_rows() > 0){
	            $stages = array('stage'=>'booking_started','message'=>'your booking is ongoing Or on the way please stay this page !');
	        }
	        
	        $request = $this->RequestModel->chekc_request_stage(array('request_user_id'=>$post->user_id,'request_status'=>'1'));
	        if($request->num_rows() > 0){
	            $stages = array('stage'=>'request_pending','message'=>'your request is pending Or process for driver search !');
	        }
	        
	        $this->api_return(array('status' =>true,'message' => lang('data_found'),'data'=>$stages),self::HTTP_BAD_REQUEST);exit();
    	}catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	 }
	 
	 /**
	 * @method : driver()
	 * @date : 2022-07-23
	 * @about: This method use for check application stage 
	 * */
	 public function driver(){
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
	        $stages = array('stage'=>'idle','message'=>'Your request and booking is clear !');
	        
	        $bookings = $this->BookingModel->check_booking_stage(array('booking_driver_id'=>$post->user_id),array('booking_accepted'));
	        if($bookings->num_rows() > 0){
	            $stages = array('stage'=>'booking_accepted','message'=>'your booking is accepted Or on the way please stay this page !');
	        }
	        
	        $bookings = $this->BookingModel->check_booking_stage(array('booking_driver_id'=>$post->user_id),array('booking_started','booking_reached'));
	        if($bookings->num_rows() > 0){
	            $stages = array('stage'=>'booking_started','message'=>'your booking is ongoing Or on the way please stay this page !');
	        }
	        
	        $this->api_return(array('status' =>true,'message' => lang('data_found'),'data'=>$stages),self::HTTP_BAD_REQUEST);exit();
    	}catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	 }
}