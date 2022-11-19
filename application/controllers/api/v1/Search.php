<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'libraries/api-libraries/API_Controller.php'; // for load rest controller

class Search extends API_Controller {
    /**
	 * @method : update()
	 * @date : 2022-06-30
	 * @about: This method use for update time and payment methods 
	 * 
	 * */
	 public function history(){
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
	        $result = $this->SearchModel->recent_search_list(array('request_user_id'=>$post->user_id));
	        if($result->num_rows() <= 0){
	            $this->api_return(array('status' =>false,'message' => lang('data_not_found')),self::HTTP_BAD_REQUEST);exit();
	        }
	        $this->api_return(array('status' =>true,'message' => lang('data_found'),'data'=>$result->result()),self::HTTP_OK);exit();
    	}catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	 }
}