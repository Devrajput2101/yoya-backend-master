<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Request extends MY_CronController {
      
	public function __construct() {
        parent::__construct(); 
    }
    
    public function cancel(){
        $request = $this->RequestModel->fetch_recently_request();
        foreach($request as $key => $data){
            $start_date  = new DateTime($data->request_update_at);
            $since_start = new DateTime(date('Y-m-d H:i:s'));
            $calculat_date = $start_date->diff($since_start);
            if(
                ($calculat_date->i >= 2 && $data->request_status == null && $data->request_mode  !='outstation') || 
                ($calculat_date->i >= 2 && $data->request_status == 1 && $data->request_mode  !='outstation')
            ){
                //|| $calculat_date->i >= 2 && $data->request_status == 2
                $request_data['request_status'] = 3; //for request is pendig or search
		        $this->RequestModel->update(array('request_id'=>$data->request_id),$request_data);
            }
        }
        
    }
}