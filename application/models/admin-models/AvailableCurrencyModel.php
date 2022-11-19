<?php defined('BASEPATH') OR exit('No direct script access allowed');
class AvailableCurrencyModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function update($where,$data){
		try {
			return $this->db->where($where)->update($this->db->dbprefix('available_currency'),$data);
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function save($data){
		try {
			return $this->db->insert($this->db->dbprefix('available_currency'),$data);
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function check_currency_exist($currency_id){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('available_currency'));
			$this->db->where('currency_currency_id',$currency_id);
			$checkuser = $this->db->get()->num_rows();
			if($checkuser > 0){
				return true;
			}
			return false;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_all_currency(){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('available_currency'));
			$this->db->order_by('currency_ranking');
			$checkuser = $this->db->get();
			$format = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);
		  	foreach($checkuser->result() as $key => $data) { 
		  		$checkuser->result()[$key]->currency_current_rate = $format->formatCurrency((float)$data->currency_current_rate, 'USD'); 
		  	}
			return $checkuser ;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_single_records($currency_id){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('available_currency'));
			$this->db->where('currency_id',$currency_id);
			$checkuser = $this->db->get()->row();
			return $checkuser;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
} 