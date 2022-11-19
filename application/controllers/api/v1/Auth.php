<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'libraries/api-libraries/API_Controller.php'; // for load rest controller

class Auth extends API_Controller {
	/**
	 * @method : register()
	 * @date : 2022-06-08
	 * @about: This method use for register user And customer 
	 * 
	 * */
	public function register(){
		try
    	{
			$this->_apiConfig([
	            'methods' => ['POST'],
	            'key' => ['header',$this->config->item('api_fixe_header_key')],
	        ]);
	        $post = json_decode(file_get_contents('php://input'));
	        if(empty($post->user_mobile) || !isset($post->user_mobile)){
		        $this->api_return(array('status' =>false,'message' =>lang('error_mobile_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->user_name) || !isset($post->user_name)){
		        $this->api_return(array('status' =>false,'message' =>lang('error_name_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->message_key) || !isset($post->message_key)){
		        $this->api_return(array('status' =>false,'message' =>lang('error_message_key_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->device_token) || !isset($post->device_token)){
		        $this->api_return(array('status' =>false,'message' =>lang('error_device_token_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->user_type) || !isset($post->user_type)){
		        $this->api_return(array('status' =>false,'message' =>lang('error_user_type_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->country_code) || !isset($post->country_code)){
		        $this->api_return(array('status' =>false,'message' =>lang('error_country_code_missing')),self::HTTP_BAD_REQUEST);exit();
	        }

	        if(!empty(@$post->user_password)){
	        	if(empty($post->user_password) || !isset($post->user_password)){
			        $this->api_return(array('status' =>false,'message' =>lang('error_password_missing')),self::HTTP_BAD_REQUEST);exit();
		        }
	        }
		        
	        if(empty($post->user_latitude) || !isset($post->user_latitude)){
		        $this->api_return(array('status' =>false,'message' =>lang('error_latitude_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->user_longitude) || !isset($post->user_longitude)){
		        $this->api_return(array('status' =>false,'message' =>lang('error_longitude_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        //check duplicate mobile number 
	        if($this->UsersModel->check_duplicate_mobile(array('user_phone'=>$post->user_mobile,'user_type'=>$post->user_type))){
	        	$this->api_return(array('status' =>true,'message' =>lang('error_mibile_exist'),'is_exist_phone'=>true),self::HTTP_OK);exit();
	        }

	        $user_data['user_devoice_token']  = $post->device_token;
	        $user_data['user_verification_code']      = otp_generate();
	        $user_data['user_type']      = $post->user_type;
			$user_data['user_username']  = user_name($post->user_name);
			$user_data['user_referral']  = referral_code(5);
			$user_data['user_country_code'] = $post->country_code;
			$user_data['user_name']      = $post->user_name;		
			$user_data['user_phone']     = $post->user_mobile;
			$user_data['user_password']  = $this->password->hash($post->user_password);
			$user_data['user_latitude']  = $post->user_latitude;
			$user_data['user_longitude'] = $post->user_longitude;
			//save as user
	        if($last_id = $this->UsersModel->save($user_data)){
	        	//otp 
				$sms_temp = $this->SmsModel->get_template_by_slug("sign_up");
		        if(!empty($sms_temp)){
		            $var['#OTP']          = $user_data['user_verification_code'];
					$var['#message_key']  = $post->message_key;
					$sms_content          = str_replace(array_keys($var),array_values($var),$sms_temp['content']);
				    $this->_send_sms($post->user_mobile,$sms_content,$sms_temp['template_id'],$sms_temp['unicode']);
		        }

		        if($post->user_type == 'customer'){
		        	//save as customer
					$customer['customer_user_id']   = $last_id;
					$customer['customer_create_at'] = date('Y-m-d H:i:s');
					$customer['customer_update_at'] = date('Y-m-d H:i:s');
					$this->CustomerModel->save($customer);
		        }else if($post->user_type == 'driver'){
		        	//save as Driver
					$customer['driver_user_id']   = $last_id;
					$customer['driver_create_at'] = date('Y-m-d H:i:s');
					$customer['driver_update_at'] = date('Y-m-d H:i:s');
					$this->DriverModel->save($customer);
		        }
	        	
	        	$this->api_return(array('status' =>true,'message' =>lang('success_otp_sent'),'is_exist_phone'=>false),self::HTTP_OK);exit();
	        }else{
	        	$this->api_return(array('status' =>false,'message' => self::HEADER_STATUS_STRINGS[self::HTTP_SERVER_ERROR]),self::HTTP_SERVER_ERROR);exit();
	        }
   		 } catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	}

	/**
	 * @method : index()
	 * @date : 2022-06-08
	 * @about: This method use for login
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
	        if(empty($post->user_mobile) || !isset($post->user_mobile)){
		        $this->api_return(array('status' =>false,'message' => 'User mobile is empty Or missing !'),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->message_key) || !isset($post->message_key)){
		        $this->api_return(array('status' =>false,'message' => 'Message key is empty Or missing !'),self::HTTP_BAD_REQUEST);exit();
	        }
	        //check mobile number 
	        if($this->UsersModel->check_duplicate_mobile(array('user_phone'=>$post->user_mobile))){
	        	$user_data['user_verification_code'] = otp_generate();
				$this->UsersModel->update(array('user_phone'=>$post->user_mobile),$user_data);
	        	//otp 
				$sms_temp = $this->SmsModel->get_template_by_slug("sign_in");
		        if(!empty($sms_temp)){
		            $var['#OTP']          = $user_data['user_verification_code'];
					$var['#message_key']  = $post->message_key;
					$sms_content          = str_replace(array_keys($var),array_values($var),$sms_temp['content']);
				    $this->_send_sms($post->user_mobile,$sms_content,$sms_temp['template_id'],$sms_temp['unicode']);
				    $this->api_return(array('status' =>true,'message' => 'OTP successfully sent !'),self::HTTP_OK);exit();
		        }
	        }
	        $this->api_return(array('status' =>false,'message' => 'Your mobile number is not register !'),self::HTTP_OK);exit();
    	} catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	}
	/**
	 * @method : verification()
	 * @date : 2022-06-08
	 * @about: This method use for verification
	 * 
	 * */
	public function verification(){
		try
    	{
    		$this->_apiConfig([
	            'methods' => ['POST'],
	            'key' => ['header',$this->config->item('api_fixe_header_key')],
	        ]);
	        $post = json_decode(file_get_contents('php://input'));
	        if(empty($post->otp_text) || !isset($post->otp_text)){
		        $this->api_return(array('status' =>false,'message' => 'OTP Text is empty Or missing !'),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->device_token) || !isset($post->device_token)){
		        $this->api_return(array('status' =>false,'message' => 'Device token is empty Or missing !'),self::HTTP_BAD_REQUEST);exit();
	        }
	        //check mobile number 
	        if($this->UsersModel->check_otp_is_exist($post->otp_text)){
	        	$data['user_verification_code'] = null;
	        	$data['user_phone_verified']    = 1;
				$data['user_devoice_token']     = $post->device_token;
				$user_data = $this->UsersModel->fetch_user_data_by_otp($post->otp_text);
				$this->UsersModel->update(array('user_verification_code'=>$post->otp_text),$data);

				$this->api_return(array('status' =>true,'message' => 'OTP is match !','data'=>$user_data),self::HTTP_OK);exit();
	        }
	        $this->api_return(array('status' =>false,'message' => 'Your OTP code is incorrect !'),self::HTTP_OK);exit();
    	} catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	}

	/**
	 * @method : resendotp()
	 * @date : 2022-06-08
	 * @about: This method use for resend otp
	 * 
	 * */
	public function resendotp(){
		try
    	{
    		$this->_apiConfig([
	            'methods' => ['POST'],
	            'key' => ['header',$this->config->item('api_fixe_header_key')],
	        ]);
	        $post = json_decode(file_get_contents('php://input'));
	        if(empty($post->user_mobile) || !isset($post->user_mobile)){
		        $this->api_return(array('status' =>false,'message' => 'User mobile is empty Or missing !'),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->message_key) || !isset($post->message_key)){
		        $this->api_return(array('status' =>false,'message' => 'Message key is empty Or missing !'),self::HTTP_BAD_REQUEST);exit();
	        }
	        //check mobile number 
	        if($this->UsersModel->check_duplicate_mobile(array('user_phone'=>$post->user_mobile))){
	        	$user_data['user_verification_code'] = otp_generate();
				$user_data['user_update_at'] = date('Y-m-d H:i:s');
				$this->UsersModel->update(array('user_phone'=>$post->user_mobile),$user_data);
	        	//otp 
				$sms_temp = $this->SmsModel->get_template_by_slug("sign_in");
		        if(!empty($sms_temp)){
		            $var['#OTP']          = $user_data['user_verification_code'];
					$var['#message_key']  = $post->message_key;
					$sms_content          = str_replace(array_keys($var),array_values($var),$sms_temp['content']);
				    $this->_send_sms($post->user_mobile,$sms_content,$sms_temp['template_id'],$sms_temp['unicode']);
				    $this->api_return(array('status' =>true,'message' => 'OTP successfully sent !'),self::HTTP_OK);exit();
		        }
	        }
	        $this->api_return(array('status' =>false,'message' => 'Your mobile number is not register !'),self::HTTP_OK);exit();
    	} catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	}
	/**
	 * @method : login()
	 * @date : 2022-06-08
	 * @about: This method use for login user by username and password 
	 * 
	 * */
	public function login(){
		try
    	{	
    		$this->_apiConfig([
	            'methods' => ['POST'],
	            'key' => ['header',$this->config->item('api_fixe_header_key')],
	        ]);
	        $post = json_decode(file_get_contents('php://input'));
	        if(empty($post->user_mobile) || !isset($post->user_mobile)){
		        $this->api_return(array('status' =>false,'message' => lang('error_mobile_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->user_password) || !isset($post->user_password)){
		        $this->api_return(array('status' =>false,'message' => lang('error_password_missing')),self::HTTP_BAD_REQUEST);exit();
	        }

	        //check mobile number 
	        if($this->UsersModel->check_duplicate_mobile(array('user_phone'=>$post->user_mobile))){

	        	$user_data = $this->UsersModel->fetch_single_user(array('user_phone'=>$post->user_mobile));
	        	if($this->password->verify_hash($post->user_password,$user_data->user_password)){

	        		$is_verified = false;
	        		if($user_data->user_phone_verified == '1'){
	        			$is_verified = true;
	        		}
	        		
                    $data['user_devoice_token']     = @$post->device_token;
                    $this->UsersModel->update(array('user_id'=>$user_data->user_id),$data);
                    
	        		$this->api_return(array('status' =>true,'message' =>lang('success_login'),'is_verified'=>$is_verified,'data'=>$user_data),self::HTTP_OK);exit();
	        	}else{
	        		$this->api_return(array('status' =>false,'message' =>lang('error_password')),self::HTTP_OK);exit();
	        	}
	        }
	        $this->api_return(array('status' =>false,'message' =>lang('error_mibile_not_exist')),self::HTTP_OK);exit();
    	} catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	}
}