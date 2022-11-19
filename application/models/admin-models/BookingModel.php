<?php defined('BASEPATH') OR exit('No direct script access allowed');
class BookingModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function save($data){
		try {
			$return = $this->db->insert($this->db->dbprefix('bookings'),$data);
			return $this->db->insert_id();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
   public function update($where,$data){
		try {
			return $this->db->where($where)->update($this->db->dbprefix('bookings'),$data);
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	
	public function fetch_all_booking(){
		try {
			$this->db->select($this->db->dbprefix('bookings').'.*,'.$this->db->dbprefix('vehicles').'.vehicle_name,'.$this->db->dbprefix('users').'.user_name,'.$this->db->dbprefix('job_process').'.job_process_name');
			$this->db->from($this->db->dbprefix('bookings'));
			$this->db->join($this->db->dbprefix('job_process'),$this->db->dbprefix('job_process').'.job_process_id ='.$this->db->dbprefix('bookings').'.booking_process_id','left');
			$this->db->join($this->db->dbprefix('users'),$this->db->dbprefix('users').'.user_id ='.$this->db->dbprefix('bookings').'.booking_user_id','left');
			$this->db->join($this->db->dbprefix('vehicles'),$this->db->dbprefix('vehicles').'.vehicle_id ='.$this->db->dbprefix('bookings').'.booking_vehicle_id','left');
			$this->db->order_by('booking_id','desc');

			$return = $this->db->get();
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	public function fetch_all_complete_booking(){
		try {
			$this->db->select($this->db->dbprefix('bookings').'.*,'.$this->db->dbprefix('vehicles').'.vehicle_name,'.$this->db->dbprefix('users').'.user_name,'.$this->db->dbprefix('job_process').'.job_process_name');
			$this->db->from($this->db->dbprefix('bookings'));
			$this->db->join($this->db->dbprefix('job_process'),$this->db->dbprefix('job_process').'.job_process_id ='.$this->db->dbprefix('bookings').'.booking_process_id','left');
			$this->db->join($this->db->dbprefix('users'),$this->db->dbprefix('users').'.user_id ='.$this->db->dbprefix('bookings').'.booking_user_id','left');
			$this->db->join($this->db->dbprefix('vehicles'),$this->db->dbprefix('vehicles').'.vehicle_id ='.$this->db->dbprefix('bookings').'.booking_vehicle_id','left');
			$this->db->order_by('booking_id','desc');
			$this->db->where_in('booking_status', ['booking_completed','booking_reached']);
			$return = $this->db->get();
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	public function fetch_all_ongoing_booking(){
		try {
			$this->db->select($this->db->dbprefix('bookings').'.*,'.$this->db->dbprefix('vehicles').'.vehicle_name,'.$this->db->dbprefix('users').'.user_name,'.$this->db->dbprefix('job_process').'.job_process_name');
			$this->db->from($this->db->dbprefix('bookings'));
			$this->db->join($this->db->dbprefix('job_process'),$this->db->dbprefix('job_process').'.job_process_id ='.$this->db->dbprefix('bookings').'.booking_process_id','left');
			$this->db->join($this->db->dbprefix('users'),$this->db->dbprefix('users').'.user_id ='.$this->db->dbprefix('bookings').'.booking_user_id','left');
			$this->db->join($this->db->dbprefix('vehicles'),$this->db->dbprefix('vehicles').'.vehicle_id ='.$this->db->dbprefix('bookings').'.booking_vehicle_id','left');
			$this->db->order_by('booking_id','desc');
			$this->db->where_in('booking_status', ['booking_accepted','booking_started']);
			$return = $this->db->get();
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_all_cancel_booking(){
		try {
			$this->db->select($this->db->dbprefix('bookings').'.*,'.$this->db->dbprefix('vehicles').'.vehicle_name,'.$this->db->dbprefix('users').'.user_name,'.$this->db->dbprefix('job_process').'.job_process_name');
			$this->db->from($this->db->dbprefix('bookings'));
			$this->db->join($this->db->dbprefix('job_process'),$this->db->dbprefix('job_process').'.job_process_id ='.$this->db->dbprefix('bookings').'.booking_process_id','left');
			$this->db->join($this->db->dbprefix('users'),$this->db->dbprefix('users').'.user_id ='.$this->db->dbprefix('bookings').'.booking_user_id','left');
			$this->db->join($this->db->dbprefix('vehicles'),$this->db->dbprefix('vehicles').'.vehicle_id ='.$this->db->dbprefix('bookings').'.booking_vehicle_id','left');
			$this->db->order_by('booking_id','desc');
			$this->db->where_in('booking_status', ['booking_cancel_by_customer','booking_cancel_by_driver','booking_cancel_by_admin']);
			$return = $this->db->get();
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	public function fetch_all_booking_where($where){
		try {
			$this->db->select($this->db->dbprefix('bookings').'.*,'.$this->db->dbprefix('vehicles').'.vehicle_name,'.$this->db->dbprefix('users').'.user_name');
			$this->db->from($this->db->dbprefix('bookings'));
			$this->db->join($this->db->dbprefix('users'),$this->db->dbprefix('users').'.user_id ='.$this->db->dbprefix('bookings').'.booking_user_id','left');
			$this->db->join($this->db->dbprefix('vehicles'),$this->db->dbprefix('vehicles').'.vehicle_id ='.$this->db->dbprefix('bookings').'.booking_vehicle_id','left');
			$this->db->where($where);
			$this->db->order_by('booking_id','desc');
			
			$return = $this->db->get();
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	
	public function single_booking_view($booking_id){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('bookings'));
			$this->db->where('booking_id',$booking_id);
			$checkuser = $this->db->get()->row();
			return $checkuser;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	
	public function get_book_invoice($booking_id){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('bookings'));
			$this->db->where('booking_id',$booking_id);
			$checkuser = $this->db->get()->row();
			return $checkuser;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
} 