<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends MY_AdminController {
	public function __construct() {
        parent::__construct(); 
        is_logged_out(); // if user is logout Or session is expired then redirect login
    }
    /**
	 * @method : index()
	 * @date : 2022-06-10
	 * @about: This method use for records all pages
	 * 
	 * */
	public function index(){
	    
		$this->data['pages'] = $this->PageModel->fetch_all_pages();
		$this->data['meta'] = array('meta_title'=>'Pages','meta_description'=>'');
		$this->load->view('back-end/pages/index-page',$this->data);
	}
		public function create(){
		  
		$this->form_validation->set_rules('page_type', 'Page Type', 'required');  
		$this->form_validation->set_rules('page_title', 'Page title', 'required');
		$this->form_validation->set_rules('page_description', 'Description','required');
		if ($this->form_validation->run() == TRUE){
			
			$data['page_type']           = $this->input->post('page_type');
			$data['page_title']          = $this->input->post('page_title');
			$data['page_description']    = $this->input->post('page_description');
			$data['page_image']          = $this->input->post('icon');
			$data['page_create_at']      = date('Y-m-d H:i:s');
			
			if($this->PageModel->save($data)){
				$this->session->set_flashdata('success','Page successfully created !');
				redirect('admin/page');
			}else{
				$this->session->set_flashdata('error','Oops something went wrong please try after some time!');
				redirect('admin/page/create');
			}
		}
		$this->data['meta'] = array('meta_title'=>'Pages Create','meta_description'=>'');
		$this->load->view('back-end/pages/create-page',$this->data);
	}
	
	/**
	 * @method : edit()
	 * @date : 2022-06-10
	 * @about: This method use for edit page
	 * 
	 * */
	public function edit(){
		$this->data['meta'] = array('meta_title'=>'Pages update','meta_description'=>'');
		
		$page_id = $this->uri->segment(4);
		$this->data['user_data'] = $this->PageModel->fetch_page_by_id($page_id);
		
		$this->form_validation->set_rules('page_type', 'Page Type', 'required');
	    $this->form_validation->set_rules('page_title', 'Page title', 'required');
		$this->form_validation->set_rules('page_description', 'Description','required');
		if ($this->form_validation->run() == TRUE){
		    
			$data['page_type']           = $this->input->post('page_type');
			$data['page_title']          = $this->input->post('page_title');
			$data['page_description']    = $this->input->post('page_description');
			$data['page_update_at']      = date('Y-m-d H:i:s');
			
			$this->PageModel->update(array('page_id'=>$page_id),$data);
			$this->session->set_flashdata('success','Page details successfully updated !');
			redirect('admin/page');
		}

		$this->load->view('back-end/pages/create-edit',$this->data);
	}
	
	public function page_delete(){
	    $status['page_delete_at']    = $this->input->post('status');
        $status['page_update_at'] = date('Y-m-d H:i:s');
        $this->PageModel->update(array('page_id'=>$this->input->post('page_id')),$status);
	}
}