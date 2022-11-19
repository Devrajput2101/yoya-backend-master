<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Cashfree Payment Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Cashfree
 * @author		K.K ADIL KHAN AJAD
 */
 
class Cashfree {
	/**
     * app_mode 
     * @param   string   $app_mode
     * @about   This variabl user for set app mode
     */
	public $app_mode       = 'testing';
	/**
     * app_id 
     * @param   string   $app_id
     * @about   This variabl user for set app id
     */
	public $app_id     = '';
	/**
     * app_secret 
     * @param   string   $app_secret
     * @about   This variabl user for set app secret
     */
	public $app_secret = '';
	/**
     * live_url 
     * @param   string   $live_url
     * @about   This variabl user for set Live getaway url 
     */
	public $live_url   = 'https://api.cashfree.com/api/';
	/**
     * test_url 
     * @param   string   $test_url
     * @about   This variabl user for set getaway Test url 
     */
	public $test_url   = 'https://test.cashfree.com/api/';
	/**
     * payout_url 
     * @param   string   $payout_url
     * @about   This variabl user for set payaout url
     */
	public $payout_url = 'https://payout-api.cashfree.com/payout/';
	/**
     * Constructor
     * 
     * @param   array   $config
     * @return  void
     */
	public function __construct($config = array()){
		empty($config) OR $this->initialize($config, FALSE);

		$this->_CI =& get_instance();

		log_message('info', 'Casfree Class Initialized');
	}
	/**
	 * Initialize preferences
	 *
	 * @param	array	$config
	 * @param	bool	$reset
	 * @return	CI_Cashfree
	 */
	public function initialize(array $config = array(), $reset = TRUE){
		$reflection = new ReflectionClass($this);
        
		$defaults = $reflection->getDefaultProperties();
		foreach (array_keys($defaults) as $key){
			if ($key[0] === '_'){
				continue;
			}

			if (isset($config[$key])){
				$this->$key = $config[$key];
			}else{
				$this->$key = $defaults[$key];
			}
		}
		return $this;
	}
	/*
    *@ganrate token
    *@Auth Token
    */
    public function _token(){
        //check token url is empty
        if(empty($this->payout_url)){
            $this->api_return(array('status' =>false,'message' => 'Cashfree token url empty !'));exit;
        }
        
        $url = $this->payout_url.'v1/authorize';
        $headers = array(
            'X-Client-Id: '.$this->app_id,
            'X-Client-Secret: '.$this->app_secret, 
            'Content-Type: application/json',
        );
        
        $data = array();
        $ch   = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); 
        $ex = curl_exec($ch);
        curl_close($ch);
        $robj = json_decode($ex, true);
        if(@$robj['subCode'] == 200 && @$robj['status'] == 'SUCCESS'){
            return @$robj['data']['token'];
        }
    }
    
    public function _create_order($data){
    
        $token  = $this->_token();
        if($this->app_mode != 'testing'){
            $urls   = $this->live_url."v2/cftoken/order";
        }else{
            $urls   = $this->test_url."v2/cftoken/order";
        }
        
        $header = array(
            'X-Client-Id: '.$this->app_id,
            'X-Client-Secret: '.$this->app_secret, 
            'Content-Type: application/json',
            'Authorization: Bearer '.$token
        );
        
        $orders['orderId']         = $data['order_id'];
        $orders['orderAmount']     = $data['amount'];
        $orders['orderCurrency']   = 'INR';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $urls);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($orders)); 
        $ex = curl_exec($ch);
        curl_close($ch);
        $robj = json_decode($ex, true);
        
        return $robj;
    }
    
    /*
     * Public Response Function
    */
    public function api_return($data = NULL) {
        ob_start();
        header('content-type:application/json; charset=UTF-8');
        print_r(json_encode($data));
        ob_end_flush();
    }
}
