<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'libraries/api-libraries/API_Controller.php'; // for load rest controller

class Country extends API_Controller {
	/**
	 * @method : index()
	 * @date : 2022-06-17
	 * @about: This method use for fetch country list
	 * 
	 * */
	public function index(){
		try
    	{	
    		$this->_apiConfig([
	            'methods' => ['GET'],
	            'key' => ['header',$this->config->item('api_fixe_header_key')],
	        ]);
    		$results = $this->CountryModel->fetch_all_country();
    		if($results->num_rows() <= 0){
    			$this->api_return(array('status' =>false,'message' =>"Data Not Found !"),self::HTTP_NOT_FOUND);exit();
    		}
    		$this->api_return(array('status' =>true,'message' =>"Data Found !","data"=>$results->result()),self::HTTP_OK);exit();
    	}catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	}
}