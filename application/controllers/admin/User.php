<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_AdminController {
	public function __construct() {
        parent::__construct(); 
        is_logged_out(); // if user is logout Or session is expired then redirect login
    }

	public function index(){
	   
		$this->data['userdata'] = $this->UsersModel->fetch_user_by_session_id();
		$this->data['meta'] = array('meta_title'=>'Dashboard','meta_description'=>'');
		$this->load->view('back-end/user/dashboard',$this->data);
	}
         
		public function profile(){
	    
	    $this->data['meta'] = array('meta_title'=>'Profile update','meta_description'=>'');
		$user_id = $this->session->userdata('user_id');
		$this->data['user_data'] = $this->UsersModel->fetch_user_by_id($user_id);
		
		$this->form_validation->set_rules('user_name', 'User name', 'required');
		if ($this->form_validation->run() == TRUE){
		
			$user_data['user_username']  = $this->input->post('user_username');
			$user_data['user_name']  = $this->input->post('user_name');
			$user_data['user_email'] = $this->input->post('user_email');
			$user_data['user_phone'] = $this->input->post('user_phone');
			$user_data['user_update_at'] = date('Y-m-d H:i:s');
			if(!empty($this->input->post('user_password'))){
				$user_data['user_password'] = $this->password->hash($this->input->post('user_password'));
			}
			$this->UsersModel->update(array('user_id'=>$user_id),$user_data);
			$this->session->set_flashdata('success','user details successfully updated !');
			redirect('admin/user/profile');
		}
	    
		$this->load->view('back-end/user/user-profile-page',$this->data);    
	    
	}
	
}