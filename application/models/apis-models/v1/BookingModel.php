<?php defined('BASEPATH') OR exit('No direct script access allowed');
class BookingModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function save($data){
		try {
		    $this->db->set('booking_create_at',date('Y-m-d H:i:s'));
		    $this->db->set('booking_update_at',date('Y-m-d H:i:s'));
			$return = $this->db->insert($this->db->dbprefix('bookings'),$data);
			return $this->db->insert_id();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	
    public function update($where,$data){
		try {
		    $this->db->set('booking_update_at',date('Y-m-d H:i:s'));
			return $this->db->where($where)->update($this->db->dbprefix('bookings'),$data);
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	
	public function booking_status($status,$booking_id = null){
	    $booking_status = booking_status($status);
	    if(!empty($booking_id)){
	        $booking = $this->fetch_booking(array('booking_id'=>$booking_id));
	        $status  = $booking_status['status'];
	        $display_status  = $booking_status['display_status'];
	        $current_history  = array('status'=>$status,'date'=>date('Y-m-d H:i:s'),'display_status'=>$display_status,'remark'=>$booking_status['remark']);
	        
	        if(!empty($booking->booking_status_history)){
	            $history = (array)json_decode($booking->booking_status_history);
	            array_push($history,$current_history);
	        }
	    }else{
	        $status  = $booking_status['status'];
	        $display_status  = $booking_status['display_status'];
	        $history  = [array('status'=>$status,'date'=>date('Y-m-d H:i:s'),'display_status'=>$display_status,'remark'=>$booking_status['remark'])];
	    }
	    
	    return array('status'=>$status,'display_status'=>$display_status,'history'=>json_encode($history));
	}
	
	public function booking_id_ganrate(){
	    return time();
	}
	
	public function fetch_booking($where){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('bookings'));
			$this->db->where($where);
			$booking = $this->db->get();
			foreach($booking->result() as $key => $data){
			    $booking->result()[$key]->bookings_drops = $this->BookingDropModel->fetch_all_drops(array('drop_booking_id'=>$data->booking_id))->result();
			    $booking->result()[$key]->booking_amount_details = !empty($data->booking_amount_details) ? json_decode($data->booking_amount_details) : $data->booking_amount_details;
			}
			$booking = $booking->row();
			return $booking;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	
	public function check_location_distance_point($array){
        //Note: The provided distance is in Miles. If you need Kilometers, use 6371 instead of 3959.
        $latitude  = $array['booking_pickup_latitude'];
        $longitude = $array['booking_pickup_longitude'];
        $bookig_id = @$array['booking_id'];
        
        $this->db->select("*,(6371 * acos( cos( radians(".$latitude.") ) * cos( radians(booking_pickup_latitude ) ) * cos( radians(booking_pickup_longitude) - radians(".$longitude.")) + sin(radians(".$latitude.")) * sin( radians(booking_pickup_latitude)))) AS distance");
        $this->db->from($this->db->dbprefix('bookings'));
        if(!empty($bookig_id)){
            $this->db->where('booking_id',$bookig_id);
        }
        $this->db->having('distance >= 1');
        $result = $this->db->get();
        return $result;
    }
    
    
    public function fetch_all_booking($where){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('bookings'));
			$this->db->where($where);
			$this->db->order_by('booking_id','desc');
			$booking = $this->db->get();
			foreach($booking->result() as $key => $data){
			    $booking->result()[$key]->bookings_drops = $this->BookingDropModel->fetch_all_drops(array('drop_booking_id'=>$data->booking_id))->result();
			}
			return $booking;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	
	public function check_booking_stage($where,$where_in){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('bookings'));
			$this->db->where($where);
			$this->db->where_in($where_in);
			$booking = $this->db->get();
			return $booking;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
}