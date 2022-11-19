<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Discount extends MY_AdminController {

	public function __construct() {
        parent::__construct(); 
        is_logged_out(); // if user is logout Or session is expired then redirect login
    }
    /**
	 * @method : index()
	 * @date : 2022-06-27
	 * @about: This method use for records all Discount
	 * echo "<pre>"; print_r($this->data['discounts']->result());exit; echo "</pre>";
	 * */
	public function index(){
		$this->data['discounts'] = $this->DiscountModel->fetch_all_discount_records();
		$this->data['meta'] = array('meta_title'=>'Discount Manage','meta_description'=>'');
		$this->load->view('back-end/discount/index-page',$this->data);
	}
	/**
	 * @method : create()
	 * @date : 2022-06-27
	 * @about: This method use for create Discount
	 * 
	 * */
	public function create(){
	    
		$this->form_validation->set_rules('country_id', 'country name', 'required');
		$this->form_validation->set_rules('state_id',   'state name', 'required');
		$this->form_validation->set_rules('city_id',    'city name', 'required');
		$this->form_validation->set_rules('discount_code',    'Discount Code', 'required');
		$this->form_validation->set_rules('discount_start_date', 'Start Date', 'required');
		$this->form_validation->set_rules('discount_end_date',    'End Date', 'required');
		$this->form_validation->set_rules('discount_minimum_amount', 'Minimum Ammount', 'required');
		$this->form_validation->set_rules('discount_user_uses_at_time','User Use Time','required');
		if ($this->form_validation->run() == TRUE){
		   
		    $data['discount_code']           = $this->input->post('discount_code');
			$data['discount_country_id']     = $this->input->post('country_id');
			$data['discount_state_id']       = $this->input->post('state_id');
			$data['discount_city_id']        = $this->input->post('city_id');
			$data['discount_description']    = $this->input->post('discount_description');
			$data['discount_start_date']     = $this->input->post('discount_start_date');
			$data['discount_end_date']       = $this->input->post('discount_end_date');
			$data['discount_minimum_amount'] = $this->input->post('discount_minimum_amount');
			$data['discount_user_uses_at_time'] = $this->input->post('discount_user_uses_at_time');
	     	$data['discount_create_at']      = date('Y-m-d H:i:s');
	     	
			if($this->DiscountModel->save($data)){
				$this->session->set_flashdata('success','Discount successfully created !');
				redirect('admin/discount');
			}else{
				$this->session->set_flashdata('error','Oops something went wrong please try after some time!');
				redirect('admin/discount/create');
			}
		}
		$this->data['meta'] = array('meta_title'=>'Discount Fare Create','meta_description'=>'');
		$this->data['country'] = $this->DiscountModel->_dropdownlist('country_id','country_name','','az_country','Select country','');
		$this->load->view('back-end/discount/create-page',$this->data);
	}
	/**
	 * @method : edit()
	 * @date : 2022-06-27
	 * @about: This method use for edit discount 
	 * 
	 * */
	public function edit(){
		$this->data['meta'] = array('meta_title'=>'Discount update','meta_description'=>'');
		$discount_id = $this->uri->segment(4);
		$this->data['discounts'] = $this->DiscountModel->fetch_discount_by_id($discount_id);
		
	  	$this->form_validation->set_rules('country_id', 'country name', 'required');
		$this->form_validation->set_rules('state_id',   'state name', 'required');
		$this->form_validation->set_rules('city_id',    'city name', 'required');
		$this->form_validation->set_rules('discount_code',    'Discount Code', 'required');
		$this->form_validation->set_rules('discount_start_date',    'Start Date', 'required');
		$this->form_validation->set_rules('discount_end_date',    'End Date', 'required');
		$this->form_validation->set_rules('discount_minimum_amount', 'Minimum Ammount', 'required');
		$this->form_validation->set_rules('discount_user_uses_at_time','User Use Time','required');
		if ($this->form_validation->run() == TRUE){
		    
		    $data['discount_code']           = $this->input->post('discount_code');
			$data['discount_country_id']     = $this->input->post('country_id');
			$data['discount_state_id']       = $this->input->post('state_id');
			$data['discount_city_id']        = $this->input->post('city_id');
			$data['discount_description']    = $this->input->post('discount_description');
			$data['discount_start_date']     = $this->input->post('discount_start_date');
			$data['discount_end_date']       = $this->input->post('discount_end_date');
			$data['discount_minimum_amount'] = $this->input->post('discount_minimum_amount');
			$data['discount_user_uses_at_time'] = $this->input->post('discount_user_uses_at_time');
	     	
			$this->DiscountModel->update(array('discount_id'=>$discount_id),$data);
			$this->session->set_flashdata('success','Discount details successfully updated !');
			redirect('admin/discount');
		}
		$this->data['country'] = $this->DiscountModel->_dropdownlist('country_id','country_name','','az_country','Select country','');
		$this->load->view('back-end/discount/create-edit',$this->data);
	}
	
     // get state names
    function getState() {
        $json = array();
        $CountryID = $this->input->post('CountryID');
        $json = $this->DiscountModel->getState($CountryID);
        header('Content-Type: application/json');
        echo json_encode($json);
    }
    
   // get city names
    function getCity() {
        $json = array();
        $StateID = $this->input->post('StateID');
        $json = $this->DiscountModel->getCity($StateID);
        header('Content-Type: application/json');
        echo json_encode($json);
    }
  
	
}