<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reasoncancel extends MY_AdminController {
      
	public function __construct() {
        parent::__construct(); 
        is_logged_out(); // if user is logout Or session is expired then redirect login
          
    }
     /**
     * @method : rules()
     * @date : 2022-10-14
     * @about: This method use for set common rules of create and updated time in
     */
    public function rules() {
        $reason = array(
        	array(
        		'field' => 'reason_for',
        		'label' => 'Reason',
        		'rules' => 'required|trim'
        	), array(
        		'field' => 'reason_content', 
        		'label' => 'Reason Content', 
        		'rules' => 'required|trim'
        	),
        );
        $this->form_validation->set_rules($reason);
    }
    /**
	 * @method : index()
	 * @date : 2022-07-05
	 * @about: This method use for records all Booking
	 * 
	 * */
	public function index(){
		$this->data['reasoncancels'] = $this->ReasoncancelModel->fetch_all_cancelation();
		$this->data['meta'] = array('meta_title'=>'Reason Cancel Manage','meta_description'=>'');
		$this->load->view('back-end/setting/index',$this->data);
	}
/**
	 * @method : edit()
	 * @date : 2022-06-23
	 * @about: This method use for edit vehicle 
	 * */
 	public function edit(){
		$this->data['meta'] = array('meta_title'=>'Reason Cancel Manage','meta_description'=>'');
		$reason_id = $this->uri->segment(4);
		$this->data['reasoncancels'] = $this->ReasoncancelModel->fetch_reasoncancel_by_id($reason_id);
        
        $this->rules();
		if ($this->form_validation->run() == TRUE){
			$data['reason_for'] = $this->input->post('reason_for');
            $data['reason_content'] = $this->input->post('reason_content');
			$this->ReasoncancelModel->update(array('reason_id'=>$reason_id),$data);
			$this->session->set_flashdata('success','Cancel Reason successfully updated !');
			redirect('admin/reasoncancel');
		}
	   
        
		$this->load->view('back-end/setting/create-edit', $this->data);
	}
	/**
     * @method : create()
     * @date : 2022-11-10
     * @about: This method use for create a new record or data 
     */
	public function create(){
		$this->rules();
        if ($this->form_validation->run() == TRUE) {
            $data['reason_for'] = $this->input->post('reason_for');
            $data['reason_content'] = $this->input->post('reason_content');
           			
            if ($this->ReasoncancelModel->save($data)) {
                $this->session->set_flashdata('success', 'Reason Cancel successfully created !');
                redirect('admin/reasoncancel');
            } else {
                $this->session->set_flashdata('error', 'Oops something went wrong please try after some time!');
                redirect('admin/reasoncancel/create');
            }
        }
        $this->load->view('back-end/setting/create-page', $this->data);
	}
	
   
    
}
