<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'libraries/api-libraries/API_Controller.php'; // for load rest controller

class Cancel extends API_Controller {
    /**
	 * @method : customer()
	 * @date : 2022-07-25
	 * @about: This method use for fetch cancel resion
	 * */
	 public function customer(){
	     try
    	{	
    		$this->_apiConfig([
	            'methods' => ['GET'],
	            'key' => ['header',$this->config->item('api_fixe_header_key')],
	        ]);
	        $result = $this->CancelreasonModel->fetch_all(array('reason_for'=>'customer'));
	        $this->api_return(array('status' =>true,'message' =>lang('data_found'),'data'=>$result->result()),self::HTTP_OK);exit();
    	}catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	 }
	 
	 /**
	 * @method : driver()
	 * @date : 2022-07-25
	 * @about: This method use for fetch cancel resion
	 * */
	 public function driver(){
	     try
    	{	
    		$this->_apiConfig([
	            'methods' => ['GET'],
	            'key' => ['header',$this->config->item('api_fixe_header_key')],
	        ]);
	        $result = $this->CancelreasonModel->fetch_all(array('reason_for'=>'driver'));
	        $this->api_return(array('status' =>true,'message' =>lang('data_found'),'data'=>$result->result()),self::HTTP_OK);exit();
    	}catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	 }
}