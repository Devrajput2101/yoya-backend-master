<?php defined('BASEPATH') OR exit('No direct script access allowed');
class RequestLogModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function save($data){
		try {
			$this->db->set('log_create_at',date('Y-m-d H:i:s'));
			$return = $this->db->insert($this->db->dbprefix('order_request_logs'),$data);
			return $this->db->insert_id();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function insert_batch($data){
		try {
			return $this->db->insert_batch($this->db->dbprefix('order_request_logs'),$data);
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function update($where,$data){
		try {
			$this->db->set('log_create_at',date('Y-m-d H:i:s'));
			return $this->db->where($where)->update($this->db->dbprefix('order_request_logs'),$data);
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function is_exist($where){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('order_request_logs'));
			$this->db->where($where);
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

	public function fetch_single($where){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('order_request_logs'));
			$this->db->where($where);
			return $this->db->get()->row();

		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_request_log($where){
		try {
			$this->db->select($this->db->dbprefix('order_request').'.*');
			$this->db->from($this->db->dbprefix('order_request_logs'));
			$this->db->join($this->db->dbprefix('order_request'),$this->db->dbprefix('order_request').'.request_id ='.$this->db->dbprefix('order_request_logs').'.log_request_id','left');
			$this->db->where($where);
			$this->db->where_in('request_status',array('1','2'));
			$this->db->order_by('request_id','desc');
			$this->db->limit(1);
			$return = $this->db->get();
			foreach($return->result() as $key => $data){
				$return->result()[$key]->request_drop_locations = $this->DropModel->fetch_drop_point(array('drop_request_id'=>$data->request_id))->result();
			}
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
}