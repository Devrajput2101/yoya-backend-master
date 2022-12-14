<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Authorization_token
 * -------------------------------------
 * API Token Generate/Validation
 *
 * @author: K.K Adil Khan Azad
 * @Email : yahoodemo@gmail.com
 * @version         1.1.7
 * @Lastupdate: 20:04:2020
 * CodeIgniter API Controller
 *
 * @package         CodeIgniter
 * @subpackage      Libraries
 * @category        Libraries
 * @license         MIT
 * @version         1.1.7
 */
/*CI_Controller old */
class API_Controller extends MY_ApiController {
    /**
     * List of allowed HTTP methods
     *
     * @var array
     */
    protected $allowed_http_methods = ['get', 'delete', 'post', 'put', 'options', 'patch', 'head'];
    
    const HTTP_METHOD_NOT_ALLOWED = 405;
    /**
     * The request cannot be fulfilled due to multiple errors
     */
    const HTTP_BAD_REQUEST = 400;
    /**
     * Request Timeout
     */
    const HTTP_REQUEST_TIMEOUT = 408;
    /**
     * The requested resource could not be found
     */
    const HTTP_NOT_FOUND = 404;
    /**
     * The user is unauthorized to access the requested resource
     */
    const HTTP_UNAUTHORIZED = 401;
    /**
     * The request has succeeded
     */
    const HTTP_OK = 200;

    /**
     * The 500 internal server error 
     */
    const HTTP_SERVER_ERROR = 500;
    /**
     * HTTP status codes and their respective description
     */
    const HEADER_STATUS_STRINGS = ['405' => 'HTTP/1.1 405 Method Not Allowed', '400' => 'BAD REQUEST', '408' => 'Request Timeout', '404' => 'NOT FOUND', '401' => 'UNAUTHORIZED', '200' => 'OK','500'=>"Internal server error"];
    /**
     * API LIMIT TABLE NAME
     */
    protected $API_LIMIT_TABLE_NAME;
    /**
     * API KEYS TABLE NAME
     */
    protected $API_KEYS_TABLE_NAME;
    /**
     * RETURN DATA
     */
    protected $return_other_data = [];
    public function __construct() {
        parent::__construct();
        $this->CI = & get_instance();
        // load rest-api config file
        $this->load->config('rest-api');
        // set timezone for api limit
        date_default_timezone_set($this->config->item('api_timezone'));
        // Load Config Items Values
        $this->API_LIMIT_TABLE_NAME = $this->config->item('api_limit_table_name');
        $this->API_KEYS_TABLE_NAME = $this->config->item('api_keys_table_name');
    }
    public function _APIConfig($config = []) {
        // return other data
        if (isset($config['data'])) $this->return_other_data = $config['data'];
        // by default method `GET`
        if ((isset($config) AND empty($config)) OR empty($config['methods'])) {
            $this->_allow_methods(['GET']);
        } else {
            $this->_allow_methods($config['methods']);
        }
        // api limit function `_limit_method()`
        if (isset($config['limit'])) $this->_limit_method($config['limit']);
        // api key function `_api_key()`
        if (isset($config['key'])) $this->_api_key($config['key']);
        // IF Require Authentication
        if (isset($config['requireAuthorization']) AND $config['requireAuthorization'] === true) {
            $token_data = $this->_isAuthorized();
            // remove api time in user token data
            unset($token_data->API_TIME);
            // return token decode data
            return ['token_data' => (array)$token_data];
        }
    }
    
