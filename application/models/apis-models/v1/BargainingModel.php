<?php defined('BASEPATH') OR exit('No direct script access allowed');

class BargainingModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

    public function save($data){
		try {
			$this->db->set('bargain_create_at',date('Y-m-d H:i:s'));
			$return = $this->db->insert($this->db->dbprefix('bargaining'),$data);
			return $this->db->insert_id();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function update($where,$data){
		try {
			$this->db->set('bargain_create_at',date('Y-m-d H:i:s'));
			return $this->db->where($where)->update($this->db->dbprefix('bargaining'),$data);
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_all($where){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('bargaining'));
			$this->db->where($where);
			$this->db->order_by('bargain_id','desc');
			$bargaining = $this->db->get();
			return $bargaining;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_single($where){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('bargaining'));
			$this->db->where($where);
			$bargaining = $this->db->get()->row();
			return $bargaining;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_for_with_where_all($where){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('bargaining'));
			$this->db->where($where);
			$this->db->order_by('bargain_id','desc');
			$this->db->group_by('bargain_user_id');
			$bargaining = $this->db->get();
			foreach($bargaining->result() as $key => $data){
				$bargaining->result()[$key]->bargain_user = $this->UsersModel->fetch_user_by_id($data->bargain_user_id);
			}
			return $bargaining;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_for_with_where_not_all($where,$not_in){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('bargaining'));
			$this->db->where_not_in('bargain_user_id',$not_in);
			$this->db->where($where);
			$this->db->order_by('bargain_id','desc');
			$this->db->group_by('bargain_user_id');
			$bargaining = $this->db->get();
			foreach($bargaining->result() as $key => $data){
				$bargaining->result()[$key]->bargain_user = $this->UsersModel->fetch_user_by_id($data->bargain_user_id);
			}
			return $bargaining;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
}	