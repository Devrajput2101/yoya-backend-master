<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document extends MY_AdminController {

	public function __construct() {
        parent::__construct(); 
        is_logged_out(); // if user is logout Or session is expired then redirect login
    }
    /**
	 * @method : uploads()
	 * @date : 2022-07-18
	 * @about: This method use for upload documents
	 * 
	 * */
    public function uploads(){
        $user_id = $this->uri->segment('4');
        $user = $this->UsersModel->fetch_user_by_id($user_id);
        $country = $this->CountrysModel->get_country(array('country_code'=>$user->user_country_code))->row();
        $this->data['requireddocument'] = $this->RequiredDocumentModel->fetch_all(array('document_country_id'=>$country->country_id));
        
        foreach($this->data['requireddocument']->result() as $key => $data){
			$this->data['requireddocument']->result()[$key]->document_placeholder = image_assets($data->document_placeholder);
			$this->data['requireddocument']->result()[$key]->document_uploads = $this->DocumentModel->fetch_document(array('doc_user_id'=>$user_id,'doc_document_id'=>$data->document_id));
		}
		$this->data['status'] = $this->DocumentModel->status($user_id);
        $this->load->view('back-end/drivers/document/index-page',$this->data);
    }
    /**
	 * @method : status()
	 * @date : 2022-07-18
	 * @about: This method use for update doscument status
	 * 
	 * */
    public function status(){
       $status = $this->uri->segment('4');
       $doc_id = $this->uri->segment('5');
       
       $doc_status['doc_status'] = $status;
       if($this->DocumentModel->update(array('doc_id'=>$doc_id),$doc_status)){
          	$this->session->set_flashdata('success','Document status succefully changed !');
       }else{
          	$this->session->set_flashdata('error','Oops something went wrong please try after some time!');
       }
       redirect($_SERVER['HTTP_REFERER']); 
    }
    
}