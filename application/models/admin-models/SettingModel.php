<?php defined('BASEPATH') OR exit('No direct script access allowed');
class SettingModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function save($data){
		try {
			$return = $this->db->insert($this->db->dbprefix('settings'),$data);
			return $this->db->insert_id();
		}catch (Exception $e){
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function update($where,$data){
		try {
			return $this->db->where($where)->update($this->db->dbprefix('settings'),$data);
		} catch (Exception $e){
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	
	public function fetch_all_setings(){
	    $this->db->select('*');
        $result = $this->db->get($this->db->dbprefix('settings'))->result_array();
        $data   = array();
        foreach ($result as $key => $value) {
            $data[$value['setting_key']] = $value['setting_value'];
        }
        return $data;
	}
} 	