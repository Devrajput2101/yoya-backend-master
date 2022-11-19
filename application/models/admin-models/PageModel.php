<?php defined('BASEPATH') OR exit('No direct script access allowed');
class PageModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function save($data){
		try {
			$return = $this->db->insert($this->db->dbprefix('page'),$data);
			return $this->db->insert_id();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	public function update($where,$data){
		try {
			return $this->db->where($where)->update($this->db->dbprefix('page'),$data);
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	
	public function fetch_page_by_id($page_id){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('page'));
			$this->db->where('page_id',$page_id);
			$checkuser = $this->db->get()->row();
			return $checkuser;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_all_pages(){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('page'));
			$this->db->order_by('page_id','desc');
			$this->db->where('page_delete_at',1);
			$return = $this->db->get();
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

} 