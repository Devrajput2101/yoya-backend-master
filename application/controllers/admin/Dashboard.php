<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_AdminController {
	public function __construct() {
        parent::__construct(); 
        is_logged_out(); // if user is logout Or session is expired then redirect login
    }

	public function index(){
		$this->data['users'] = $this->DashboardModel->users_counts();
		$this->data['drivers'] = $this->DashboardModel->drivers_counts();
		$this->data['completeBookings'] = $this->DashboardModel->drivers_counts(['booking_completed']);
		$this->data['bookings'] = $this->DashboardModel->booking_counts();
		$this->data['cancelBookings'] = $this->DashboardModel->booking_counts(['booking_cancel_by_driver','booking_cancel_by_customer','booking_cancel_by_admin']);
		$this->data['ongoingBookings'] = $this->DashboardModel->booking_counts(['booking_accepted','booking_started','booking_reached']);
		$this->data['requests'] = $this->DashboardModel->requests_counts();
		$this->data['meta'] = array('meta_title'=>'Dashboard','meta_description'=>'');
		$this->load->view('back-end/dashboard',$this->data);
	}
}