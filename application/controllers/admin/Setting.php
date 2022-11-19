<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Setting extends MY_AdminController {

  public function __construct() {
        parent::__construct(); 
        is_logged_out(); // if user is logout Or session is expired then redirect login
  }
  
  public function index(){
    $this->data['meta']  = array('meta_title'=>'Setting','meta_description'=>'');
    $this->load->view('back-end/setting/index-page',$this->data);
  }
  
  public function app(){
    $this->data['meta']  = array('meta_title'=>'Setting','meta_description'=>'');
    $this->load->view('back-end/setting/app-setting/index-page',$this->data);
  }
  
  public function google(){
    $this->data['meta']  = array('meta_title'=>'Setting','meta_description'=>'');
    $this->load->view('back-end/setting/googles/index-page',$this->data);
  }

  public function sms(){
    $this->data['meta']  = array('meta_title'=>'Setting','meta_description'=>'');
    $this->load->view('back-end/setting/messages/index-page',$this->data);
  }
  
  public function update(){
    foreach($this->input->post() as $key => $value){
        if(!array_key_exists($key,$this->data['config'])){
           $data['setting_key']       = $key;
           $data['setting_value']     = $value;
           $data['setting_create_at'] = date('Y-m-d H:i:s');
           $this->SettingModel->save($data);
        }else{
           $data['setting_key']       = trim($key);
           $data['setting_value']     = !empty(trim($value)) ? $value : NULL ;
           $data['setting_update_at'] = date('Y-m-d H:i:s');
           $this->SettingModel->update(array('setting_key'=>trim($key)),$data);
        }
    }
    $this->session->set_flashdata('success', 'Setting updated successfully !');
    redirect($_SERVER['HTTP_REFERER']);
  }
}