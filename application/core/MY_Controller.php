<?php defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->data['config']['app_mode'] = "production";
        //library
        $this->load->library('password');
        $this->load->library('base64fileuploads');
        //helper
        $this->load->helper('function');
        $this->load->helper('string');
        $this->load->helper('status');
        $this->load->helper('auth');
        // model
        $this->load->model('apis-models/v1/SettingModel');
        //setting or config
        $this->data['config'] = $this->SettingModel->fetch_setting_data();
    }

    public function _send_sms($mobile, $message, $tmpid = null, $unicode = null) {
        if(@$this->data['config']['geez_sms_is_active'] == 1){
            $token = @$this->data['config']['geez_api_token'];  
            //Your message to send, Add URL encoding here.

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.geezsms.com/api/v1/sms/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'token' => $token,
                    'phone' => $mobile,
                    'msg'   => $message
                ),
            ));
            $response = curl_exec($curl);

            curl_close($curl);
            return $response;

        }else if(@$this->data['config']['msg91_sms_is_active'] == 1){
            $authKey = @$this->data['config']['msg91_auth_key'];
            $senderId= @$this->data['config']['msg91_sender_id'];
            //Multiple mobiles numbers separated by comma
            $mobileNumber = $mobile;
            //Your message to send, Add URL encoding here.
            $message = urlencode($message);
            //Define route
            $route = "4";
            //Prepare you post parameters
            $postData = array('authkey' => $authKey, 'mobiles' => $mobileNumber, 'message' => $message, 'sender' => $senderId, 'route' => $route, 'DLT_TE_ID' => $tmpid);
            //API URL
            $url = "https://smsapi.thedigitalkranti.com/api/v1/sms/send";
            // init the resource
            $ch = curl_init();
            curl_setopt_array($ch, array(CURLOPT_URL => $url, CURLOPT_RETURNTRANSFER => true, CURLOPT_POST => true, CURLOPT_POSTFIELDS => $postData));
            //Ignore SSL certificate verification
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            //get response
            $response = curl_exec($ch);
            curl_close($ch);
            return $response;
        }
    }

    public function _googole_distance_api($pickuplat, $pickuplang, $destinationlat, $destinationlang) {
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . $pickuplat . "," . $pickuplang . "&destinations=" . $destinationlat . "," . $destinationlang . "&mode=walking&departure_time=now&avoid=indoor&language=en-US&key=" . $this->data['config']['google_key'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response, true);
        if (@$response_a['status'] != "OK") {
            return json_encode(array('status' => false, 'message' => @$response_a['error_message']));
            exit;
        }
        /*=================Calculate meter to kilo meeter ==================*/
        $destination_addresses = @$response_a['destination_addresses'][0];
        $origin_addresses = @$response_a['origin_addresses'][0];
        $distancetext = @$response_a['rows'][0]['elements'][0]['distance']['text'] != "" ? @$response_a['rows'][0]['elements'][0]['distance']['text'] : 0;
        $distancevalue = @$response_a['rows'][0]['elements'][0]['distance']['value'] != "" ? @$response_a['rows'][0]['elements'][0]['distance']['value'] : 0;
        $distancevalue = round((float)($distancevalue / 1000), 2);
        /*=================Calculate time second to minat ==================*/
        $durationetext = @$response_a['rows'][0]['elements'][0]['duration']['text'];
        $durationevalue = @$response_a['rows'][0]['elements'][0]['duration']['value'];
        $durationevalue = sprintf("%02.2d", floor($durationevalue / 60), $durationevalue % 60); //canvert second in minat
        return array('distance_value' => round($distancevalue, 2), 'distance_text' => $distancetext, 'time_text' => $durationetext, 'time_value' => $durationevalue, 'origin_addresses' => $origin_addresses, 'destination_addresses' => $destination_addresses);
    }
}
class MY_CronController extends MY_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('cron-models/RequestModel');
        $this->load->model('cron-models/DropModel');
        $this->load->model('cron-models/DriverModel');
        $this->load->model('cron-models/RequestLogModel');
        //check server ips 
        $whit_list_ip = array('38.242.252.59');
		$server_ip = $this->input->ip_address();
		if(!in_array($server_ip,$whit_list_ip)){
			log_message('error', 'Cron Access denied..... this ip address['.$server_ip.']');
			exit('Cron Access denied..... !');
		}
    }
}
class MY_ApiController extends MY_Controller {
    public function __construct() {
        parent::__construct();
        //model
        $this->load->model('apis-models/v1/UsersModel');
        $this->load->model('apis-models/v1/CustomerModel');
        $this->load->model('apis-models/v1/SmsModel');
        $this->load->model('apis-models/v1/DocumentModel');
        $this->load->model('apis-models/v1/CountryModel');
        $this->load->model('apis-models/v1/DriverModel');
        $this->load->model('apis-models/v1/VehicleTypeModel');
        $this->load->model('apis-models/v1/JobProcessModel');
        $this->load->model('apis-models/v1/DriverJobModel');
        $this->load->model('apis-models/v1/DriverVehicleModel');
        $this->load->model('apis-models/v1/RequiredDocumentModel');
        $this->load->model('apis-models/v1/VehicleModel');
        $this->load->model('apis-models/v1/CitiesModel');
        $this->load->model('apis-models/v1/PageModel');
        $this->load->model('apis-models/v1/RequestModel');
        $this->load->model('apis-models/v1/DropModel');
        $this->load->model('apis-models/v1/RequestLogModel');
        $this->load->model('apis-models/v1/BookingModel');
        $this->load->model('apis-models/v1/SearchModel');
        $this->load->model('apis-models/v1/DiscountModel');
        $this->load->model('apis-models/v1/TaxesModel');
        $this->load->model('apis-models/v1/WalletsModel');
        $this->load->model('apis-models/v1/BookingDropModel');
        $this->load->model('apis-models/v1/CancelreasonModel');
        $this->load->model('apis-models/v1/PackageModel');
        $this->load->model('apis-models/v1/ConversationsModel');
        $this->load->model('apis-models/v1/RentalModel');
        $this->load->model('apis-models/v1/RentalFareModel');
        $this->load->model('apis-models/v1/OutstationModel');
        $this->load->model('apis-models/v1/TransportModel');
        $this->load->model('apis-models/v1/BargainingModel');
    }
}

