<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Vehiclefare extends MY_AdminController {

	public function __construct() {
        parent::__construct(); 
        is_logged_out(); // if user is logout Or session is expired then redirect login
    	$this->data['vehicles'] = $this->VehicleModel->_dropdownlist();
		$this->data['country'] = $this->CountrysModel->_dropdownlist();
		$this->data['states'] = $this->StateModel->_dropdownlist();
        $this->data['cities'] = $this->CitysModel->_dropdownslist();
    }
	/**
     * @method : rules_for_create()
     * @date : 2022-09-24
     * @about: This method use for set common rules_for_create of create and updated time in
     */
    public function rules_for_create() {
        $config = array(
        	array(
        		'field' => 'vehicle_id',
        		'label' => 'vehicle',
        		'rules' => 'required|numeric|trim|callback_validate_duplicate_fares'
        	), array(
        		'field' => 'country_id', 
        		'label' => 'Country', 
        		'rules' => 'required|numeric|trim'
        	), array(
        		'field' => 'state_id',
        		'label' => 'State', 
        		'rules' => 'required|numeric|trim'
        	), array(
        		'field' => 'city_id', 
        		'label' => 'City', 
        		'rules' => 'required|numeric|trim|callback_validate_duplicate_fares'
        	), array(
        		'field' => 'fare_base_price', 
        		'label' => 'Base Price', 
        		'rules' => 'required|numeric|trim'
        	), array(
        		'field' => 'fare_general_price', 
        		'label' => 'General hour charges', 
        		'rules' => 'required|numeric|trim'
        	), array(
        		'field' => 'fare_business_price', 
        		'label' => 'Business hour charges', 
        		'rules' => 'required|numeric|trim'
        	), array(
        		'field' => 'fare_night_price', 
        		'label' => 'Night hour charges', 
        		'rules' => 'required|numeric|trim'
        	),array(
        		'field' => 'fare_extra_waiting_price', 
        		'label' => 'Extra waiting charges', 
        		'rules' => 'required|numeric|trim'
        	),array(
        		'field' => 'fare_under_distance', 
        		'label' => 'Under distance', 
        		'rules' => 'required|numeric|trim'
        	),
        );
		
        $this->form_validation->set_rules($config);
    }

	/**
     * @method : rules_for_update()
     * @date : 2022-09-24
     * @about: This method use for set common rules_for_update of create and updated time in
     */
    public function rules_for_update() {
        $config = array(
        	array(
        		'field' => 'vehicle_id',
        		'label' => 'vehicle',
        		'rules' => 'required|numeric|trim'
        	), array(
        		'field' => 'country_id', 
        		'label' => 'Country', 
        		'rules' => 'required|numeric|trim'
        	), array(
        		'field' => 'state_id',
        		'label' => 'State', 
        		'rules' => 'required|numeric|trim'
        	), array(
        		'field' => 'city_id', 
        		'label' => 'City', 
        		'rules' => 'required|numeric|trim'
        	), array(
        		'field' => 'fare_base_price', 
        		'label' => 'Base Price', 
        		'rules' => 'required|numeric|trim'
        	), array(
        		'field' => 'fare_general_price', 
        		'label' => 'General hour charges', 
        		'rules' => 'required|numeric|trim'
        	), array(
        		'field' => 'fare_business_price', 
        		'label' => 'Business hour charges', 
        		'rules' => 'required|numeric|trim'
        	), array(
        		'field' => 'fare_night_price', 
        		'label' => 'Night hour charges', 
        		'rules' => 'required|numeric|trim'
        	),array(
        		'field' => 'fare_extra_waiting_price', 
        		'label' => 'Extra waiting charges', 
        		'rules' => 'required|numeric|trim'
        	),array(
        		'field' => 'fare_under_distance', 
        		'label' => 'Under distance', 
        		'rules' => 'required|numeric|trim'
        	),
        );
		
        $this->form_validation->set_rules($config);
    }
	/**
	 * @method : validate_duplicate_fares()
	 * @date : 2022-11-11
	 * @about: This method use for check duplicate fare at create time
	 * 
	 * */
	public function validate_duplicate_fares(){
		$vehicle_id = $this->input->post('vehicle_id');
		$city_id    = $this->input->post('city_id');
		$check   = $this->VehiclefareModel->check_duplicate_fare(array('fare_vehicle_id'=>$vehicle_id,'fare_city_id'=>$city_id));
		if ($check) {
			$this->form_validation->set_message('validate_duplicate_fares', 'The city or vehicle field must contain a unique value this city or vehicle is already exist that fare !.');
			return false;
		} 
		return true;
	}
    /**
	 * @method : index()
	 * @date : 2022-06-23
	 * @about: This method use for records all vehicle
	 * 
	 * */
	public function index(){
		$this->data['vehiclefare'] = $this->VehiclefareModel->fetch_all_vehiclefare();$this->data['meta'] = array('meta_title'=>'Vehiclefare Manage','meta_description'=>'');
		$this->load->view('back-end/vehiclefare/index-page',$this->data);
	}
	/**
	 * @method : create()
	 * @date : 2022-06-23
	 * @about: This method use for create vehicle
	 * */
	public function create(){
		$this->rules_for_create();
		if ($this->form_validation->run() == TRUE){
			$data['fare_vehicle_id']         = $this->input->post('vehicle_id');
			$data['fare_country_id']         = $this->input->post('country_id');
			$data['fare_state_id']           = $this->input->post('state_id');
			$data['fare_city_id']            = $this->input->post('city_id');
			$data['fare_base_price']         = $this->input->post('fare_base_price');
			$data['fare_general_price']      = $this->input->post('fare_general_price');
			$data['fare_business_price']     = $this->input->post('fare_business_price');
			$data['fare_night_price']        = $this->input->post('fare_night_price');
			$data['fare_extra_waiting_price']= $this->input->post('fare_extra_waiting_price');
			$data['fare_stop_price']         = $this->input->post('fare_stop_price');
			$data['fare_commission']         = $this->input->post('fare_commission');
			$data['fare_time_free']          = $this->input->post('fare_time_free');
			$data['fare_under_distance']          = $this->input->post('fare_under_distance');
	     	$data['fare_create_at']          = date('Y-m-d H:i:s');
			if($this->VehiclefareModel->save($data)){
				$this->session->set_flashdata('success','Vahicle Fare successfully created !');
				redirect('admin/vehiclefare');
			}else{
				$this->session->set_flashdata('error','Oops something went wrong please try after some time!');
				redirect('admin/vehiclefare/create');
			}
		}
		$this->data['meta'] = array('meta_title'=>'Vehicle Fare Create','meta_description'=>'');
		$this->load->view('back-end/vehiclefare/create-page',$this->data);
	}
	/**
	 * @method : edit()
	 * @date : 2022-06-23
	 * @about: This method use for edit vehicle 
	 * */
	public function edit(){
		$this->data['meta'] = array('meta_title'=>'Vehicle Fare update','meta_description'=>'');
		$vehiclefare_id = $this->uri->segment(4);
		$this->data['vehiclefare_data'] = $this->VehiclefareModel->fetch_vehiclefare_by_id($vehiclefare_id);
	    $this->rules_for_update();
		if ($this->form_validation->run() == TRUE){
			$data['fare_vehicle_id']         = $this->input->post('vehicle_id');
			$data['fare_country_id']         = $this->input->post('country_id');
			$data['fare_state_id']           = $this->input->post('state_id');
			$data['fare_city_id']            = $this->input->post('city_id');
			$data['fare_base_price']         = $this->input->post('fare_base_price');
			$data['fare_general_price']      = $this->input->post('fare_general_price');
			$data['fare_business_price']     = $this->input->post('fare_business_price');
			$data['fare_night_price']        = $this->input->post('fare_night_price');
			$data['fare_extra_waiting_price']= $this->input->post('fare_extra_waiting_price');
			$data['fare_stop_price']         = $this->input->post('fare_stop_price');
			$data['fare_commission']         = $this->input->post('fare_commission');
			$data['fare_time_free']          = $this->input->post('fare_time_free');
			$data['fare_under_distance']          = $this->input->post('fare_under_distance');
			$this->VehiclefareModel->update(array('fare_id'=>$vehiclefare_id),$data);
			$this->session->set_flashdata('success','vehiclefare details successfully updated !');
			redirect('admin/vehiclefare');
		}
		$this->load->view('back-end/vehiclefare/create-edit',$this->data);
	}
	/**
     * @method : remove()
     * @date : 2022-11-10
     * @about: This method use for remove pakage fare
     */
    public function remove() {
        if ($this->VehiclefareModel->delete(array('fare_id' => $this->uri->segment(4)))) {
            $this->session->set_flashdata('success', 'Record successfully removed !');
            redirect('admin/vehiclefare');
        } else {
            $this->session->set_flashdata('error', 'Oops something went wrong please try after some time!');
            redirect('admin/vehiclefare');
        }
    }
}
