<?php defined('BASEPATH') OR exit('No direct script access allowed');
class CitiesModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function find_cites_by_name($keywords){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('cities'));
			$this->db->like('city_name',$keywords);
			$this->db->where('city_status','1');
			$return = $this->db->get();
			foreach($return->result() as $key => $data){
				$return->result()[$key]->city_icon = image_assets($data->city_icon); 
			}
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_single($where = null){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('cities'));
			if(!empty($where)){
				$this->db->where($where);
			}
			$this->db->where('city_status','1');
			$return = $this->db->get();
			foreach($return->result() as $key => $data){
				$return->result()[$key]->city_icon = image_assets($data->city_icon); 
			}
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_all($where = null){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('cities'));
			if(!empty($where)){
				$this->db->where($where);
			}
			$this->db->where('city_status','1');
			$return = $this->db->get();
			foreach($return->result() as $key => $data){
				$return->result()[$key]->city_icon = image_assets($data->city_icon); 
			}
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_all_by_keyword($where = null,$keywords = null){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('cities'));
			if(!empty($where)){
				$this->db->where($where);
			}
			$this->db->where('city_status','1');
			if(!empty($keywords)){
				$this->db->like('city_name',$keywords);
			}
			$return = $this->db->get();
			foreach($return->result() as $key => $data){
				$return->result()[$key]->city_icon = image_assets($data->city_icon); 
			}
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
}