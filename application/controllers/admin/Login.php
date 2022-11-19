<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_AdminController {
	
	public function __construct() {
        parent::__construct(); 
        is_logged_in(); // if user is login then redirect dashboard
    }

	public function index(){
		$this->data['meta'] = array('meta_title'=>'Login','meta_description'=>'');

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if ($this->form_validation->run() == TRUE){
			$checkuser = $this->LoginModel->check_user_username($this->input->post());
			if($checkuser){
				$userdata = $this->LoginModel->fetch_user_by_username($this->input->post());
				$post_password  = $this->input->post('password');
				$store_password = $userdata->user_password;
				//check password 
				if($this->password->verify_hash($post_password,$store_password)){
					$set_user_data['user_name']  = $userdata->user_name;
					$set_user_data['user_email'] = $userdata->user_email;
					$set_user_data['user_id']    = $userdata->user_id;
					$set_user_data['user_is_loggedin'] = true;
					$this->session->set_userdata($set_user_data);
					$this->session->set_flashdata('success','logged in successfully !');
					redirect('admin/dashboard');
				}else{
					$this->session->set_flashdata('error','Password is incorrect please try again !');
					redirect('admin/login');
				}
			}else{
				$this->session->set_flashdata('error','Username is incorrect please try again !');
				redirect('admin/login');
			}
		}
		$this->load->view('back-end/auth/index-page',$this->data);
	}
}
