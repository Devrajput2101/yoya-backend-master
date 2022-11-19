<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends MY_AdminController {
      
	public function __construct() {
        parent::__construct(); 
        is_logged_out(); // if user is logout Or session is expired then redirect login
    }
    
    /**
	 * @method : index()
	 * @date : 2022-07-05
	 * @about: This method use for records all Booking
	 * 
	 * */
	public function index(){
		$this->data['bookings'] = $this->BookingModel->fetch_all_booking();
		$this->data['meta'] = array('meta_title'=>'Booking Manage','meta_description'=>'');
		$this->load->view('back-end/booking/index-page',$this->data);
	}

	public function complete(){
		$this->data['bookings'] = $this->BookingModel->fetch_all_complete_booking();
		// echo "<pre>"; print_r($this->data['bookings']->result());exit; echo "</pre>";
		$this->data['meta'] = array('meta_title'=>'Booking Manage','meta_description'=>'');
		$this->load->view('back-end/booking/completebooking',$this->data);
	}
	public function ongoing(){
		$this->data['bookings'] = $this->BookingModel->fetch_all_ongoing_booking();
		// echo "<pre>"; print_r($this->data['bookings']->result());exit; echo "</pre>";
		$this->data['meta'] = array('meta_title'=>'Booking Manage','meta_description'=>'');
		$this->load->view('back-end/booking/ongoingbooking',$this->data);
	}
	public function cancel(){
		$this->data['bookings'] = $this->BookingModel->fetch_all_cancel_booking();
		// echo "<pre>"; print_r($this->data['bookings']->result());exit; echo "</pre>";
		$this->data['meta'] = array('meta_title'=>'Booking Manage','meta_description'=>'');
		$this->load->view('back-end/booking/cancelbooking',$this->data);
	}
	/**
	 * @method : view()
	 * @date : 2022-07-05
	 * @about: This method use for view Booking
	 * 
	 * */
	 
	public function view(){
	 $booking_id = $this->uri->segment(4); 
	 $this->data['details'] = $this->BookingModel->single_booking_view($booking_id);
	 $this->data['meta'] = array('meta_title'=>'Booking Manage','meta_description'=>'');
	 $this->load->view('back-end/booking/view-page',$this->data);    
	 }
	 
	 /**
	 * @method : invoice()
	 * @date : 2022-07-05
	 * @about: This method use for invoice Booking
	 * 
	 * */
	 
	public function invoice(){
	 $booking_id = $this->uri->segment(4); 
	 $this->data['invoices'] = $this->BookingModel->get_book_invoice($booking_id);
	 $this->data['meta'] = array('meta_title'=>'Booking Manage','meta_description'=>'');
	 $this->load->view('back-end/booking/invoice-page',$this->data);    
	 }
	
}
