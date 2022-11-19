<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'libraries/api-libraries/API_Controller.php'; // for load rest controller

class Jobprocess extends API_Controller {
	/**
	 * @method : index()
	 * @date : 2022-06-17
	 * @about: This method use for fetch all Jobprocess list
	 * 
	 * */
	public function index(){
		try
    	{	
    		$this->_apiConfig([
	            'methods' => ['POST'],
	            'key' => ['header',$this->config->item('api_fixe_header_key')],
	        ]);
	        $post = json_decode(file_get_contents('php://input'));
	        if(empty($post->vehicle_type_id) || !isset($post->vehicle_type_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_vehicle_type_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
    		$results = $this->JobProcessModel->fetch_all_job_proccess_by_vehicle_type_id($post->vehicle_type_id);
    		if($results->num_rows() <= 0){
    			$this->api_return(array('status' =>false,'message' =>lang('401')),self::HTTP_OK);exit();
    		}
    		
    		$this->api_return(array('status' =>true,'message' =>"Data Found !","data"=>$results->result()),self::HTTP_OK);exit();
    	}catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	}
	/**
	 * @method : list()
	 * @date : 2022-06-17
	 * @about: This method use for fetch all Jobprocess list grouping
	 * 
	 * */
	public function list(){
		try
    	{	
    		$this->_apiConfig([
	            'methods' => ['GET'],
	            'key' => ['header',$this->config->item('api_fixe_header_key')],
	        ]);
	        $post = json_decode(file_get_contents('php://input'));
    		$results = $this->JobProcessModel->fetch_all_job_proccess_group();
    		if($results->num_rows() <= 0){
    			$this->api_return(array('status' =>false,'message' =>lang('data_not_found')),self::HTTP_OK);exit();
    		}
    		
    		$this->api_return(array('status' =>true,'message' =>lang('data_found'),"data"=>$results->result()),self::HTTP_OK);exit();
    	}catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	}
}