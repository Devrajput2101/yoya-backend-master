<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'libraries/api-libraries/API_Controller.php'; // for load rest controller

class Discount extends API_Controller {
	/**
	 * @method : apply()
	 * @date : 2022-07-11
	 * @about: This method use for apply discount code
	 * 
	 * */
	public function apply(){
		try
    	{	
    		$this->_apiConfig([
	            'methods' => ['POST'],
	            'key' => ['header',$this->config->item('api_fixe_header_key')],
	        ]);
	        $post = json_decode(file_get_contents('php://input'));
	        if(empty($post->user_id) || !isset($post->user_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_user_id_missing') ),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->request_id) || !isset($post->request_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_discount_code_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->discount_code) || !isset($post->discount_code)){
		        $this->api_return(array('status' =>false,'message' => lang('error_discount_code_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
    		$checkresults = $this->DiscountModel->check_duplicate(array('discount_code'=>$post->discount_code));
    		if(!$checkresults){
    			$this->api_return(array('status' =>false,'message' =>lang('data_not_found')),self::HTTP_NOT_FOUND);exit();
    		}
    		
    		$results = $this->DiscountModel->fetch_discount(array('discount_code'=>$post->discount_code));
    		
    		$start_date   = strtotime($results->discount_start_date);
    		$end_date     = strtotime($results->discount_end_date);
    		$current_date = time();
    		
    		if($current_date >= $start_date && $end_date >= $current_date){
    		    
    		    if($results->discount_type == ""){
    		        
    		    }else{
    		        
    		    }
    		    
    		    $request['request_coupon_details']= json_encode($results);
        		$request['request_coupon_amount'] = $results->discount_id;
        		$request['request_coupon_id']     = $results->discount_id;
        		if($this->RequestModel->update(array('request_id'=>$post->request_id),$request)){
        		    $this->api_return(array('status' =>true,'message' =>lang('data_found')),self::HTTP_OK);exit();
        		}else{
        		    $this->api_return(array('status' =>false,'message' =>lang('server_error')),self::HTTP_OK);exit();
        		}  
        		
    		}else{
    		    $this->api_return(array('status' =>false,'message' =>'This coupon code is invalid or has expired.'),self::HTTP_OK);exit();
    		}
    	}catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	}
	/**
	 * @method : remove()
	 * @date : 2022-07-11
	 * @about: This method use for remove discount code
	 * 
	 * */
	public function remove(){
		try
    	{	
    		$this->_apiConfig([
	            'methods' => ['POST'],
	            'key' => ['header',$this->config->item('api_fixe_header_key')],
	        ]);
	        $post = json_decode(file_get_contents('php://input'));
	        if(empty($post->user_id) || !isset($post->user_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_user_id_missing') ),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->request_id) || !isset($post->request_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_discount_code_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        
    		
		    $request['request_coupon_details']= null;
    		$request['request_coupon_amount'] = null;
    		$request['request_coupon_id']     = null;
    		
    		if($this->RequestModel->update(array('request_id'=>$post->request_id,'request_user_id'=>$post->user_id),$request)){
    		    $this->api_return(array('status' =>true,'message' =>lang('discount_removed')),self::HTTP_OK);exit();
    		}else{
    		    $this->api_return(array('status' =>false,'message' =>lang('server_error')),self::HTTP_OK);exit();
    		} 
    	}catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	}
}