class MY_AdminController extends MY_Controller {
    public function __construct() {
        parent::__construct();
        //model
        $this->load->model('admin-models/LoginModel');
        $this->load->model('admin-models/UsersModel');
        $this->load->model('admin-models/CustomerModel');
        $this->load->model('admin-models/AvailableCurrencyModel');
        $this->load->model('admin-models/DocumentModel');
        $this->load->model('admin-models/AizuploadModel');
        $this->load->model('admin-models/VehicleTypeModel');
        $this->load->model('admin-models/JobprocessModel');
        $this->load->model('admin-models/JobprocessCitesModel');
        $this->load->model('admin-models/JobprocessVehicleModel');
        $this->load->model('admin-models/DriverModel');
        $this->load->model('admin-models/VehiclefareModel');
        $this->load->model('admin-models/VehicleModel');
        $this->load->model('admin-models/StateModel');
        $this->load->model('admin-models/CitysModel');
        $this->load->model('admin-models/CountrysModel');
        $this->load->model('admin-models/DiscountModel');
        $this->load->model('admin-models/RecentsearchModel');
        $this->load->model('admin-models/PageModel');
        $this->load->model('admin-models/BookingModel');
        $this->load->model('admin-models/RequiredDocumentModel');
        $this->load->model('admin-models/WalletModel');
        $this->load->model('admin-models/PackageFareModel');
        $this->load->model('admin-models/OutstationModel');
        $this->load->model('admin-models/DocumentsModel');
        $this->load->model('admin-models/RentalPakageModel');
        $this->load->model('admin-models/RentalFareModel');
	    $this->load->model('admin-models/TransportfareModel');
        $this->load->model('admin-models/CancelationModel');
        $this->load->model('admin-models/DashboardModel');
        $this->load->model('admin-models/ReasoncancelModel');
    }
}

class MY_HomeController extends MY_Controller {
    public function __construct() {
        parent::__construct();
    }
}
