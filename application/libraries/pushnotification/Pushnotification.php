<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2022, British Columbia Institute of Technology
 *
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Cashfree Payment Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	FCM
 * @author		K.K ADIL KHAN AJAD
 */
 
class Pushnotification {
	/**
	 * Constructor
	 *
	 * @param	array	$config
	 * @return	void
	 */
	public $notification_title   = 'Hello ! Testing By Adil Khan Ajad';
	 /**
     *  to set the image
     *
     * @param string $notification_image  The image of the push image
    */
	public $notification_image   = '';
	/**
     *  to set the icon
     *
     * @param string $notification_icon  The icon of the push icon
    */
	public $notification_icon    = '';
	/**
     *  to set the message
     *
     * @param string $notification_message  The message of the push message
    */
	public $notification_message = '';
	 /**
     *  to set the custom data 
     *
     * @param string $notification_data  The message of the push data
    */
	public $notification_data    = array();
	 /**
     *  to set the custom data 
     *
     * @param string $notification_serverkey  The message of the push authenticate
    */
	public $notification_serverkey = '';
	
	/**
     *  to set the custom priority 
     *  high
     * @param string $notification_priority  The priority of the push notifiction
    */
	public $notification_priority = 'high';
	
	
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
	
	/**
     * Function to set the title
     *
     * @param string    $notification_image The title of the push subject
    */
    
    public function subject($title){
        $this->notification_title = $title;
    }
    /**
     * Function to set the image
     *
     * @param string $notification_image  The message of the push image
    */
    public function image($url){
        $this->notification_image = $url;
    }
    
    /**
     * Function to set the icon
     *
     * @param string $notification_icon  The message of the push icon
    */
    public function icon($icon){
        $this->notification_icon = $icon;
    }
    
    /**
     * Function to set the message
     *
     * @param string $notification_message  The message of the push message
    */
    public function message($icon){
        $this->notification_message = $icon;
    }
    
    /**
     * Function to set the custom data 
     *
     * @param string $notification_data  The message of the push data
    */
    public function data($data){
        $this->notification_data = $data;
    }
     /**
     * Function to set the priority
     *
     * @param string $notification_message  The priority of the push priority
    */
    public function priority($priority){
        $this->notification_message = $priority;
    }
    /**
     * Generating the push message array
     *
     * @return array  array of the push notification data to be send
     */
    public function fcmcontent(){
        $content = array();
        if(!empty($this->notification_title)){
            $content['data']['title']   = $this->notification_title;
        }
        
        if(!empty($this->notification_message)){
            $content['data']['message'] = $this->notification_message;
        }
        
        if(!empty($this->notification_image)){
            $content['data']['image']   = $this->notification_image;
        }
        
        if(!empty($this->notification_data)){
            $content['data']['payload'] = $this->notification_data;
        }
        
        $content['data']['timestamp'] = date('Y-m-d G:i:s');
        return $content;
    }
    
    /**
     * Function to send notification to a single device
     *
     * @param   string   $to     registration id of device (device token)
     * @param   array   $message    push notification array returned from fcmcontent()
     *
     * @return  array   array of notification data and to address
     */
    public function send($to){
        $fields = array(
            'to' => $to,
            'data' => $this->fcmcontent()['data'],
            'priority'     => $this->notification_priority
        );
        return $this->CurlNotification($fields);
    }
    /**
     * Function to send notification to multiple users by firebase registration ids
     *
     * @param   array   $to         array of registration ids of devices (device tokens)
     * @param   array   $message    push notification array returned from getPush()
     * 
     * @return  array   array of notification data and to addresses
     */
    public function sendMultiple($registration_ids)
    {   
        
        
        $fields = array(
            'registration_ids' => $registration_ids,
            'data' => $this->fcmcontent()['data'],
            'priority'     => $this->notification_priority
        );
        return $this->CurlNotification($fields);
    }
    /**
     * Function makes curl request to firebase servers
     *
     * @param   array   $fields    array of registration ids of devices (device tokens)
     * 
     * @return  string   returns result from FCM server as json
     */
    private function CurlNotification($fields){
        $headers = array(
            'Authorization: key='.$this->notification_serverkey,
            'Content-Type: application/json',
        );
        // Open connection
        $ch = curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/fcm/send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // Execute post
        $result = curl_exec($ch);
        if ($result === false) {
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);

        return $result;
    }
    public function api_return($data = NULL) {
        ob_start();
        header('content-type:application/json; charset=UTF-8');
        print_r(json_encode($data));
        ob_end_flush();
    }
}
