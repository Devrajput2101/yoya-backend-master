<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicle extends MY_AdminController {

	public function __construct() {
        parent::__construct(); 
        is_logged_out(); // if user is logout Or session is expired then redirect login
    }
    /**
     * @method : rules()
     * @date : 2022-09-24
     * @about: This method use for set common rules of create and updated time in
     *
     *
     */
    public function rules() {
        $config = array(
        	array(
        		'field' => 'vehicle_type_id',
        		'label' => 'Vehicle Type',
        		'rules' => 'required|trim'
        	), array(
        		'field' => 'vehicle_name', 
        		'label' => 'Vehicle name', 
        		'rules' => 'required|trim'
        	), array(
        		'field' => 'vehicle_description',
        		'label' => 'Vehicle description', 
        		'rules' => 'required|trim'
        	)
        );
        $this->form_validation->set_rules($config);
    }
    /**
	 * @method : index()
	 * @date : 2022-06-23
	 * @about: This method use for records all vehicle
	 * 
	 * */
	public function index(){
		$this->data['vehicle'] = $this->VehicleModel->fetch_all_vehicle();
		$this->data['meta'] = array('meta_title'=>'Vehicle Manage','meta_description'=>'');
		$this->load->view('back-end/vehicle/index-page',$this->data);
	}
	/**
	 * @method : create()
	 * @date : 2022-06-23
	 * @about: This method use for create vehicle
	 * 
	 * */
	public function create(){
		$this->rules();
		if ($this->form_validation->run() == TRUE){
			$data['vehicle_vehicle_type_id'] = $this->input->post('vehicle_type_id');
			$data['vehicle_name']            = $this->input->post('vehicle_name');
			$data['vehicle_description']     = $this->input->post('vehicle_description');
			$data['vehicle_icon']            = $this->input->post('icon');
	     	$data['vehicle_create_at']       = date('Y-m-d H:i:s');
	     	
			if($this->VehicleModel->save($data)){
				$this->session->set_flashdata('success','Vahicle successfully created !');
				redirect('admin/vehicle');
			}else{
				$this->session->set_flashdata('error','Oops something went wrong please try after some time!');
				redirect('admin/vehicle/create');
			}
		}
		$this->data['meta'] = array('meta_title'=>'Vehicle Create','meta_description'=>'');
		$this->data['vehicle_type'] = $this->VehicleTypeModel->_dropdownlist();
		$this->load->view('back-end/vehicle/create-page',$this->data);
	}
	/**
	 * @method : edit()
	 * @date : 2022-06-23
	 * @about: This method use for edit vehicle 
	 * 
	 * */
	public function edit(){
	    
		$this->data['meta'] = array('meta_title'=>'Vehicle type update','meta_description'=>'');
		$vehicle_id = $this->uri->segment(4);
		$this->data['vehicle_data'] = $this->VehicleModel->fetch_vehicle_by_id($vehicle_id);
		
		$this->rules();
		if ($this->form_validation->run() == TRUE){
		    
			$data['vehicle_vehicle_type_id'] = $this->input->post('vehicle_type_id');
			$data['vehicle_name']            = $this->input->post('vehicle_name');
			$data['vehicle_description']     = $this->input->post('vehicle_description');
			$data['vehicle_icon']            = $this->input->post('icon');
	     	$data['vehicle_update_at']       = date('Y-m-d H:i:s');
	     	
			$this->VehicleModel->update(array('vehicle_id'=>$vehicle_id),$data);
			$this->session->set_flashdata('success','vehicle details successfully updated !');
			redirect('admin/vehicle');
		}
	    $this->data['vehicle_type'] = $this->VehicleTypeModel->_dropdownlist();
		$this->load->view('back-end/vehicle/create-edit',$this->data);
	}
	
	/**
   * @method : vehicle status()
   * @date : 2022-06-23
   * @about: This method use for status change by ajax
   * 
   * */
  public function vehiclestatus(){
    $status['vehicle_status'] = $this->input->post('status');
    $status['vehicle_update_at'] = date('Y-m-d H:i:s');
    $this->VehicleModel->update(array('vehicle_id'=>$this->input->post('vehicle_id')),$status);
  }
  
}