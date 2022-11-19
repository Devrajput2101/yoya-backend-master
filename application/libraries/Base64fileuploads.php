<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Base64fileuploads class about
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Base64fileuploads
 * @author		K.K ADIL KHAN AJAD
 */
class Base64fileuploads { 
	/**
	 * file name
	 *
	 * @var	int
	 */
	public $file_name = '';
	/**
	 * file string base 64
	 *
	 * @var	int
	 */
	public $file_string = '';
	/**
	 * save_file_type
	 *
	 * @var	int
	 */
	public $file_ext = '';
	/**
	 * Maximum file size
	 *
	 * @var	int
	 */
	public $max_size = 0;
	/**
	 * Allowed file types
	 *
	 * @var	string
	 */
	public $allowed_types = '';
	/**
	 * File size
	 *
	 * @var	int
	 */
	public $file_size = NULL;
	/**
	 * Upload path
	 *
	 * @var	string
	 */
	public $upload_path = '';

	/**
	 * Upload path create
	 *
	 * @var	string
	 */
	public $path_create = FALSE;
		/**
	 * Error messages list
	 *
	 * @var	array
	 */
	public $error_msg = array();
	/**
	 * Upload file name encryption
	 *
	 * @var	string
	 */
	public $encryption = FALSE;
	//--------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @param	array	$config
	 * @return	void
	 */
	public function __construct($config = array())
	{
		empty($config) OR $this->initialize($config, FALSE);

		$this->_mimes =& get_mimes();
		$this->_CI =& get_instance();

		log_message('info', 'Base64fileuploads Class Initialized');
	}
	// --------------------------------------------------------------------

	/**
	 * Initialize preferences
	 *
	 * @param	array	$config
	 * @param	bool	$reset
	 * @return	CI_Upload
	 */
	public function initialize(array $config = array(), $reset = TRUE)
	{
		$reflection = new ReflectionClass($this);

		if ($reset === TRUE)
		{
			$defaults = $reflection->getDefaultProperties();
			foreach (array_keys($defaults) as $key)
			{
				if ($key[0] === '_')
				{
					continue;
				}

				if (isset($config[$key]))
				{
					if ($reflection->hasMethod('set_'.$key))
					{
						$this->{'set_'.$key}($config[$key]);
					}
					else
					{
						$this->$key = $config[$key];
					}
				}
				else
				{
					$this->$key = $defaults[$key];
				}
			}
		}
		else
		{
			foreach ($config as $key => &$value)
			{
				if ($key[0] !== '_' && $reflection->hasProperty($key))
				{
					if ($reflection->hasMethod('set_'.$key))
					{
						$this->{'set_'.$key}($value);
					}
					else
					{
						$this->$key = $value;
					}
				}
			}
		}
		//create a directory
		if($this->path_create == true && !empty($this->upload_path)){
			if (!is_dir($this->upload_path) && !file_exists($this->upload_path)) {
	            mkdir($this->upload_path, 0777, TRUE);
	        }
	        $this->upload_path = $this->upload_path;
		}

		return $this;
	}

	public function do_upload(){
		//check base64 image string 
		if(!$this->isBase64Encoded($this->file_string)){
			$this->set_error('invalid Base64 image string !', 'error');
			return false;
		}
		//check path is exist Or not 
		if(empty($this->upload_path) || !file_exists($this->upload_path)){
			$this->set_error('upload path does not appear to be valid !', 'error');
			return false;
		}


		/*=================uploads=================*/
        $this->file_name  = $this->encryption == true ? md5(time()) : time();
        $random_file_name = $this->upload_path.'/'.$this->file_name.'.'.$this->file_ext;
        if(file_put_contents($random_file_name,base64_decode($this->file_string))){
        	return true;
        }else{
        	$this->set_error('File uploading error !', 'error');
        	return false;
        }
	}

	/**
	 * Finalized Data Array
	 *
	 * Returns an associative array containing all of the information
	 * related to the upload, allowing the developer easy access in one array.
	 *
	 * @param	string	$index
	 * @return	mixed
	 */
	public function data($index = NULL)
	{
		$data = array(
				'file_name'		=> $this->file_name.'.'.$this->file_ext,
				'file_path'		=> str_replace('.','',$this->upload_path),
				'full_path'		=> str_replace('.','',$this->upload_path).'/'.$this->file_name.'.'.$this->file_ext,
				'raw_name'		=> $this->file_name.'.'.$this->file_ext,
			);

		if ( ! empty($index))
		{
			return isset($data[$index]) ? $data[$index] : NULL;
		}

		return $data;
	}

	public static function isBase64Encoded($str){
	    try
	    {
	        $decoded = base64_decode($str, true);
	        if (base64_encode($decoded) === $str ) {
	            return true;
	        }
	        else {
	            return false;
	        }
	    }catch(Exception $e){
	        // If exception is caught, then it is not a base64 encoded string
	        return false;
	    }

	}

	// --------------------------------------------------------------------

	/**
	 * Set an error message
	 *
	 * @param	string	$msg
	 * @return	CI_Upload
	 */
	public function set_error($msg, $log_level = 'error')
	{
		$this->_CI->lang->load('upload');

		is_array($msg) OR $msg = array($msg);
		foreach ($msg as $val)
		{
			$msg = ($this->_CI->lang->line($val) === FALSE) ? $val : $this->_CI->lang->line($val);
			$this->error_msg[] = $msg;
			log_message($log_level, $msg);
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Display the error message
	 *
	 * @param	string	$open
	 * @param	string	$close
	 * @return	string
	 */
	public function display_errors($open = '', $close = '')
	{
		return (count($this->error_msg) > 0) ? $open.implode($close.$open, $this->error_msg).$close : '';
	}
}