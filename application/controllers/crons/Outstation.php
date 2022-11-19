<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Outstation extends MY_CronController {
      
	public function __construct() {
        parent::__construct(); 
    }
    
    public function request(){
        $request = $this->RequestModel->fetch_recently_request_outstation();
        foreach($request as $key => $data){
            $booking_date_from = $data->request_booking_date;
            if(tow_date_compare($booking_date_from) == 1 || tow_date_compare($booking_date_from) < 1){
                $this->under_radius_send_request($data->request_id);
            }
            log_message('error', 'out station cron working correctly !');
        }
    }
    /**
	 * @method : under_radius_send_request()
	 * @date : 2022-06-30
	 * @about: This method use for send request 
	 * */
	public function under_radius_send_request($request_id){
		$result = $this->RequestModel->fetch_single(array('request_id'=>$request_id));
		$pickup_latitude = $result->request_pickup_latitude;
		$pickup_longitude= $result->request_pickup_longitude;
       
		$drivers = $this->DriverModel->under_radius_driver($pickup_latitude,$pickup_longitude);
		$request_log   = array();
		$tokens   = array();
        
		foreach($drivers->result() as $key => $data){
	        array_push($tokens,$data->user_devoice_token);
	        array_push($request_log,array(
	        	'log_request_id'=>$request_id,
	        	'log_user_id'=>$data->user_id,
	        	'log_user_name'=>$data->user_name,
	        	'log_create_at'=>date("Y-m-d H:i:s"),
	        	'log_user_by'=>$result->request_user_id
	        ));
		}
		
		if(!empty($tokens)){
		    $this->load->library('pushnotification/pushnotification');
    	    $config['notification_serverkey'] = $this->data['config']['google_fcm_key'];
    	    
    	    $this->pushnotification->initialize($config);
    		$this->pushnotification->subject("New Ride Request Recived !");
    	    $this->pushnotification->message("New Ride Request Recived !");
			$this->pushnotification->data(
					array(
						"click_action"  =>"FLUTTER_NOTIFICATION_CLICK",
						"sound"         =>"default", 
						"screen" 		=>"",
						"data_id"		=>$request_id,
					));
    	    $this->pushnotification->sendMultiple($tokens);
		}
		if(!empty($request_log)){
		    $this->RequestLogModel->insert_batch($request_log);
		}
	}
}