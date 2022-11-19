<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Countrys extends MY_AdminController {
    public function __construct() {
        parent::__construct();
        is_logged_out(); // if user is logout Or session is expired then redirect login
        
    }

    public function rules(){
        $config = array(
                array(
                        'field' => 'country_name',
                        'label' => 'Country name',
                        'rules' => 'required'
                ),
                array(
                        'field' => 'country_code',
                        'label' => 'Country Code',
                        'rules' => 'required'
                ),
                array(
                        'field' => 'country_iso_code',
                        'label' => 'Country ISO(Code)',
                        'rules' => 'required'
                ),
                array(
                        'field' => 'currency_symbols',
                        'label' => 'Country Symbols',
                        'rules' => 'required'
                ),
        );
        $this->form_validation->set_rules($config);
    }
    /**
     * @method : index()
     * @date : 2022-06-23
     * @about: This method use for records all states
     */
    public function index() {
        $this->data['countrys'] = $this->CountrysModel->fetch_all_country();
        $this->data['meta'] = array('meta_title' => 'Country Manage', 'meta_description' => '');
        $this->load->view('back-end/countrys/index-page', $this->data);
    }
    /**
     * @method : create()
     * @date : 2022-06-25
     * @about: This method use for create states
     */
    public function create() {
        $this->rules();
        if ($this->form_validation->run() == TRUE) {
            $data['country_name'] = $this->input->post('country_name');
            $data['country_icon'] = $this->input->post('country_icon');
            $data['country_code'] = $this->input->post('country_code');
            $data['country_iso_code'] = $this->input->post('country_iso_code');
            $data['country_currency_symbols'] = $this->input->post('currency_symbols');
            if ($this->CountrysModel->save($data)) {
                $this->session->set_flashdata('success', 'Country successfully created !');
                redirect('admin/countrys');
            } else {
                $this->session->set_flashdata('error', 'Oops something went wrong please try after some time!');
                redirect('admin/countrys/create');
            }
        }
        $this->data['meta'] = array('meta_title' => 'Country Create', 'meta_description' => '');
        $this->load->view('back-end/countrys/create-page', $this->data);
    }
    /**
     * @method : edit()
     * @date : 2022-06-25
     * @about: This method use for edit countrys
     *
     *
     */
    public function edit() {
        $this->data['meta'] = array('meta_title' => 'Country update', 'meta_description' => '');
        $country_id = $this->uri->segment(4);
        $this->data['country'] = $this->CountrysModel->fetch_country_by_id($country_id);
        $this->rules();
        if ($this->form_validation->run() == TRUE) {
            $data['country_name'] = $this->input->post('country_name');
            $data['country_icon'] = $this->input->post('country_icon');
            $data['country_code'] = $this->input->post('country_code');
            $data['country_iso_code'] = $this->input->post('country_iso_code');
            $data['country_currency_symbols'] = $this->input->post('currency_symbols');
            $this->CountrysModel->update(array('country_id' => $country_id), $data);
            $this->session->set_flashdata('success', 'Country successfully updated !');
            redirect('admin/countrys');
        }
        $this->load->view('back-end/countrys/create-edit', $this->data);
    }
    /**
     * @method : status()
     * @date : 2022-06-25
     * @about: This method use for status updated
     */
    public function status(){
	    $status['country_status']    = $this->input->post('status');
        $this->CountrysModel->update(array('country_id' => $this->input->post('country_id')), $status);
	}
}
