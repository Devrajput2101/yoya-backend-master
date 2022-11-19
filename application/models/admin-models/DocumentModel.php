<?php defined('BASEPATH') OR exit('No direct script access allowed');
class DocumentModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function check_duplicate($where){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('documents'));
			$this->db->where($where);
			$checkuser = $this->db->get()->num_rows();
			if($checkuser > 0){
				return true;
			}
			return false;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function save($data){
		try {
			$this->db->set('doc_create_at',date('Y-m-d H-i:s'));
			$this->db->set('doc_update_at',date('Y-m-d H-i:s'));
			$return = $this->db->insert($this->db->dbprefix('documents'),$data);
			return $this->db->insert_id();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function update($where,$data){
		try {
			$this->db->set('doc_update_at',date('Y-m-d H-i:s'));
			return $this->db->where($where)->update($this->db->dbprefix('documents'),$data);
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_all_documents_by_user_id($user_id){
		try {
			$this->db->select('doc_id,doc_back_image,doc_front_image,doc_id_number,doc_types,doc_status,user_name');
			$this->db->from($this->db->dbprefix('documents'));
			$this->db->join($this->db->dbprefix('users'),$this->db->dbprefix('users').'.user_id ='.$this->db->dbprefix('documents').'.doc_user_id','left');
			$this->db->where('user_id',$user_id);
			$return = $this->db->get();
			foreach ($return->result() as $key => $value) {
				$return->result()[$key]->doc_front_image = api_url($value->doc_front_image);
				$return->result()[$key]->doc_back_image = api_url($value->doc_back_image);
				$return->result()[$key]->doc_display_status = "pending"; 
				if($value->doc_status == '2'){
					$return->result()[$key]->doc_display_status = "rejected"; 
				}else if($value->doc_status == '1'){
					$return->result()[$key]->doc_display_status = "complete"; 
				}
				
			}
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}


	public function fetch_document($where){
		try {
			$this->db->select('doc_id,doc_back_image,doc_front_image,doc_id_number,doc_document_id,doc_status,user_name');
			$this->db->from($this->db->dbprefix('documents'));
			$this->db->join($this->db->dbprefix('users'),$this->db->dbprefix('users').'.user_id ='.$this->db->dbprefix('documents').'.doc_user_id','left');
			$this->db->where($where);
			$return = $this->db->get();
			foreach ($return->result() as $key => $value) {
				$return->result()[$key]->doc_front_image = api_url($value->doc_front_image);
				$return->result()[$key]->doc_back_image = api_url($value->doc_back_image);

				$return->result()[$key]->doc_display_status     = "pending"; 
				if($value->doc_status == '2'){
					$return->result()[$key]->doc_display_status = "rejected"; 
				}else if($value->doc_status == '1'){
					$return->result()[$key]->doc_display_status = "verified"; 
				}
			}
			return $return->row();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	
	public function status($user_id){
	    try {
    	    $user = $this->UsersModel->fetch_user_by_id($user_id);
            $country = $this->CountrysModel->get_country(array('country_code'=>$user->user_country_code))->row();
            $results = $this->RequiredDocumentModel->fetch_all(array('document_country_id'=>$country->country_id));
    	    //document modification and check status by users
    		$kyc_status = false;
    		foreach($results->result() as $key => $data){
    			$kyc_status = true;	
    			$document   = $this->DocumentModel->fetch_document(array('doc_user_id'=>$user_id,'doc_document_id'=>$data->document_id));
        		if(!empty($document)){
        			if($document->doc_status == 0 || $document->doc_status == 2){
        				$kyc_status = false;
        				break;
        			}
    			}else{
    				$kyc_status = false;
    				break;
    			}
    		}
    		return $kyc_status;
	    } catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
}