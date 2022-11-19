<?php defined('BASEPATH') OR exit('No direct script access allowed');
class DriverModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function save($data){
		try {
			$return = $this->db->insert($this->db->dbprefix('customers'),$data);
			return $this->db->insert_id();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_all_driver(){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('drivers'));
			$this->db->join($this->db->dbprefix('users'),$this->db->dbprefix('users').'.user_id ='.$this->db->dbprefix('drivers').'.driver_user_id','left');
			$this->db->where('user_type','driver');
			$this->db->order_by('user_id','desc');
			$return = $this->db->get();
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_single_driver($user_id){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('drivers'));
			$this->db->join($this->db->dbprefix('users'),$this->db->dbprefix('users').'.user_id ='.$this->db->dbprefix('drivers').'.driver_user_id','left');
			$this->db->where('driver_user_id',$user_id);
			$return = $this->db->get()->row();
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function booking_counts($user_id,$where_in = null){
        try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('bookings'));
			$this->db->where_in('booking_driver_id',$user_id);
            if($where_in != null){
                $this->db->where_in('booking_status',$where_in);
            }
			$count = $this->db->get()->num_rows();
            
			return $count;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
    }
} 