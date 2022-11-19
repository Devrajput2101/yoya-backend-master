<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'libraries/api-libraries/API_Controller.php'; // for load rest controller

class Driver extends API_Controller {
	/**
	 * @method : index()
	 * @date : 2022-06-08
	 * @about: This method use for fetch Driver data
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
		        $this->api_return(array('status' =>false,'message' => 'User id is empty Or missing !'),self::HTTP_BAD_REQUEST);exit();
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
	 * @method : job_update()
	 * @date : 2022-06-18
	 * @about: This method use for Driver job process update
	 * 
	 * */
	public function job_update(){
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
	        if(empty($post->job_process_id) || !isset($post->job_process_id) || !is_array($post->job_process_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_job_process_id_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->vehicle_type_id) || !isset($post->vehicle_type_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_vehicle_type_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->vehicle_number) || !isset($post->vehicle_number)){
		        $this->api_return(array('status' =>false,'message' => lang('error_vehicle_number_missing')),self::HTTP_BAD_REQUEST);exit();
	        }

	        if($this->DriverVehicleModel->check_duplicate(array('dv_user_id'=>$post->user_id))){
	        	$this->api_return(array('status' =>false,'message' => lang('error_job_process_updated'),'is_updated'=>true),self::HTTP_OK);exit();
	        }

	        foreach($post->job_process_id as $key => $value){
	        	$data['job_user_id'] 		= $post->user_id;
	        	$data['job_job_process_id'] = $value;
	        	$this->DriverJobModel->save($data);
	        }
	        
	        $vehicle['dv_vehicle_type_id'] = $post->vehicle_type_id;
	        $vehicle['dv_number'] 		   = $post->vehicle_number;
	        $vehicle['dv_user_id'] 		   = $post->user_id;

	        if($this->DriverVehicleModel->save($vehicle)){
	        	$this->api_return(array('status' =>true,'message' =>lang('success_proccess_updated'),'is_updated'=>true),self::HTTP_OK);exit();
	        }else{
	        	$this->api_return(array('status' =>true,'message' =>lang('server_error'),'is_updated'=>false),self::HTTP_OK);exit();
	        }

	    } catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	}
	/**
	 * @method : job_status()
	 * @date : 2022-06-18
	 * @about: This method use for Driver job status update
	 * 
	 * */
	public function job_status(){
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
	        if( !isset($post->user_job_status)){
		        $this->api_return(array('status' =>false,'message' => lang('error_user_jobstatus_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->user_latitude) || !isset($post->user_latitude)){
		        $this->api_return(array('status' =>false,'message' =>lang('error_latitude_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->user_longitude) || !isset($post->user_longitude)){
		        $this->api_return(array('status' =>false,'message' =>lang('error_longitude_missing')),self::HTTP_BAD_REQUEST);exit();
	        }

	        $user_data['user_longitude'] = $post->user_longitude;
	        $user_data['user_latitude']  = $post->user_latitude;
	        $user_data['user_job_status']= $post->user_job_status;

	        if($this->UsersModel->update(array('user_id'=>$post->user_id),$user_data)){
	        	$this->api_return(array('status' =>true,'message' =>lang('success_job_status_updated')),self::HTTP_OK);exit();
	        }else{
	        	$this->api_return(array('status' =>false,'message' =>lang('server_error')),self::HTTP_BAD_REQUEST);exit();
	        }
	    } catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	}
	/**
	 * @method : update()
	 * @date : 2022-06-28
	 * @about: This method use for Driver profile update
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

	        $user_data['user_name'] = $post->user_name;
	        if($this->UsersModel->update(array('user_id'=>$post->user_id),$user_data)){
	        	$this->api_return(array('status' =>true,'message' => lang('success_profile_updated')),self::HTTP_OK);exit();
	        }else{
	        	$this->api_return(array('status' =>false,'message' => lang('server_error')),self::HTTP_BAD_REQUEST);exit();
	        }
	    } catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	}

	/**
	 * @method : picture()
	 * @date : 2022-06-28
	 * @about: This method use for Driver profile picture update
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