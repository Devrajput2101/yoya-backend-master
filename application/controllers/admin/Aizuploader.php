<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aizuploader extends MY_AdminController {

  public function __construct() {
        parent::__construct(); 
        is_logged_out(); // if user is logout Or session is expired then redirect login
  }

  public function index(){
    $this->data['meta'] = array('meta_title'=>'Coins Records','meta_description'=>'');
  }

  public function get_uploaded_files(){
    $result = $this->AizuploadModel->fetch_all_uploads();
    return $this->api_return(array('data'=>$result->result()),200);
  }
  
  public function get_file_by_ids(){
    $ids = $this->input->post('ids');
    $result = $this->AizuploadModel->fetch_single_uploads($ids);
    return $this->api_return($result->result(),200);
  }

  public function api_return($data = NULL, $http_code = NULL) {
    ob_start();
    return $this->output
        ->set_content_type('application/json')
        ->set_status_header($http_code) // Return status
        ->set_output(json_encode($data));
    exit;
    ob_end_flush();
  }

  public function upload(){
    if($this->AizuploadModel->singale_image_upload()){
      $file_type = explode('/',$this->upload->data('file_type'));
      $upload_data['file_original_name'] = $this->upload->data('orig_name');
      $upload_data['file_name'] = 'uploads/all/'.$this->upload->data('file_name');
      $upload_data['user_id']   = $this->session->userdata('user_id');
      $upload_data['file_size'] = $this->upload->data('file_size');
      $upload_data['extension'] = $this->upload->data('image_type');
      $upload_data['type']      = $file_type[0];
      $upload_data['created_at'] = date('Y-m-d H:i:s');
      $upload_data['updated_at'] = date('Y-m-d H:i:s');
      return $this->AizuploadModel->save($upload_data);
    }else{
      return false;
    }
  }
}