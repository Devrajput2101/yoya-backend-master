<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Outstation extends MY_AdminController {

	public function __construct() {
        parent::__construct(); 
        is_logged_out(); // if user is logout Or session is expired then redirect login

        $this->data['country'] = $this->CountrysModel->_dropdownlist();
        $this->data['states'] = $this->StateModel->_dropdownlist();
        $this->data['cities'] = $this->CitysModel->_dropdownslist();
        $this->data['vehicles'] = $this->VehicleModel->_dropdownlist();
    }

    public function rules() {
        $config = array(
        	array(
        		'field' => 'vehicle_id',
        		'label' => 'Vahicle Name',
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
        		'field' => 'fare_per_km_price', 
        		'label' => 'Per Km. Price', 
        		'rules' => 'required|numeric|trim'
        	), array(
        		'field' => 'fare_per_minutes_price', 
        		'label' => 'From', 
        		'rules' => 'required|numeric|trim'
        	), array(
        		'field' => 'fare_night_price', 
        		'label' => ' Fare Night', 
        		'rules' => 'required|numeric|trim'
        	), array(
        		'field' => 'fare_driver_allowance', 
        		'label' => 'Fare Deriver Allowance', 
        		'rules' => 'required|numeric|trim'
        	), array(
        		'field' => 'fare_commission', 
        		'label' => 'Fare Commission', 
        		'rules' => 'required|numeric|trim'
        	),
        );
        $this->form_validation->set_rules($config);
    }
    /**
     * @method : index()
     * @date : 2022-09-24
     * @about: This method use for records all vehicle
     *
     *
     */
    public function index() {
        $this->data['outstation'] = $this->OutstationModel->fetch_all_vehiclefare();
       // dd($this->data['outstation']);
        $this->load->view('back-end/outstationfare/index-page', $this->data);
    }

    public function create(){
	    
        $this->rules();
		if ($this->form_validation->run() == TRUE){
		 	$data['fare_country_id']         = $this->input->post('country_id');
			$data['fare_state_id']           = $this->input->post('state_id');
			$data['fare_city_id']            = $this->input->post('city_id');
            $data['fare_vehicle_id']         = $this->input->post('vehicle_id');
			$data['fare_base_price']         = $this->input->post('fare_base_price');
			$data['fare_per_km_price']      = $this->input->post('fare_per_km_price');
			$data['fare_per_minutes_price']     = $this->input->post('fare_per_minutes_price');
			$data['fare_night_price']        = $this->input->post('fare_night_price');
			$data['fare_driver_allowance']= $this->input->post('fare_driver_allowance');
			$data['fare_commission']         = $this->input->post('fare_commission');
			$data['fare_create_at']          = date('Y-m-d H:i:s');
			if($this->OutstationModel->save($data)){
				$this->session->set_flashdata('success','Vahicle Fare successfully created !');
				redirect('admin/outstation');
			}else{
				$this->session->set_flashdata('error','Oops something went wrong please try after some time!');
				redirect('admin/outstation/create');
			}
		}
		$this->data['meta'] = array('meta_title'=>'Vehicle Fare Create','meta_description'=>'');
		$this->load->view('back-end/outstationfare/create-page',$this->data);
	}

    public function update(){
		$vehiclefare_id = $this->uri->segment(4);
		$this->data['outstation'] = $this->OutstationModel->single(array('fare_id'=>$vehiclefare_id));
		$this->rules();
		if ($this->form_validation->run() == TRUE){
		   	$data['fare_vehicle_id']         = $this->input->post('vehicle_id');
			$data['fare_country_id']         = $this->input->post('country_id');
			$data['fare_state_id']           = $this->input->post('state_id');
			$data['fare_city_id']            = $this->input->post('city_id');
			$data['fare_base_price']         = $this->input->post('fare_base_price');
			$data['fare_per_km_price']      = $this->input->post('fare_per_km_price');
			$data['fare_per_minutes_price']     = $this->input->post('fare_per_minutes_price');
			$data['fare_night_price']        = $this->input->post('fare_night_price');
			$data['fare_driver_allowance']= $this->input->post('fare_driver_allowance');
			$data['fare_commission']         = $this->input->post('fare_commission');
			
            $this->OutstationModel->update(array('fare_id'=>$vehiclefare_id),$data);
			$this->session->set_flashdata('success','vehiclefare details successfully updated !');
			redirect('admin/outstation');
           //  dd($this->data['outstation']);
		}
		$this->load->view('back-end/outstationfare/create-edit',$this->data);
	}

    public function remove() {
        if ($this->OutstationModel->delete(array('fare_id' => $this->uri->segment(4)))) {
            $this->session->set_flashdata('success', 'Package Fare successfully removed !');
            redirect('admin/outstation');
        } else {    
            $this->session->set_flashdata('error', 'Oops something went wrong please try after some time!');
            redirect('admin/outstation');
        }
    }
}