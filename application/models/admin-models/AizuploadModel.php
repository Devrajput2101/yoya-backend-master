<?php defined('BASEPATH') OR exit('No direct script access allowed');
class AizuploadModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}


	public function save($data){
		try {
			$return = $this->db->insert($this->db->dbprefix('uploads'),$data);
			return $this->db->insert_id();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_all_uploads(){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('uploads'));
			$this->db->join($this->db->dbprefix('users'),$this->db->dbprefix('users').'.user_id ='.$this->db->dbprefix('uploads').'.user_id','left');
			$return = $this->db->get();
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_single_uploads($ids){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('uploads'));
			$this->db->where_in('id',$ids);
			$return = $this->db->get();
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function singale_image_upload(){
    	$this->load->library('image_lib');
	    $config['upload_path'] 		= './uploads/all/';
	    $config['allowed_types'] 	= 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
	    $config['max_size'] 		= '';
	    $config['max_width']  		= '';
	    $config['max_height']  		= '';
	    $config['encrypt_name'] 	= true;
	    $this->load->library('upload', $config);
	    if(!$this->upload->do_upload('aiz_file')){
	    	return false;
	    }else{
		    $data = $this->upload->data();  
		    $image_size = getimagesize($_FILES['aiz_file']['tmp_name']);
		    $config['image_library'] = 'gd2';  
            $config['source_image']  = './uploads/all/'.$data["file_name"];  
            $config['create_thumb']  = false;  
            $config['maintain_ratio']= false;  
            $config['quality'] 		 = 60; 
            $config['width']   		 = $image_size[0] - 1;  
            $config['height'] 		 = $image_size[1] - 1;  
            $config['new_image'] 	 = './uploads/all/'.$data["file_name"];
            $this->image_lib->initialize($config);
            $this->image_lib->resize(); 
	    	return true;
	    }
		    
	}
} 