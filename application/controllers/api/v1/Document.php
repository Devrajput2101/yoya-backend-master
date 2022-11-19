<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'libraries/api-libraries/API_Controller.php'; // for load rest controller

class Document extends API_Controller {
	/**
	 * @method : uploads()
	 * @date : 2022-06-21
	 * @about: This method use for uploads document
	 * */
	public function uploads(){
		try
    	{	
    		$this->_apiConfig([
	            'methods' => ['POST'],
	            'key' => ['header',$this->config->item('api_fixe_header_key')],
	        ]);
    		$post = json_decode(file_get_contents('php://input'));
    		if(empty($post->document_id) || !isset($post->document_id)){
		        $this->api_return(array('status' =>false,'message' => lang('error_document_id')),self::HTTP_BAD_REQUEST);exit();
	        }
	        $required_document = $this->RequiredDocumentModel->fetch_single(array('document_id'=>$post->document_id));

	        if(empty($required_document)){
	        	$this->api_return(array('status' =>false,'message' => lang('error_document_id')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->user_id) || !isset($post->user_id)){
		        $this->api_return(array('status' =>false,'message' =>lang('error_user_id_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        if(empty($post->id_number) || !isset($post->id_number) || strlen($post->id_number) != $required_document->document_minimum_char){
		        $this->api_return(array('status' =>false,'message' => lang('error_id_number_missing')),self::HTTP_BAD_REQUEST);exit();
	        }

	        //if enable upload image then upload front image 
	        if($required_document->document_front_image == 1){
	        	if(empty($post->front_image) || !isset($post->front_image)){
			        $this->api_return(array('status' =>false,'message' => lang('error_front_image_missing')),self::HTTP_BAD_REQUEST);exit();
		        }
	        }
	        //if enable upload image then upload back image 
	        if($required_document->document_back_image == 1){
		        if(empty($post->back_image) || !isset($post->back_image)){
			        $this->api_return(array('status' =>false,'message' => lang('error_back_image_missing')),self::HTTP_BAD_REQUEST);exit();
		        }
		    }

	        //check doc exist or not
	        if($this->DocumentModel->check_duplicate(array('doc_id_number'=>$post->id_number,'doc_document_id'=>$post->document_id))){
	        	//$this->api_return(array('status' =>false,'message' => lang('error_document_exist')),self::HTTP_BAD_REQUEST);exit();
	        }

	        if(!empty($post->back_image) && $required_document->document_back_image == 1){
	        	$config['upload_path'] = './uploads/document/user-'.$post->user_id;
		        $config['path_create'] = true;
		        $config['encryption']  = true;
		        $config['file_string'] = $post->back_image;
		        $config['file_ext']    = 'png';
		        $this->base64fileuploads->initialize($config,true);
		        if(!$this->base64fileuploads->do_upload()){
		        	$this->api_return(array('status' =>false,'message' => lang('error_back_image_missing')),self::HTTP_BAD_REQUEST);exit();
		        }
		        $upload_doc['doc_back_image'] =  $this->base64fileuploads->data('full_path');
	        }

	        if(!empty($post->front_image) && $required_document->document_front_image == 1){
	        	$config['upload_path'] = './uploads/document/user-'.$post->user_id;
		        $config['path_create'] = true;
		        $config['encryption']  = true;
		        $config['file_string'] = $post->front_image;
		        $config['file_ext']    = 'png';
		        $this->base64fileuploads->initialize($config,true);
		        if(!$this->base64fileuploads->do_upload()){
		        	$this->api_return(array('status' =>false,'message' => lang('error_front_image_missing')),self::HTTP_BAD_REQUEST);exit();
		        }
		        $upload_doc['doc_front_image'] =  $this->base64fileuploads->data('full_path');
	        }

	        $upload_doc['doc_id_number']  = $post->id_number;
	        $upload_doc['doc_user_id']    = $post->user_id;
	        $upload_doc['doc_document_id']= $post->document_id;
	        $upload_doc['doc_status']= 0;
	        $upload_doc['doc_online_status']= 0;
	        
	        if($this->DocumentModel->check_duplicate(array('doc_user_id'=>$post->user_id,'doc_document_id'=>$post->document_id))){
	            $document = $this->DocumentModel->fetch_document(array('doc_user_id'=>$post->user_id,'doc_document_id'=>$post->document_id));
	            if(!empty($document)){
	                if(!empty($document->doc_front_original)){
	                   //unlink(ltrim($document->doc_front_original, '/'));
	                   //unlink('.'.$document->doc_front_original);
	                }
	                if(!empty($document->doc_back_original)){
	                    //unlink('.'.$document->doc_back_original);
	                   //unlink(ltrim($document->doc_back_original, '/'));
	                }
	            }
	            $this->DocumentModel->update(array('doc_user_id'=>$post->user_id,'doc_document_id'=>$post->document_id),$upload_doc);
	        }else{
	            $this->DocumentModel->save($upload_doc);
	        }
	        $this->api_return(array('status' =>true,'message' => lang('success_document_upload')),self::HTTP_OK);exit();
    	} catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	}
	/**
	 * @method : status()
	 * @date : 2022-06-10
	 * @about: This method use for check kyc status
	 * 
	 * */
	public function status(){
		$this->_apiConfig([
            'methods' => ['POST'],
            'key' => ['header',$this->config->item('api_fixe_header_key')],
        ]);
        $post = json_decode(file_get_contents('php://input'));
		if(empty($post->user_id) || !isset($post->user_id)){
	        $this->api_return(array('status' =>false,'message' =>lang('error_user_id_missing')),self::HTTP_BAD_REQUEST);exit();
        }
        $user_id = $post->user_id;
        $user    = $this->UsersModel->fetch_user_by_id($user_id);
		$results = $this->RequiredDocumentModel->fetch_all(array('country_code'=>@$user->user_country_code));
		if($results->num_rows() <= 0){
			$this->api_return(array('status' =>false,'message' =>lang('data_not_found')),self::HTTP_OK);exit();
		}
		//document modification and check status by users
		$kyc_status = false;
		foreach($results->result() as $key => $data){
			$kyc_status = true;	
			$document   = $this->DocumentModel->fetch_document(array('doc_user_id'=>$user_id,'doc_document_id'=>$data->document_id));
    		if(!empty($document)){
    			if($document->doc_status == 0 || $document->doc_status == 2){
    				$kyc_status = false;
    				break;
    			}
			}else{
				$kyc_status = false;
				break;
			}
		}
        $this->api_return(array('status' =>true,'message'=>lang('data_found'),'kyc_status'=>$kyc_status),self::HTTP_OK);exit();
	}
}