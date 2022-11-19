<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'libraries/api-libraries/API_Controller.php'; // for load rest controller

class Requireddocument extends API_Controller {
	/**
	 * @method : index()
	 * @date : 2022-06-21
	 * @about: This method use for fetch country wise required document
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
		        $this->api_return(array('status' =>false,'message' => lang('error_user_id_missing')),self::HTTP_BAD_REQUEST);exit();
	        }
	        
	        $user = $this->UsersModel->fetch_user_by_id($post->user_id);
	        
    		$results = $this->RequiredDocumentModel->fetch_all(array('country_code'=>@$user->user_country_code));
    		
    		if($results->num_rows() <= 0){
    			$this->api_return(array('status' =>false,'message' =>lang('data_not_found')),self::HTTP_OK);exit();
    		}

    		//document modification and check status by users
    		foreach($results->result() as $key => $data){
    		    $document = $this->DocumentModel->fetch_document(array('doc_document_id'=>$data->document_id,'doc_user_id'=>$post->user_id));
    		    $results->result()[$key]->is_uploded = false;
    		    $results->result()[$key]->document_display_status = "Pending";
    			$results->result()[$key]->document_status = "pending";
    			$results->result()[$key]->document_uploaded = $document;
    		    if(!empty($document)){
    		        $results->result()[$key]->is_uploded = true;
    		        $results->result()[$key]->document_display_status = $document->doc_display_status;
    			    $results->result()[$key]->document_status = $document->doc_display_status;
    		    }
    		}
    		$this->api_return(array('status' =>true,'message' =>lang('data_found'),"data"=>$results->result()),self::HTTP_OK);exit();
    	}catch (Exception $e) {
   		 	$this->api_return(array('status' =>false,'message' => $e->getMessage()),self::HTTP_SERVER_ERROR);exit();
		}
	}
}