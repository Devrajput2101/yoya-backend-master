<?php defined('BASEPATH') OR exit('No direct script access allowed');
class DocumentsModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function save($data){
		try {
			$return = $this->db->insert($this->db->dbprefix('required_documents'),$data);
			return $this->db->insert_id();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
   public function update($where,$data){
		try {
			return $this->db->where($where)->update($this->db->dbprefix('required_documents'),$data);
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	public function delete($where){
		try {
			return $this->db->where($where)->delete($this->db->dbprefix('required_documents'));
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	public function fetch_all_documents(){
		try {
			$this->db->select($this->db->dbprefix('required_documents').'.*,'.$this->db->dbprefix('country').'.country_name');
			$this->db->from($this->db->dbprefix('required_documents'));
			$this->db->join($this->db->dbprefix('country'),$this->db->dbprefix('country').'.country_id ='.$this->db->dbprefix('required_documents').'.document_country_id','left');
			$this->db->order_by('document_id','desc');
			$return = $this->db->get();
			return $return;
		}catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	
	public function single($where){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('required_documents'));
			$this->db->order_by('document_id','desc');
			if(!empty($where)){
				$this->db->where($where);
			}
			$return = $this->db->get()->row();
			return $return;
		}catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

} 