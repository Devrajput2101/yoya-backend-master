<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Transport extends MY_AdminController {

    public function __construct() {
        parent::__construct();
        is_logged_out(); // if user is logout Or session is expired then redirect login
        $this->data['country'] = $this->CountrysModel->_dropdownlist();
        $this->data['states'] = $this->StateModel->_dropdownlist();
        $this->data['cities'] = $this->CitysModel->_dropdownslist();
        $this->data['vehicles'] = $this->VehicleModel->_dropdownlist();
    }
    /**
     * @method : rules()
     * @date : 2022-10-18
     * @about: This method use for set common rules of create and updated time in
     */
    public function rules() {
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
        		'label' => 'Fare General Price', 
        		'rules' => 'required|numeric|trim'
        	), array(
        		'field' => 'fare_business_price', 
        		'label' => 'Fare business Price', 
        		'rules' => 'required|numeric|trim'
        	), array(
        		'field' => 'fare_night_price', 
        		'label' => 'Fare Night Price', 
        		'rules' => 'required|numeric|trim'
        	), array(
        		'field' => 'fare_extra_waiting_price', 
        		'label' => 'Fare extra Waiting price', 
        		'rules' => 'required|numeric|trim'
        	), array(
        		'field' => 'fare_stop_price', 
        		'label' => 'Fare Stop Price', 
        		'rules' => 'required|numeric|trim'
			),array(
        		'field' => 'fare_commission', 
        		'label' => 'Fare Comission', 
        		'rules' => 'required|numeric|trim'
			),array(
        		'field' => 'fare_time_free', 
        		'label' => 'Fare Time Fee', 
        		'rules' => 'required|numeric|trim'
			),
        );
        $this->form_validation->set_rules($config);
    }
     /**
     * @method : index()
     * @date : 2022-10-18
     * @about: This method use for records all vehicle
     */
    public function index() {
        $this->data['transport'] = $this->TransportfareModel->fetch_all_transportfare();
		//dd($this->data['transport']);
        $this->load->view('back-end/transport/index-page', $this->data);
    }

	public function create(){
	    
        $this->rules();
		if ($this->form_validation->run() == TRUE){
		 	$data['fare_country_id']         = $this->input->post('country_id');
			$data['fare_state_id']           = $this->input->post('state_id');
			$data['fare_city_id']            = $this->input->post('city_id');
            $data['fare_vehicle_id']         = $this->input->post('vehicle_id');
			$data['fare_base_price']         = $this->input->post('fare_base_price');
			$data['fare_general_price']      = $this->input->post('fare_general_price');
			$data['fare_business_price']     = $this->input->post('fare_business_price');
			$data['fare_night_price']        = $this->input->post('fare_night_price');
			$data['fare_extra_waiting_price']= $this->input->post('fare_extra_waiting_price');
			$data['fare_stop_price']		 = $this->input->post('fare_stop_price');
			$data['fare_commission']         = $this->input->post('fare_commission');
			$data['fare_time_free']         = $this->input->post('fare_time_free');
			if($this->TransportfareModel->save($data)){
				$this->session->set_flashdata('success','Transport Fare successfully created !');
				redirect('admin/transport');
			}else{
				$this->session->set_flashdata('error','Oops something went wrong please try after some time!');
				redirect('admin/transport/create');
			}
		}
		$this->data['meta'] = array('meta_title'=>'Transport Fare Create','meta_description'=>'');
		$this->load->view('back-end/transport/create-page',$this->data);
	}

    public function update(){
		$vehiclefare_id = $this->uri->segment(4);
		$this->data['transport'] = $this->TransportfareModel->single(array('fare_id'=>$vehiclefare_id));
		$this->rules();
		if ($this->form_validation->run() == TRUE){
			$data['fare_country_id']        = $this->input->post('country_id');
		   $data['fare_state_id']           = $this->input->post('state_id');
		   $data['fare_city_id']            = $this->input->post('city_id');
		   $data['fare_vehicle_id']         = $this->input->post('vehicle_id');
		   $data['fare_base_price']         = $this->input->post('fare_base_price');
		   $data['fare_general_price']      = $this->input->post('fare_general_price');
		   $data['fare_business_price']     = $this->input->post('fare_business_price');
		   $data['fare_night_price']        = $this->input->post('fare_night_price');
		   $data['fare_extra_waiting_price']= $this->input->post('fare_extra_waiting_price');
		   $data['fare_stop_price']         = $this->input->post('fare_stop_price');
		   $data['fare_commission']         = $this->input->post('fare_commission');
		   $data['fare_time_free']          = $this->input->post('fare_time_free');
			
            $this->TransportfareModel->update(array('fare_id'=>$vehiclefare_id),$data);
			$this->session->set_flashdata('success','vehiclefare details successfully updated !');
			redirect('admin/transport');
            // dd($this->data['outstation']);
		}
		$this->load->view('back-end/transport/update-page',$this->data);
	}

    public function remove() {
        if ($this->TransportfareModel->delete(array('fare_id' => $this->uri->segment(4)))) {
            $this->session->set_flashdata('success', 'Package Fare successfully removed !');
            redirect('admin/transport');
        } else {    
            $this->session->set_flashdata('error', 'Oops something went wrong please try after some time!');
            redirect('admin/transport');
        }
    }
}