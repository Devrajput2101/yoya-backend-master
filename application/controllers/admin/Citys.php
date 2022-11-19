<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Citys extends MY_AdminController {

	public function __construct() {
        parent::__construct(); 
        is_logged_out(); // if user is logout Or session is expired then redirect login
        $this->data['country'] = $this->CountrysModel->_dropdownlist();
		$this->data['states'] = $this->StateModel->_dropdownlist();
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
        		'field' => 'city_name',
        		'label' => 'City Name',
        		'rules' => 'required|trim'
        	), array(
        		'field' => 'country_id', 
        		'label' => 'Country', 
        		'rules' => 'required|numeric|trim'
        	), array(
        		'field' => 'state_id',
        		'label' => 'State', 
        		'rules' => 'required|numeric|trim'
        	), array(
        		'field' => 'city_icon',
        		'label' => 'Icon', 
        		'rules' => 'required|numeric|trim'
        	),
        );
        $this->form_validation->set_rules($config);
    }
    /**
	 * @method : index()
	 * @date : 2022-06-23
	 * @about: This method use for records all states
	 * 
	 * */
	public function index(){
		$this->data['citys'] = $this->CitysModel->fetch_all_city();
		$this->data['meta'] = array('meta_title'=>'citys Manage','meta_description'=>'');
		$this->load->view('back-end/citys/index-page',$this->data);
	}
	/**
	 * @method : create()
	 * @date : 2022-06-23
	 * @about: This method use for create states
	 * 
	 * */
	public function create(){
        $this->rules();
		if ($this->form_validation->run() == TRUE){
			$data['city_country_id']          = $this->input->post('country_id');
			$data['city_state_id']            = $this->input->post('state_id');
			$data['city_name']                = $this->input->post('city_name');
			$data['city_icon']                = $this->input->post('city_icon');
			
			if($this->CitysModel->save($data)){
				$this->session->set_flashdata('success','City successfully created !');
				redirect('admin/citys');
			}else{
				$this->session->set_flashdata('error','Oops something went wrong please try after some time!');
				redirect('admin/citys/create');
			}
		}
		$this->data['meta']    = array('meta_title'=>'City Create','meta_description'=>'');
		$this->load->view('back-end/citys/create-page',$this->data);
	}
	
	/**
	 * @method : edit()
	 * @date : 2022-06-23
	 * @about: This method use for edit citys 
	 * 
	 * */
	 
	public function edit(){
		$this->data['meta'] = array('meta_title'=>'State update','meta_description'=>'');
		$city_id = $this->uri->segment(4);
		$this->data['city'] = $this->CitysModel->fetch_city_by_id($city_id);
		
	    $this->rules();
		if ($this->form_validation->run() == TRUE){
			$data['city_country_id']          = $this->input->post('country_id');
			$data['city_state_id']            = $this->input->post('state_id');
			$data['city_name']                = $this->input->post('city_name');
			$data['city_icon']                = $this->input->post('city_icon');
			$this->CitysModel->update(array('city_id'=>$city_id),$data);
			$this->session->set_flashdata('success','City successfully updated !');
			redirect('admin/citys');
		}
		$this->load->view('back-end/citys/create-edit',$this->data);
	}
	/**
	 * @method : getCity()
	 * @date : 2022-06-23
	 * @about: This method use for get city by state id 
	 * 
	 * */
	// get city names
    function getCity() {
        $json = array();
        $StateID = $this->input->post('StateID');
        $json = $this->CitysModel->getCity($StateID);
        header('Content-Type: application/json');
        echo json_encode($json);
    }
	/**
     * @method : status()
     * @date : 2022-06-25
     * @about: This method use for status updated
     */
    public function status(){
	    $status['city_status']    = $this->input->post('status');
        $this->CitysModel->update(array('city_id' => $this->input->post('city_id')), $status);
	}
}