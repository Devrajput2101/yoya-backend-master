<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Drivers extends MY_AdminController {

	public function __construct() {
        parent::__construct(); 
        is_logged_out(); // if user is logout Or session is expired then redirect login
    }
    /**
	 * @method : index()
	 * @date : 2022-06-22
	 * @about: This method use for records all cutomer
	 * 
	 * */
	public function index(){
		$this->data['drivers'] = $this->DriverModel->fetch_all_driver();
		$this->data['meta'] = array('meta_title'=>'Driver Manage','meta_description'=>'');
		$this->load->view('back-end/drivers/index-page',$this->data);
	}
	/**
	 * @method : create()
	 * @date : 2022-06-10
	 * @about: This method use for create customer
	 * 
	 * */
	public function create(){

		$this->form_validation->set_rules('user_name', 'User name', 'required');
		$this->form_validation->set_rules('user_email', 'Email', 'required|is_unique['.$this->db->dbprefix('users').'.user_email]');
		$this->form_validation->set_rules('user_phone', 'Phone', 'required|is_unique['.$this->db->dbprefix('users').'.user_phone]');
		$this->form_validation->set_rules('user_password', 'Password', 'required');
		if ($this->form_validation->run() == TRUE){
			
			$user_data['user_type']      = 'customer';
			$user_data['user_username']  = user_name($this->input->post('user_name'));
			$user_data['user_referral']  = referral_code(6);
			$user_data['user_create_at'] = date('Y-m-d H:i:s');
			$user_data['user_update_at'] = date('Y-m-d H:i:s');
			$user_data['user_name']  = $this->input->post('user_name');
			$user_data['user_email'] = $this->input->post('user_email');
			$user_data['user_phone'] = $this->input->post('user_phone');
			$user_data['user_password'] = $this->password->hash($this->input->post('user_password'));
			if($last_id = $this->UsersModel->save($user_data)){
				//save as customer
				$customer['customer_user_id']   = $last_id;
				$customer['customer_create_at'] = date('Y-m-d H:i:s');
				$customer['customer_update_at'] = date('Y-m-d H:i:s');
				$this->CustomerModel->save($customer);
				
				$this->session->set_flashdata('success','Customer successfully created !');
				redirect('admin/customer');
			}else{
				$this->session->set_flashdata('error','Oops something went wrong please try after some time!');
				redirect('admin/customer/create');
			}
		}

		$this->data['meta'] = array('meta_title'=>'Customer Create','meta_description'=>'');
		$this->load->view('back-end/customer/create-page',$this->data);
	}
	/**
	 * @method : edit()
	 * @date : 2022-06-10
	 * @about: This method use for edit customer
	 * 
	 * */
	public function edit(){
		$this->data['meta'] = array('meta_title'=>'Customer update','meta_description'=>'');
		$user_id = $this->uri->segment(4);
		$this->data['user_data'] = $this->UsersModel->fetch_user_by_id($user_id);
		
		$this->form_validation->set_rules('user_name', 'User name', 'required');
		$this->form_validation->set_rules('user_email', 'User email', 'required');
		if ($this->form_validation->run() == TRUE){

			$user_data['user_name']  = $this->input->post('user_name');
			$user_data['user_email'] = $this->input->post('user_email');
			$user_data['user_update_at'] = date('Y-m-d H:i:s');
			
			if(!empty($this->input->post('user_password'))){
				$user_data['user_password'] = $this->password->hash($this->input->post('user_password'));
			}
			$this->UsersModel->update(array('user_id'=>$user_id),$user_data);
			$this->session->set_flashdata('success','Driver details successfully updated !');
			redirect('admin/drivers');
		}

		$this->load->view('back-end/drivers/create-edit',$this->data);
	}
	/**
	 * @method : dashboard()
	 * @date : 2022-06-10
	 * @about: This method use for fetch spacial user details
	 * 
	 * */
	public function dashboard(){
		$user_id = $this->uri->segment('4');
     	$this->data['drivers']     = $this->DriverModel->fetch_single_driver($user_id);
		$this->data['completeBookings']    = $this->DriverModel->booking_counts($user_id,['booking_completed']);
		$this->data['cancelBookings'] = $this->DriverModel->booking_counts(['booking_cancel_by_driver','booking_cancel_by_customer','booking_cancel_by_admin']);
		$this->data['ongoingBookings'] = $this->DriverModel->booking_counts(['booking_accepted','booking_started','booking_reached']);
		$this->data['walletsBlance'] = $this->WalletModel->balance(['wallet_user_id'=>$user_id]);
		$this->data['serviceCharge'] = $this->WalletModel->service_charge(['wallet_user_id'=>$user_id,'wallet_uses'=>'applied_service_charge']);
		$this->data['wallets'] = $this->WalletModel->fetch_all_where(['wallet_user_id'=>$user_id]);
		$this->data['bookings'] = $this->BookingModel->fetch_all_booking_where(['booking_driver_id'=>$user_id]);
		
		$this->data['meta'] = array('meta_title'=>'Driver dashboard','meta_description'=>'');
		$this->load->view('back-end/drivers/dashboard',$this->data);
	}
}