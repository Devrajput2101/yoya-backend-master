<?php defined('BASEPATH') OR exit('No direct script access allowed');
class DashboardModel extends CI_Model {

    function __construct(){
		parent::__construct();
	}

    public function users_counts(){
        try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('users'));
			$this->db->where('user_type','customer');
			$count = $this->db->get()->num_rows();
			return $count;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
    }

    public function drivers_counts(){
        try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('users'));
			$this->db->where('user_type','customer');
			$count = $this->db->get()->num_rows();
			return $count;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
    }

    public function booking_counts($where = null){
        try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('bookings'));
            if($where != null){
                $this->db->where_in('booking_status',$where);
            }
			$count = $this->db->get()->num_rows();
            
			return $count;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
    }

    public function requests_counts($where = null){
        try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('order_request'));
            if($where != null){
                $this->db->where_in('request_status',$where);
            }
			$count = $this->db->get()->num_rows();
            
			return $count;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
    }
}