<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Jobprocess extends MY_AdminController {
    public function __construct() {
        parent::__construct();
        is_logged_out(); // if user is logout Or session is expired then redirect login
        
    }
    public function rules() {
        $config = array(
        	array(
        		'field' => 'job_process_name',
        		'label' => 'Process Name',
        		'rules' => 'required'
        	), array(
        		'field' => 'job_process_screen', 
        		'label' => 'Process Screen', 
        		'rules' => 'required'
        	),
        );
        $this->form_validation->set_rules($config);
    }
    /**
     * @method : index()
     * @date : 2022-06-21
     * @about: This method use for records all Jobprocess
     */
    public function index() {
        $this->data['jobprocess'] = $this->JobprocessModel->fetch_all_jobprocess();
        $this->data['meta'] = array('meta_title' => 'Jobprocess Manage', 'meta_description' => '');
        $this->load->view('back-end/jobprocess/index-page', $this->data);
    }
    /**
     * @method : create()
     * @date : 2022-06-21
     * @about: This method use for create Jobprocess
     */
    public function create() {
        $this->rules();
        if ($this->form_validation->run() == TRUE) {
            $data['job_process_name']   = $this->input->post('job_process_name');
            $data['job_process_screen'] = $this->input->post('job_process_screen');
            $data['job_process_icon']   = $this->input->post('icon');
            $data['job_process_create_at'] = date('Y-m-d H:i:s');
            if ($this->JobprocessModel->save($data)) {
                $this->session->set_flashdata('success', 'Jobprocess successfully created !');
                redirect('admin/jobprocess');
            } else {
                $this->session->set_flashdata('error', 'Oops something went wrong please try after some time!');
                redirect('admin/jobprocess/create');
            }
        }
        $this->data['meta'] = array('meta_title' => 'Jobprocess Create', 'meta_description' => '');
        $this->load->view('back-end/jobprocess/create-page', $this->data);
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
        $this->data['process_data'] = $this->JobprocessModel->fetch_jobprocess_by_id($job_process_id);
        $this->rules();
        if ($this->form_validation->run() == TRUE) {
            $data['job_process_name'] = $this->input->post('job_process_name');
            $data['job_process_icon'] = $this->input->post('icon');
            $data['job_process_update_at'] = date('Y-m-d H:i:s');
            $data['job_process_screen'] = $this->input->post('job_process_screen');
            $this->JobprocessModel->update(array('job_process_id' => $job_process_id), $data);
            $this->session->set_flashdata('success', 'job process  details successfully updated !');
            redirect('admin/jobprocess');
        }
        $this->load->view('back-end/jobprocess/create-edit', $this->data);
    }
    /**
     * @method : Jobprocess status()
     * @date : 2022-06-08
     * @about: This method use for status change by ajax
     */
    public function jobprocessstatus() {
        $status['job_process_status'] = $this->input->post('status');
        $status['job_process_update_at'] = date('Y-m-d H:i:s');
        $this->JobprocessModel->update(array('job_process_id' => $this->input->post('job_process_id')), $status);
    }
}
