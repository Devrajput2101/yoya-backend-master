<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Rentalpackage extends MY_AdminController {

    public function __construct() {
        parent::__construct();
        is_logged_out(); // if user is logout Or session is expired then redirect login
        $this->data['country'] = $this->CountrysModel->_dropdownlist();
        $this->data['states'] = $this->StateModel->_dropdownlist();
        $this->data['cities'] = $this->CitysModel->_dropdownslist();
    }
    /**
     * @method : rules()
     * @date : 2022-11-10
     * @about: This method use for set common rules of create and updated time in
     */
    public function rules() {
        $config = array(
        	array(
        		'field' => 'rental_name',
        		'label' => 'Rental Name',
        		'rules' => 'required|trim'
        	), array(
        		'field' => 'rental_hour_value',
        		'label' => 'Rental Hour Value', 
        		'rules' => 'required|trim'
        	),array(
        		'field' => 'rental_distance_value', 
        		'label' => 'Rental Distance', 
        		'rules' => 'required|trim'
        	), 
        );
        $this->form_validation->set_rules($config);
    }
    /**
     * @method : index()
     * @date : 2022-11-10
     * @about: This method use for records all vehicle
     */
    public function index() {
        $this->data['package'] = $this->RentalPakageModel->fetch_all();
        $this->load->view('back-end/systemconfig/rentalpackage-index', $this->data);
    }
	/**
     * @method : create()
     * @date : 2022-11-10
     * @about: This method use for create a new record or data 
     */
	public function create(){
		$this->rules();
        if ($this->form_validation->run() == TRUE) {
            $data['rental_name'] = $this->input->post('rental_name');
            $data['rental_hour_text'] = $this->input->post('rental_hour_value').' hr';
            $data['rental_hour_value'] = $this->input->post('rental_hour_value');
            $data['rental_distance_text'] = $this->input->post('rental_distance_value').' Km.';
            $data['rental_distance_value'] = $this->input->post('rental_distance_value');
			
            if ($this->RentalPakageModel->save($data)) {
                $this->session->set_flashdata('success', 'Rental Package successfully created !');
                redirect('admin/rentalpackage');
            } else {
                $this->session->set_flashdata('error', 'Oops something went wrong please try after some time!');
                redirect('admin/rentalpackage/create');
            }
        }
        $this->load->view('back-end/systemconfig/rentalpackage-create', $this->data);
	}
	/**
     * @method : update()
     * @date : 2022-11-10
     * @about: This method use for update vihicle package fare 
     */
    public function update() {
		$this->rules();
        if ($this->form_validation->run() == TRUE) {
            $data['rental_name'] = $this->input->post('rental_name');
            $data['rental_hour_text'] = $this->input->post('rental_hour_value').' hr';
            $data['rental_hour_value'] = $this->input->post('rental_hour_value');
			$data['rental_distance_text'] = $this->input->post('rental_distance_value').' Km.';
            $data['rental_distance_value'] = $this->input->post('rental_distance_value');
			
			if ($this->RentalPakageModel->update(array('rental_id'=>$this->uri->segment(4)),$data)) {
                $this->session->set_flashdata('success', 'Rental Package successfully updated !');
                redirect('admin/rentalpackage');
            } else {
                $this->session->set_flashdata('error', 'Oops something went wrong please try after some time!');
                redirect('admin/rentalpackage/create');
            }
        }

		$this->data['single'] = $this->RentalPakageModel->single(array('rental_id'=>$this->uri->segment(4)));
        $this->load->view('back-end/systemconfig/rentalpackage-edit', $this->data);
    }
	/**
     * @method : remove()
     * @date : 2022-11-10
     * @about: This method use for remove pakage fare
     */
    public function remove() {
        if ($this->RentalPakageModel->delete(array('rental_id' => $this->uri->segment(4)))) {
            $this->session->set_flashdata('success', 'Rental Package successfully removed !');
            redirect('admin/rentalpackage');
        } else {
            $this->session->set_flashdata('error', 'Oops something went wrong please try after some time!');
            redirect('admin/rentalpackage');
        }
    }
}
