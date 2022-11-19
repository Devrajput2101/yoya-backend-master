<?php defined('BASEPATH') OR exit('No direct script access allowed');
class RequiredDocumentModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function fetch_all($where){
		try {
			$this->db->select('document_id,document_label,document_minimum_char,document_maximum_char,document_placeholder,document_description,document_front_image,document_back_image,country_name');
			$this->db->from($this->db->dbprefix('required_documents'));
			$this->db->join($this->db->dbprefix('country'),$this->db->dbprefix('country').'.country_id ='.$this->db->dbprefix('required_documents').'.document_country_id','left');
			$this->db->where('document_status','1');
			$this->db->where($where);
			$this->db->order_by('document_label','asc');
			$return = $this->db->get();
			foreach($return->result() as $key => $data){
    			$return->result()[$key]->document_placeholder = image_assets($data->document_placeholder);
    		}
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_single($where){
		try {
			$this->db->select('document_id,document_label,document_minimum_char,document_maximum_char,document_placeholder,document_description,document_front_image,document_back_image,country_name');
			$this->db->from($this->db->dbprefix('required_documents'));
			$this->db->join($this->db->dbprefix('country'),$this->db->dbprefix('country').'.country_id ='.$this->db->dbprefix('required_documents').'.document_country_id','left');
			$this->db->where('document_status','1');
			$this->db->where($where);
			$this->db->order_by('document_label','asc');
			$return = $this->db->get();
			foreach($return->result() as $key => $data){
    			$return->result()[$key]->document_placeholder = image_assets($data->document_placeholder);
    		}
			return $return->row();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
}