<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Jobprocesscites extends MY_AdminController {

    public function __construct() {
        parent::__construct();
        is_logged_out(); // if user is logout Or session is expired then redirect login
    }
    /**
     * @method : index()
     * @date : 2022-06-21
     * @about: This method use for records all Jobprocess
     *
     *
     */
    public function index() {
        $this->data['jobprocess'] = $this->JobprocessCitesModel->fetch_all();
        $this->data['meta'] = array('meta_title' => 'Jobprocess Manage', 'meta_description' => '');
        $this->load->view('back-end/jobprocesscites/index-page', $this->data);
    }
    /**
     * @method : create()
     * @date : 2022-06-21
     * @about: This method use for create Jobprocess
     */
    public function create() {
        $this->form_validation->set_rules('process_id', 'Job Process', 'required');
        $this->form_validation->set_rules('cities_id', 'City Name', 'required|is_unique['.$this->db->dbprefix('job_process_cities').'.cities_id]');
        if ($this->form_validation->run() == TRUE) {
            $data['job_process_id'] = $this->input->post('process_id');
            $data['cities_id'] = $this->input->post('cities_id');
            if ($this->JobprocessCitesModel->save($data)) {
                $this->session->set_flashdata('success', 'Jobprocess successfully marge !');
                redirect('admin/jobprocesscites');
            } else {
                $this->session->set_flashdata('error', 'Oops something went wrong please try after some time!');
                redirect('admin/jobprocesscites/create');
            }
        }

        $this->data['meta'] = array('meta_title' => 'Jobprocess Create', 'meta_description' => '');
        $this->data['cities'] = $this->CitysModel->_dropdownslist();
        $this->data['process'] = $this->JobprocessModel->_dropdownslist();
        $this->load->view('back-end/jobprocesscites/create-page', $this->data);
    }
    /**
     * @method : edit()
     * @date : 2022-06-21
     * @about: This method use for edit Jobprocess
     *
     *
     */
    public function edit() {
        $this->data['meta'] = array('meta_title' => 'Jobprocess update', 'meta_description' => '');
        $job_process_id = $this->uri->segment(4);
        $this->data['process_data'] = $this->JobprocessCitesModel->fetch_single(array('process_id'=>$job_process_id));
         $this->form_validation->set_rules('process_id', 'Job Process', 'required');
        if ($this->form_validation->run() == TRUE){
            $data['job_process_id'] = $this->input->post('process_id');
            if ($this->JobprocessCitesModel->update(array('process_id' =>$job_process_id), $data)) {
                $this->session->set_flashdata('success','Jobprocess successfully marge !');
                redirect('admin/jobprocesscites');
            } else {
                $this->session->set_flashdata('error', 'Oops something went wrong please try after some time!');
                redirect('admin/jobprocesscites/create');
            }
        }
        $this->data['cities'] = $this->CitysModel->_dropdownslist();
        $this->data['process'] = $this->JobprocessModel->_dropdownslist();
        $this->load->view('back-end/jobprocesscites/create-edit', $this->data);
    }
    /**
     * @method : Jobprocess status()
     * @date : 2022-06-08
     * @about: This method use for status change by ajax
     */
    public function status() {
        $status['job_process_status'] = $this->input->post('status');
        $this->JobprocessCitesModel->update(array('process_id' => $this->input->post('process_id')), $status);
    }
}
