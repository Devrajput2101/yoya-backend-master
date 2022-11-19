<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Rental extends MY_AdminController {

    public function __construct() {
        parent::__construct();
        is_logged_out(); // if user is logout Or session is expired then redirect login
        $this->data['country'] = $this->CountrysModel->_dropdownlist();
        $this->data['states'] = $this->StateModel->_dropdownlist();
        $this->data['cities'] = $this->CitysModel->_dropdownslist();
        $this->data['vehicles'] = $this->VehicleModel->_dropdownlist();
		$this->data['rentalpakages'] = $this->RentalPakageModel->_dropdownlist();
    }
    /**
     * @method : rules()
     * @date : 2022-10-14
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
        		'field' => 'fare_rental_id', 
        		'label' => 'Package id', 
        		'rules' => 'required|numeric|trim'
        	), array(
        		'field' => 'fare_per_minutes', 
        		'label' => 'Per minutes cost', 
        		'rules' => 'required|numeric|trim'
        	), 
        );
        $this->form_validation->set_rules($config);
    }
    /**
     * @method : index()
     * @date : 2022-10-14
     * @about: This method use for records all vehicle
     */
    public function index() {
        $this->data['rentalfares'] = $this->RentalFareModel->fetch_all();
        $this->load->view('back-end/rental/index-page', $this->data);
    }
	/**
     * @method : create()
     * @date : 2022-10-18
     * @about: This method use for create a new record or data 
     */
	public function create(){
		$this->rules();
        if ($this->form_validation->run() == TRUE) {
            $data['fare_vehicle_id'] = $this->input->post('vehicle_id');
            $data['fare_country_id'] = $this->input->post('country_id');
            $data['fare_state_id'] = $this->input->post('state_id');
            $data['fare_base_price'] = $this->input->post('fare_base_price');
			$data['fare_general_price'] = $this->input->post('fare_general_price');
			$data['fare_per_minutes'] = $this->input->post('fare_per_minutes');
			$data['fare_rental_id'] = $this->input->post('fare_rental_id');
			$data['fare_city_id'] = $this->input->post('city_id');
            if ($this->RentalFareModel->save($data)) {
                $this->session->set_flashdata('success', 'Package Fare successfully created !');
                redirect('admin/rental');
            } else {
                $this->session->set_flashdata('error', 'Oops something went wrong please try after some time!');
                redirect('admin/rental/create');
            }
        }
        $this->load->view('back-end/rental/create-page', $this->data);
	}
	/**
     * @method : update()
     * @date : 2022-10-18
     * @about: This method use for update vihicle package fare 
     */
    public function update() {
		$this->rules();
        if ($this->form_validation->run() == TRUE) {
            $data['fare_vehicle_id'] = $this->input->post('vehicle_id');
            $data['fare_country_id'] = $this->input->post('country_id');
            $data['fare_state_id'] = $this->input->post('state_id');
			$data['fare_city_id'] = $this->input->post('city_id');
            $data['fare_base_price'] = $this->input->post('fare_base_price');
			$data['fare_general_price'] = $this->input->post('fare_general_price');
			$data['fare_per_minutes'] = $this->input->post('fare_per_minutes');
			$data['fare_rental_id'] = $this->input->post('fare_rental_id');
			if ($this->RentalFareModel->update(array('fare_id'=>$this->uri->segment(4)),$data)) {
                $this->session->set_flashdata('success', 'Package Fare successfully updated !');
                redirect('admin/rental');
            } else {
                $this->session->set_flashdata('error', 'Oops something went wrong please try after some time!');
                redirect('admin/rental/create');
            }
        }
		$this->data['single'] = $this->RentalFareModel->single(array('fare_id'=>$this->uri->segment(4)));
        $this->load->view('back-end/rental/update-page', $this->data);
    }
	/**
     * @method : remove()
     * @date : 2022-10-18
     * @about: This method use for remove pakage fare
     */
    public function remove() {
        if ($this->RentalFareModel->delete(array('fare_id' => $this->uri->segment(4)))) {
            $this->session->set_flashdata('success', 'Package Fare successfully removed !');
            redirect('admin/rental');
        } else {
            $this->session->set_flashdata('error', 'Oops something went wrong please try after some time!');
            redirect('admin/rental');
        }
    }
}
