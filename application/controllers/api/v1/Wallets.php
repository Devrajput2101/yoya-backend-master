<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'libraries/api-libraries/API_Controller.php'; // for load rest controller

class Wallets extends API_Controller {
    
    /**
	 * @method : balance()
	 * @date : 2022-07-
	 * @about: This method use for check application stage 
	 * */
	 public function balance(){
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
	        $wallet = $this->WalletsModel->balance(array('wallet_user_id'=>$post->user_id));
	        $this->api_return(array('status' =>true,'message' => lang('data_found'),'balance'=>$wallet),self::HTTP_OK);exit();
    	}catch(Exception $e){
    		$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
    	}
    }
}