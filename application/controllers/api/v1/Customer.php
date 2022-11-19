<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'libraries/api-libraries/API_Controller.php'; // for load rest controller

class Customer extends API_Controller {
	/**
	 * @method : index()
	 * @date : 2022-06-08
	 * @about: This method use for fetch user data
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
	        if(empty($post->user_id) || !isset($post->user_id)){
		        $this->api_return(array('status' =>false,'message' =>lang('error_user_id_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        $user_data = $this->UsersModel->fetch_user_data_by_id($post->user_id);
	        if(!empty($user_data)){
	        	$this->api_return(array('status' =>true,'message' => lang('data_found'),'data'=>$user_data),self::HTTP_OK);exit();
	        }else{
	        	$this->api_return(array('status' =>false,'message' => lang('data_not_found')),self::HTTP_BAD_REQUEST);exit();
	        }
    	} catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	} 
	/**
	 * @method : update()
	 * @date : 2022-06-28
	 * @about: This method use for Customer profile update
	 * 
	 * */
	public function update(){
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
	        if(empty($post->user_name) || !isset($post->user_name)){
		        $this->api_return(array('status' =>false,'message' => lang('error_user_name_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->user_email) || !isset($post->user_email)){
		        $this->api_return(array('status' =>false,'message' => lang('error_user_email_missing')),self::HTTP_BAD_REQUEST);exit();
	        }

	        $user_data['user_name']  = $post->user_name;
	        $user_data['user_email'] = $post->user_email;
	        if($this->UsersModel->update(array('user_id'=>$post->user_id),$user_data)){
	        	$this->api_return(array('status' =>true,'message' => lang('success_profile_updated')),self::HTTP_OK);exit();
	        }else{
	        	$this->api_return(array('status' =>false,'message' => lang('server_error')),self::HTTP_BAD_REQUEST);exit();
	        }
	    } catch (Exception $e) {
	        //log_message('error',$e->getMessage());
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	}

	/**
	 * @method : picture()
	 * @date : 2022-06-28
	 * @about: This method use for Customer profile picture update
	 * 
	 * */
	public function picture(){
		try
    	{
    		$this->_apiConfig([
	            'methods' => ['POST'],
	           // 'key' => ['header',$this->config->item('api_fixe_header_key')],
	        ]);
	        $post = json_decode(file_get_contents('php://input'));
	        if(empty($post->user_id) || !isset($post->user_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_user_id_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->user_image) || !isset($post->user_image)){
		        $this->api_return(array('status' =>false,'message' => lang('error_user_image_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        $user = $this->UsersModel->fetch_user_by_id($post->user_id);
	        if(empty($user)){
	        	$this->api_return(array('status' =>true,'message' => lang('data_not_found')),self::HTTP_BAD_REQUEST);exit();
	        }

	        $user_data['user_image'] = '';
	        if(!empty($post->user_image)){
	        	$config['upload_path'] = './uploads/profile/user-'.$post->user_id;
		        $config['path_create'] = true;
		        $config['encryption']  = true;
		        $config['file_string'] = $post->user_image;
		        $config['file_ext']    = 'png';
		        $this->base64fileuploads->initialize($config,true);
		        if(!$this->base64fileuploads->do_upload()){
		        	$this->api_return(array('status' =>false,'message' => lang('error_user_image_missing')),self::HTTP_BAD_REQUEST);exit();
		        } 
		        if(!empty($user->user_image)){
		        	unlink('.'.$user->user_image);// remove old image
		        }
		        $user_data['user_image'] = $this->base64fileuploads->data('full_path');
	        }

	        
	        if($this->UsersModel->update(array('user_id'=>$post->user_id),$user_data)){
	        	$this->api_return(array('status' =>true,'message' => lang('success_profile_updated')),self::HTTP_OK);exit();
	        }else{
	        	$this->api_return(array('status' =>false,'message' => lang('server_error')),self::HTTP_BAD_REQUEST);exit();
	        }
	    } catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	}
}