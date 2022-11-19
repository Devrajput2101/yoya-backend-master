<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Cancelation extends MY_AdminController {

    public function __construct() {
        parent::__construct();
        is_logged_out(); // if user is logout Or session is expired then redirect login
        $this->data['country'] = $this->CountrysModel->_dropdownlist();
        $this->data['states'] = $this->StateModel->_dropdownlist();
        $this->data['cities'] = $this->CitysModel->_dropdownslist();
        
    }
    /**
     * @method : rules()
     * @date : 2022-10-18
     * @about: This method use for set common rules of create and updated time in
     */
    public function rules() {
        $config = array(
        	array(
        		'field' => 'cancel_applied_user', 
        		'label' => 'Cancel User', 
        		'rules' => 'required|numeric|trim'
        	), array(
        		'field' => 'cancel_applied_driver',
        		'label' => 'Cancel Applied Driver', 
        		'rules' => 'required|numeric|trim'
        	), array(
        		'field' => 'cancel_applied_amount', 
        		'label' => 'Amount', 
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
        	),
        );
        $this->form_validation->set_rules($config);
    }
     /**
     * @method : index()
     * @date : 2022-10-18
     * @about: This method use for records all vehicle
     */
    public function index() {
        $this->data['cancel'] = $this->CancelationModel->fetch_all_cancelation();
		//dd($this->data['cancel']->result());
        $this->load->view('back-end/systemconfig/cancel-index', $this->data);
    }
    
    public function update(){
		$cancel = $this->uri->segment(4);
		$this->data['cancel'] = $this->CancelationModel->single(array('cancel_id'=>$cancel));
		$this->rules();
		if ($this->form_validation->run() == TRUE){
			$data['cancel_applied_user']       = $this->input->post('cancel_applied_user');
		    $data['cancel_applied_driver']     = $this->input->post('cancel_applied_driver');
		    $data['cancel_applied_amount']     = $this->input->post('cancel_applied_amount');
			$data['cancel_country_id']         = $this->input->post('country_id');
			$data['cancel_state_id']           = $this->input->post('state_id');
			$data['Cancel_city_id']            = $this->input->post('city_id');
			
            $this->CancelationModel->update(array('cancel_id'=>$cancel),$data);
			$this->session->set_flashdata('success','Cancelation successfully updated !');
			redirect('admin/cancelation');
            // dd($this->data['outstation']);
		}
		$this->load->view('back-end/systemconfig/cancel-edit',$this->data);
	}
	public function create(){
	    
        $this->rules();
		if ($this->form_validation->run() == TRUE){
		 	$data['cancel_applied_user']         = $this->input->post('cancel_applied_user');
			$data['cancel_applied_driver']           = $this->input->post('cancel_applied_driver');
			$data['cancel_applied_amount']            = $this->input->post('cancel_applied_amount');
			$data['cancel_country_id']         = $this->input->post('country_id');
			$data['cancel_state_id']           = $this->input->post('state_id');
			$data['Cancel_city_id']            = $this->input->post('city_id');
			
			if($this->CancelationModel->save($data)){
				$this->session->set_flashdata('success','Cancelation successfully created !');
				redirect('admin/cancelation');
			}else{
				$this->session->set_flashdata('error','Oops something went wrong please try after some time!');
				redirect('admin/cancelation/create');
			}
		}
		$this->data['meta'] = array('meta_title'=>'Transport Fare Create','meta_description'=>'');
		$this->load->view('back-end/systemconfig/cancel-create',$this->data);
	}
    public function remove() {
        if ($this->CancelationModel->delete(array('cancel_id' => $this->uri->segment(4)))) {
            $this->session->set_flashdata('success', 'Package Fare successfully removed !');
            redirect('admin/cancelation');
        } else {    	
            $this->session->set_flashdata('error', 'Oops something went wrong please try after some time!');
            redirect('admin/cancelation');
        }
    }
    
}
