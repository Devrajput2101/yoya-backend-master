<?php defined('BASEPATH') OR exit('No direct script access allowed');
class States extends MY_AdminController {
    public function __construct() {
        parent::__construct();
        is_logged_out(); // if user is logout Or session is expired then redirect login
        $this->data['country'] = $this->CountrysModel->_dropdownlist();
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
        		'field' => 'country_id',
        		'label' => 'Country',
        		'rules' => 'required|trim'
        	), array(
        		'field' => 'state_name', 
        		'label' => 'State name', 
        		'rules' => 'required|trim'
        	)
        );
        $this->form_validation->set_rules($config);
    }
    /**
     * @method : index()
     * @date : 2022-06-23
     * @about: This method use for records all states
     *
     *
     */
    public function index() {
        $this->data['states'] = $this->StateModel->fetch_all_state();
        $this->data['meta'] = array('meta_title' => 'State Manage', 'meta_description' => '');
        $this->load->view('back-end/states/index-page', $this->data);
    }
    /**
     * @method : create()
     * @date : 2022-06-23
     * @about: This method use for create states
     *
     *
     */
    public function create() {
        $this->rules();
        if ($this->form_validation->run() == TRUE) {
            $data['state_country_id'] = $this->input->post('country_id');
            $data['state_name'] = $this->input->post('state_name');
            if ($this->StateModel->save($data)) {
                $this->session->set_flashdata('success', 'State successfully created !');
                redirect('admin/states');
            } else {
                $this->session->set_flashdata('error', 'Oops something went wrong please try after some time!');
                redirect('admin/states/create');
            }
        }
        $this->data['meta'] = array('meta_title' => 'State Create', 'meta_description' => '');
        $this->load->view('back-end/states/create-page', $this->data);
    }
    /**
     * @method : edit()
     * @date : 2022-06-23
     * @about: This method use for edit states
     *
     *
     */
    public function edit() {
        $this->data['meta'] = array('meta_title' => 'State update', 'meta_description' => '');
        $state_id = $this->uri->segment(4);
        $this->data['state'] = $this->StateModel->fetch_state_by_id($state_id);
        $this->rules();
        if ($this->form_validation->run() == TRUE) {
            $data['state_country_id'] = $this->input->post('country_id');
            $data['state_name'] = $this->input->post('state_name');
            $this->StateModel->update(array('state_id' => $state_id), $data);
            $this->session->set_flashdata('success', 'State successfully updated !');
            redirect('admin/states');
        }
        $this->load->view('back-end/states/create-edit', $this->data);
    }
    /**
     * @method : getState()
     * @date : 2022-09-25
     * @about: This method use for fetch state by ajax country 
     */
    // get state names
    function getState() {
        $json = array();
        $CountryID = $this->input->post('CountryID');
        $json = $this->StateModel->getState($CountryID);
        header('Content-Type: application/json');
        echo json_encode($json);
    }

    /**
     * @method : status()
     * @date : 2022-06-25
     * @about: This method use for status updated
     */
    public function status(){
	    $status['state_status']    = $this->input->post('status');
        $this->StateModel->update(array('state_id' => $this->input->post('state_id')), $status);
	}
}
