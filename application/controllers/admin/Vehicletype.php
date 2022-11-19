<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicletype extends MY_AdminController {

	public function __construct() {
        parent::__construct(); 
        is_logged_out(); // if user is logout Or session is expired then redirect login
    }
    /**
	 * @method : index()
	 * @date : 2022-06-10
	 * @about: This method use for records all vehicle
	 * 
	 * */
	public function index(){
		$this->data['vehicle_type'] = $this->VehicleTypeModel->fetch_all_vehicle_type();
		$this->data['meta'] = array('meta_title'=>'Vehicle Manage','meta_description'=>'');
		$this->load->view('back-end/vehicletype/index-page',$this->data);
	}
	/**
	 * @method : create()
	 * @date : 2022-06-10
	 * @about: This method use for create vehicle
	 * 
	 * */
	public function create(){

		$this->form_validation->set_rules('vehicle_type_name', 'Vahicle name', 'required');
		$this->form_validation->set_rules('vehicle_type_description', 'Vahicle Description', 'required');
		if ($this->form_validation->run() == TRUE){
			
			$data['vehicle_type_name']         = $this->input->post('vehicle_type_name');
			$data['vehicle_type_description']  = $this->input->post('vehicle_type_description');
			$data['vehicle_type_icon']         = $this->input->post('icon');
	     	$data['vehicle_type_create_at']    = date('Y-m-d H:i:s');
	     	
			if($this->VehicleTypeModel->save($data)){
				$this->session->set_flashdata('success','Vahicle Type successfully created !');
				redirect('admin/vehicletype');
			}else{
				$this->session->set_flashdata('error','Oops something went wrong please try after some time!');
				redirect('admin/vehicletype/create');
			}
		}
		$this->data['meta'] = array('meta_title'=>'Vehicle type Create','meta_description'=>'');
		$this->load->view('back-end/vehicletype/create-page',$this->data);
	}
	/**
	 * @method : edit()
	 * @date : 2022-06-10
	 * @about: This method use for edit vehicle type
	 * 
	 * */
	public function edit(){
	    
		$this->data['meta'] = array('meta_title'=>'Vehicle type update','meta_description'=>'');
		$vehicle_id = $this->uri->segment(4);
		$this->data['vehicle_data'] = $this->VehicleTypeModel->fetch_vehicle_by_id($vehicle_id);
		
		$this->form_validation->set_rules('vehicle_type_name', 'Vahicle name', 'required');
		$this->form_validation->set_rules('vehicle_type_description', 'Vahicle Description', 'required');
		if ($this->form_validation->run() == TRUE){
			
			$data['vehicle_type_name']         = $this->input->post('vehicle_type_name');
			$data['vehicle_type_description']  = $this->input->post('vehicle_type_description');
			$data['vehicle_type_icon']         = $this->input->post('icon');
	     	$data['	vehicle_type_update_at']   = date('Y-m-d H:i:s');
	     	
			$this->VehicleTypeModel->update(array('vehicle_type_id'=>$vehicle_id),$data);
			$this->session->set_flashdata('success','vehicle details successfully updated !');
			redirect('admin/vehicletype');
		}

		$this->load->view('back-end/vehicletype/create-edit',$this->data);
	}
	
	/**
   * @method : vehicle status()
   * @date : 2022-06-08
   * @about: This method use for status change by ajax
   * 
   * */
  public function vehiclestatus(){
    $status['vehicle_type_status'] = $this->input->post('status');
    $status['vehicle_type_update_at'] = date('Y-m-d H:i:s');
    $this->VehicleTypeModel->update(array('vehicle_type_id'=>$this->input->post('vehicle_type_id')),$status);
  }
	
}