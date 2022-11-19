<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'libraries/api-libraries/API_Controller.php'; // for load rest controller

class Conversations extends API_Controller {
    /**
	 * @method : joinroom()
	 * @date : 2022-09
	 * @about: This method use for fetch cancel resion
	 * */
	 public function joinroom(){
	    try
    	{	
    		$this->_apiConfig([
	            'methods' => ['POST'],
	            //'key' => ['header',$this->config->item('api_fixe_header_key')],
	        ]);
	        $post = json_decode(file_get_contents('php://input'));
	        if(empty($post->request_id) || !isset($post->request_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_request_id_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->user_id) || !isset($post->user_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_user_id_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->user_name) || !isset($post->user_name)){
		        $this->api_return(array('status' =>false,'message' => lang('error_user_name_missing')),self::HTTP_BAD_REQUEST);exit();
	        }

	        $data['room_name'] = 'request-room-'.$post->request_id;
	        $data['room_user_id'] = $post->user_id;
	        $data['room_is_online'] = 1;

	        if($this->ConversationsModel->is_exist(array('room_user_id'=>$data['room_user_id'],'room_name'=>$data['room_name']))){
	        	$this->ConversationsModel->update(array('room_user_id'=>$data['room_user_id'],'room_name'=>$data['room_name']),$data);
	        	$this->api_return(array('status' =>true,'message' =>
	        		"User already Join in Room "),self::HTTP_OK);exit();
	        }else{
	        	$this->ConversationsModel->save($data);
	        	$this->api_return(array('status' =>true,'message' =>
	        		"User Join in Room "),self::HTTP_OK);exit();
	        }
	        
    	}catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	 }

	 public function getroom(){
	    try
    	{	
    		$this->_apiConfig([
	            'methods' => ['POST'],
	            //'key' => ['header',$this->config->item('api_fixe_header_key')],
	        ]);
	        $post = json_decode(file_get_contents('php://input'));
	        if(empty($post->request_id) || !isset($post->request_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_request_id_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->user_id) || !isset($post->user_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_user_id_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        $rooms = 'request-room-'.$post->request_id;
	        $data = $this->ConversationsModel->fetch_room(array('room_user_id'=>$post->user_id,'room_name'=>$rooms));

	        $this->api_return(array('status' =>true,'message' =>lang('data_found'),'data'=>$data),self::HTTP_OK);exit();
	        
    	}catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	 }


	 /**
	 * @method : sendmessage()
	 * @date : 2022-09
	 * @about: This method use for save message
	 * */
	 public function sendmessage(){
	    try
    	{	
    		$this->_apiConfig([
	            'methods' => ['POST'],
	            //'key' => ['header',$this->config->item('api_fixe_header_key')],
	        ]);
	        $post = json_decode(file_get_contents('php://input'));
	        if(empty($post->request_id) || !isset($post->request_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_request_id_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->user_id) || !isset($post->user_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_user_id_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->message) || !isset($post->message)){
		        $this->api_return(array('status' =>false,'message' => "Message field is required !"),self::HTTP_BAD_REQUEST);exit();
	        }

	        $rooms_users = $this->ConversationsModel->fetch_room_users(array('room_name'=>'request-room-'.$post->request_id));

	        foreach($rooms_users->result() as $key => $value){
	        	if($value->room_user_id == $post->user_id){
	        		$data['message_type']= 'send'; 
	        	}else{
	        		$data['message_type'] 	 = 'received'; 
	        	}
	        	$data['message_content'] = $post->message;
		        $data['message_user_id'] = $value->room_user_id;
		        $data['message_room_name'] = 'request-room-'.$post->request_id;
		        $this->ConversationsModel->save_message($data);
	        }

	        $this->api_return(array('status' =>true,'message' =>
	        		"Message Send Succefully ! "),self::HTTP_OK);exit();
    	}catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	 }

	 /**
	 * @method : getchat()
	 * @date : 2022-09
	 * @about: This method use for fetch message by rooms 
	 * */
	 public function getchat(){
	    try
    	{	
    		$this->_apiConfig([
	            'methods' => ['POST'],
	            //'key' => ['header',$this->config->item('api_fixe_header_key')],
	        ]);
	        $post = json_decode(file_get_contents('php://input'));
	        if(empty($post->request_id) || !isset($post->request_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_request_id_missing')),self::HTTP_BAD_REQUEST);exit();
	        }

	        $chating = $this->ConversationsModel->fetch_message_by_rooms(array('message_room_name'=>'request-room-'.$post->request_id));

	        $this->api_return(array('status' =>true,'message' =>
	        		lang('data_found'),'data'=>$chating->result()),self::HTTP_OK);exit();
    	}catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	 }
}