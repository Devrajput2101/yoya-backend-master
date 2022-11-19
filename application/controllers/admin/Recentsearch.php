<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Recentsearch extends MY_AdminController {

	public function __construct() {
        parent::__construct(); 
        is_logged_out(); // if user is logout Or session is expired then redirect login
    }
    /**
	 * @method : index()
	 * @date : 2022-06-27
	 * @about: This method use for records all Order Request
	 * 
	 * */
	public function index(){
		$this->data['requestdata'] = $this->RecentsearchModel->fetch_all_order_request_records();
	//	echo "<pre>"; print_r($this->data['requestdata'] ->result());exit; echo "</pre>";
	
		$this->data['meta'] = array('meta_title'=>'Recentsearch Manage','meta_description'=>'');
		$this->load->view('back-end/recentsearch/index-page',$this->data);
	}
}