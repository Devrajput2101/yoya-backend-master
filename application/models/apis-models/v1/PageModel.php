<?php defined('BASEPATH') OR exit('No direct script access allowed');
class PageModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function fetch_all_pages($page_type = null){
		try {
			$this->db->select('page_title,page_slug,page_description,page_image');
			$this->db->from($this->db->dbprefix('page'));
			$this->db->where('page_type',$page_type);
			$checkuser = $this->db->get();
				foreach($checkuser->result() as $key => $data){ 
		  		$checkuser->result()[$key]->page_image = image_assets($data->page_image); 
		  	}
			return $checkuser ;
	   	}catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
}