    /**
     * Allow Methods
     * -------------------------------------
     * @param: {array} request methods
     */
    public function _allow_methods(array $methods) {
        $REQUEST_METHOD = $this->input->server('REQUEST_METHOD', TRUE);
        // check request method in `$allowed_http_methods` array()
        if (in_array(strtolower($REQUEST_METHOD), $this->allowed_http_methods)) {
            // check request method in user define `$methods` array()
            if (in_array(strtolower($REQUEST_METHOD), $methods) OR in_array(strtoupper($REQUEST_METHOD), $methods)) {
                // allow request method
                return true;
            } else {
                // not allow request method
                $this->_response(['status' => FALSE, 'message' => 'Unknown method'], self::HTTP_METHOD_NOT_ALLOWED);
            }
        } else {
            $this->_response(['status' => FALSE, 'message' => 'Unknown method'], self::HTTP_METHOD_NOT_ALLOWED);
        }
    }
    /**
     * Limit Method
     * ------------------------
     * @param: {int} number
     * @param: {type} ip
     *
     * Total Number Limit without Time
     *
     * @param: {minute} time/everyday
     * Total Number Limit with Last {3,4,5...} minute
     * --------------------------------------------------------
     */
    public function _limit_method(array $data) {
        // check limit number
        if (!isset($data[0])) {
            $this->_response(['status' => FALSE, 'message' => 'Limit Number Required'], self::HTTP_BAD_REQUEST);
        }
        // check limit type
        if (!isset($data[1])) {
            $this->_response(['status' => FALSE, 'message' => 'Limit Type Required'], self::HTTP_BAD_REQUEST);
        }
        if (!isset($this->db)) {
            $this->_response(['status' => FALSE, 'message' => 'Load CodeIgniter Database Library'], self::HTTP_BAD_REQUEST);
        }
        // check limit database table exists
        if (!$this->db->table_exists($this->API_LIMIT_TABLE_NAME)) {
            $this->_response(['status' => FALSE, 'message' => 'Create API Limit Database Table'], self::HTTP_BAD_REQUEST);
        }
        $limit_num = $data[0]; // limit number
        $limit_type = $data[1]; // limit type
        $limit_time = isset($data[2]) ? $data[2] : ''; // time minute
        if ($limit_type == 'ip') {
            $where_data_ip = ['uri' => $this->uri->uri_string(), 'class' => $this->router->fetch_class(), 'method' => $this->router->fetch_method(), 'ip_address' => $this->input->ip_address(), ];
            $limit_query = $this->db->get_where($this->API_LIMIT_TABLE_NAME, $where_data_ip);
            if ($this->db->affected_rows() >= $limit_num) {
                // time limit not empty
                if (isset($limit_time) AND !empty($limit_time)) {
                    // if time limit `numeric` numbers
                    if (is_numeric($limit_time)) {
                        $limit_timestamp = time() - ($limit_time * 60);
                        // echo Date('d/m/Y h:i A', $times);
                        $where_data_ip_with_time = ['uri' => $this->uri->uri_string(), 'class' => $this->router->fetch_class(), 'method' => $this->router->$this->router->fetch_method(), 'ip_address' => $this->input->ip_address(), 'time >=' => $limit_timestamp];
                        $time_limit_query = $this->db->get_where($this->API_LIMIT_TABLE_NAME, $where_data_ip_with_time);
                        // echo $this->db->last_query();
                        if ($this->db->affected_rows() >= $limit_num) {
                            $this->_response(['status' => FALSE, 'message' => 'This IP Address has reached the time limit for this method'], self::HTTP_REQUEST_TIMEOUT);
                        } else {
                            // insert limit data
                            $this->limit_data_insert();
                        }
                    }
                    // if time limit equal to `everyday`
                    if ($limit_time == 'everyday') {
                        $this->load->helper('date');
                        $bad_date = mdate('%d-%m-%Y', time());
                        $start_date = nice_date($bad_date . ' 12:00 AM', 'd-m-Y h:i A'); // {DATE} 12:00 AM
                        $end_date = nice_date($bad_date . ' 12:00 PM', 'd-m-Y h:i A'); // {DATE} 12:00 PM
                        $start_date_timestamp = strtotime($start_date);
                        $end_date_timestamp = strtotime($end_date);
                        $where_data_ip_with_time = ['uri' => $this->uri->uri_string(), 'class' => $this->router->fetch_class(), 'method' => $this->router->fetch_method(), 'ip_address' => $this->input->ip_address(), 'time >=' => $start_date_timestamp, 'time <=' => $end_date_timestamp, ];
                        $time_limit_query = $this->db->get_where($this->API_LIMIT_TABLE_NAME, $where_data_ip_with_time);
                        // echo $this->db->last_query();exit;
                        if ($this->db->affected_rows() >= $limit_num) {
                            $this->_response(['status' => FALSE, 'message' => 'This IP Address has reached the time limit for this method'], self::HTTP_REQUEST_TIMEOUT);
                        } else {
                            // insert limit data
                            $this->limit_data_insert();
                        }
                    }
                } else {
                    $this->_response(['status' => FALSE, 'message' => 'This IP Address has reached limit for this method'], self::HTTP_REQUEST_TIMEOUT);
                }
            } else {
                // insert limit data
                $this->limit_data_insert();
            }
        } else {
            $this->_response(['status' => FALSE, 'message' => 'Limit Type Invalid'], self::HTTP_BAD_REQUEST);
        }
    }
    /**
     * Limit Data Insert
     */
    private function limit_data_insert() {
        $this->load->helper('api_helper');
        $insert_data = ['uri' => $this->uri->uri_string(), 'class' => $this->router->fetch_class(), 'method' => $this->router->fetch_method(), 'ip_address' => $this->input->ip_address(), 'time' => time(), ];
        insert($this->API_LIMIT_TABLE_NAME, $insert_data);
    }
    /**
     * API key
     */
    private function _api_key(array $key) {
        if (!isset($key[0])) {
            $api_key_type = 'header';
        } else {
            $api_key_type = $key[0];
        }
        if (!isset($key[1])) {
            $api_key = 'table';
        } else {
            $api_key = $key[1];
        }
        // api key type `Header`
        if (strtolower($api_key_type) == 'header') {
            $api_key_header_name = $this->config->item('api_key_header_name');
            // check api key header name in request headers
            $is_header = $this->exists_header($api_key_header_name); // return status and header value
            if (isset($is_header['status']) === TRUE) {
                $HEADER_VALUE = trim($is_header['value']);
                // if api key equal to `table`
                if ($api_key != "table") {
                    if ($HEADER_VALUE != $api_key) {
                        $this->_response(['status' => FALSE, 'message' => 'API Key Invalid'], self::HTTP_UNAUTHORIZED);
                    }
                } else {
                    if (!isset($this->db)) {
                        $this->_response(['status' => FALSE, 'message' => 'Load CodeIgniter Database Library'], self::HTTP_BAD_REQUEST);
                    }
                    // check api key database table exists
                    if (!$this->db->table_exists($this->API_KEYS_TABLE_NAME)) {
                        $this->_response(['status' => FALSE, 'message' => 'Create API Key Database Table'], self::HTTP_BAD_REQUEST);
                    }
                    $where_key_data = ['access_controller' => $this->router->fetch_class(), 'access_api_key' => $HEADER_VALUE, ];
                    $limit_query = $this->db->get_where($this->API_KEYS_TABLE_NAME, $where_key_data);
                    if (!$this->db->affected_rows() > 0) {
                        $this->_response(['status' => FALSE, 'message' => 'API Key Invalid'], self::HTTP_NOT_FOUND);
                    }
                }
            } else {
                $this->_response(['status' => FALSE, 'message' => 'Set API Key in Request Header'], self::HTTP_NOT_FOUND);
            }
        } else if (strtolower($api_key_type) == 'get') // // api key type `get`
        {
            // return status and header value `Content-Type`
            $is_header = $this->exists_header('Content-Type');
            if (isset($is_header['status']) === TRUE) {
                if ($is_header['value'] === "application/json") {
                    $stream_clean = $this->security->xss_clean($this->input->raw_input_stream);
                    $_GET = json_decode($stream_clean, true);
                }
            }
            $api_key_get_name = $this->config->item('api_key_get_name');
            $get_param_value = $this->input->get($api_key_get_name, TRUE);
            if (!empty($get_param_value) AND is_string($get_param_value)) {
                // if api key equal to `table`
                if ($api_key != "table") {
                    if ($get_param_value != $api_key) {
                        $this->_response(['status' => FALSE, 'message' => 'API Key Invalid'], self::HTTP_UNAUTHORIZED);
                    }
                } else {
                    if (!isset($this->db)) {
                        $this->_response(['status' => FALSE, 'message' => 'Load CodeIgniter Database Library'], self::HTTP_BAD_REQUEST);
                    }
                    // check api key database table exists
                    if (!$this->db->table_exists($this->API_KEYS_TABLE_NAME)) {
                        $this->_response(['status' => FALSE, 'message' => 'Create API Key Database Table'], self::HTTP_BAD_REQUEST);
                    }
                    $where_key_data = ['access_controller' => $this->router->fetch_class(), 'access_api_key' => $get_param_value, ];
                    $limit_query = $this->db->get_where($this->API_KEYS_TABLE_NAME, $where_key_data);
                    if (!$this->db->affected_rows() > 0) {
                        $this->_response(['status' => FALSE, 'message' => 'API Key Invalid'], self::HTTP_NOT_FOUND);
                    }
                }
            } else {
                $this->_response(['status' => FALSE, 'message' => 'API Key GET Parameter Required'], self::HTTP_NOT_FOUND);
            }
        } else if (strtolower($api_key_type) == 'post') // // api key type `post`
        {
            // return status and header value `Content-Type`
            $is_header = $this->exists_header('Content-Type');
            if (isset($is_header['status']) === TRUE) {
                if ($is_header['value'] === "application/json") {
                    $stream_clean = $this->security->xss_clean($this->input->raw_input_stream);
                    $_POST = json_decode($stream_clean, true);
                }
            }
            $api_key_post_name = $this->config->item('api_key_post_name');
            $get_param_value = $this->input->post($api_key_post_name, TRUE);
            if (!empty($get_param_value) AND is_string($get_param_value)) {
                // if api key equal to `table`
                if ($api_key != "table") {
                    if ($get_param_value != $api_key) {
                        $this->_response(['status' => FALSE, 'message' => 'API Key Invalid'], self::HTTP_UNAUTHORIZED);
                    }
                } else {
                    if (!isset($this->db)) {
                        $this->_response(['status' => FALSE, 'message' => 'Load CodeIgniter Database Library'], self::HTTP_BAD_REQUEST);
                    }
                    // check api key database table exists
                    if (!$this->db->table_exists($this->API_KEYS_TABLE_NAME)) {
                        $this->_response(['status' => FALSE, 'message' => 'Create API Key Database Table'], self::HTTP_BAD_REQUEST);
                    }
                    $where_key_data = ['access_controller' => $this->router->fetch_class(), 'access_api_key' => $get_param_value, ];
                    $limit_query = $this->db->get_where($this->API_KEYS_TABLE_NAME, $where_key_data);
                    if (!$this->db->affected_rows() > 0) {
                        $this->_response(['status' => FALSE, 'message' => 'API Key Invalid'], self::HTTP_NOT_FOUND);
                    }
                }
            } else {
                $this->_response(['status' => FALSE, 'message' => 'API Key POST Parameter Required'], self::HTTP_NOT_FOUND);
            }
        } else {
            $this->_response(['status' => FALSE, 'message' => 'API Key Parameter Required'], self::HTTP_NOT_FOUND);
        }
    }
    /**
     * Is Authorized
     */
    private function _isAuthorized() {
        // Load Authorization Library
        $this->load->library('authorization_token');
        // check token is valid
        $result = $this->authorization_token->validateToken();
        if (isset($result['status']) AND $result['status'] === true) {
            return $result['data'];
        } else {
            $this->_response(['status' => FALSE, 'message' => $result['message']], self::HTTP_UNAUTHORIZED);
        }
    }
    /**
     * Check Request Header Exists
     * @return ['status' => true, 'value' => value ]
     */
    private function exists_header($header_name) {
        $headers = apache_request_headers();
        foreach ($headers as $header => $value) {
            if ($header === $header_name) {
                return ['status' => true, 'value' => $value];
            }
        }
    }
    /**
     * Private Response Function
     */
    private function _response($data = NULL, $http_code = NULL) {
        ob_start();
        header('content-type:application/json; charset=UTF-8');
        //header(self::HEADER_STATUS_STRINGS[$http_code], true, $http_code);
        if (!is_array($this->return_other_data)) {
            print_r(json_encode(['status' => false, 'message' => 'Invalid data format']));
        } else {
            print_r(json_encode(array_merge($data, $this->return_other_data)));
        }
        ob_end_flush();
        die();
    }
    /*
     * Public Response Function
    */
    public function api_return($data = NULL, $http_code = NULL) {
        ob_start();
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header($http_code) // Return status
            ->set_output(json_encode($data))->_display();
        exit;
        ob_end_flush();
        //header('content-type:application/json; charset=UTF-8');
        //header(self::HEADER_STATUS_STRINGS[$http_code], true, $http_code);
        //print_r(json_encode($data));
        
    }
}
