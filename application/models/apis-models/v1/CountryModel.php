<?php defined('BASEPATH') OR exit('No direct script access allowed');

class CountryModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function fetch_all_country(){
		try {
			$this->db->select('country_id,country_name,country_icon,country_code,country_iso_code');
			$this->db->from($this->db->dbprefix('country'));
			$this->db->where('country_status','1');
			$this->db->order_by('country_name','asc');
			$return = $this->db->get();
			foreach($return->result() as $key => $data){
				$return->result()[$key]->country_icon = image_assets($data->country_icon); 
			}
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	
	public function _fetch_single($where = null){
		try {
			$this->db->select('country_id,country_name,country_icon,country_code,country_iso_code,country_currency_symbols');
			$this->db->from($this->db->dbprefix('country'));
			$this->db->where('country_status','1');
			if(!empty($where)){
				$this->db->where($where);
			}
			$this->db->limit(1);
			$return = $this->db->get();
			foreach($return->result() as $key => $data){
				$return->result()[$key]->country_icon = image_assets($data->country_icon); 
			}
			return $return->row();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
} 