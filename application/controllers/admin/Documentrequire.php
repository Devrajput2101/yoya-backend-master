<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Documentrequire extends MY_AdminController {

	public function __construct() {
        parent::__construct(); 
        is_logged_out(); // if user is logout Or session is expired then redirect login

        $this->data['country'] = $this->CountrysModel->_dropdownlist();
        $this->data['states'] = $this->StateModel->_dropdownlist();
    }

    public function rules() {
        $config = array(
        	array(
        		'field' => 'document_label',
        		'label' => 'Document label',
        		'rules' => 'required'
        	),
			 array(
        		'field' => 'document_placeholder', 
        		'label' => 'Document Placeholder', 
        		'rules' => 'required|trim'
        	), array(
        		'field' => 'document_description',
        		'label' => 'Document Dsscription', 
        		'rules' => 'required|trim'
        	), array(
        		'field' => 'document_minimum_char', 
        		'label' => 'Document minimum char', 
        		'rules' => 'required|trim'
        	), array(
        		'field' => 'document_maximum_char', 
        		'label' => 'Document maximum char', 
        		'rules' => 'required|trim'
        	), array(
        		'field' => 'country_id', 
        		'label' => 'document country id', 
        		'rules' => 'required|trim'
        	), 
        );
        $this->form_validation->set_rules($config);
    }
    /**
     * @method : index()document_maximum_char
     * @date : 2022-09-24
     * @about: This method use for records all vehicle
     *
     *
     */
    public function index() {
        $this->data['documents'] = $this->DocumentsModel->fetch_all_documents();
        $this->load->view('back-end/systemconfig/index-page', $this->data);
    }

    public function create(){
        $this->rules();
		if ($this->form_validation->run() == TRUE){
		 	$data['document_country_id']         = $this->input->post('country_id');
			$data['document_label']           = $this->input->post('document_label');
			$data['document_placeholder']            = $this->input->post('document_placeholder');
            $data['document_description']         = $this->input->post('document_description');
			$data['document_minimum_char']         = $this->input->post('document_minimum_char');
			$data['document_maximum_char']         = $this->input->post('document_maximum_char');
			$data['document_country_id']         = $this->input->post('country_id');
			if($this->DocumentsModel->save($data)){
				$this->session->set_flashdata('success','Vahicle Fare successfully created !');
				redirect('admin/documentrequire');
			}else{
				$this->session->set_flashdata('error','Oops something went wrong please try after some time!');
				redirect('admin/documentrequire/create');
			}
		}
		$this->load->view('back-end/systemconfig/create-page',$this->data);
	}

    public function update(){
	    $document_id = $this->uri->segment(4);
		$this->data['documents'] = $this->DocumentsModel->single(array('document_id'=>$document_id));
		$this->rules();
		if ($this->form_validation->run() == TRUE){
		 	$data['document_country_id']         = $this->input->post('country_id');
			$data['document_label']           	 = $this->input->post('document_label');
			$data['document_placeholder']            = $this->input->post('document_placeholder');
            $data['document_description']         = $this->input->post('document_description');
			$data['document_minimum_char']         = $this->input->post('document_minimum_char');
			$data['document_maximum_char']         = $this->input->post('document_maximum_char');
			$data['document_country_id']         = $this->input->post('country_id');
			$this->DocumentsModel->update(array('document_id'=>$document_id),$data);
			$this->session->set_flashdata('success','vehiclefare details successfully updated !');
			redirect('admin/documentrequire');
		}
		$this->load->view('back-end/systemconfig/create-edit',$this->data);
	}

	public function remove() {
        if ($this->DocumentsModel->delete(array('document_id' => $this->uri->segment(4)))) {
            $this->session->set_flashdata('success', 'Package Fare successfully removed !');
            redirect('admin/documentrequire');
        } else {    
            $this->session->set_flashdata('error', 'Oops something went wrong please try after some time!');
            redirect('admin/documentrequire');
        }
    }

}