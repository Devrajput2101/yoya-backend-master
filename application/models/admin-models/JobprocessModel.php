<?php defined('BASEPATH') OR exit('No direct script access allowed');
class JobprocessModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function save($data){
		try {
			$return = $this->db->insert($this->db->dbprefix('job_process'),$data);
			return $this->db->insert_id();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
   public function update($where,$data){
		try {
			return $this->db->where($where)->update($this->db->dbprefix('job_process'),$data);
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	
	public function fetch_all_jobprocess(){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('job_process'));
			$this->db->order_by('job_process_id','desc');
			$return = $this->db->get();
			return $return;
		}catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	public function fetch_single_customer($user_id){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('customers'));
			$this->db->join($this->db->dbprefix('users'),$this->db->dbprefix('users').'.user_id ='.$this->db->dbprefix('customers').'.customer_user_id','left');
			$this->db->where('customer_user_id',$user_id);
			$return = $this->db->get()->row();
			return $return;
		} catch (Exception $e){
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	public function fetch_jobprocess_by_id($job_process_id){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('job_process'));
			$this->db->where('job_process_id',$job_process_id);
			$checkuser = $this->db->get()->row();
			return $checkuser;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	
   public function _dropdownlist($slect1, $slect2, $where, $tbl, $option = null,$orderby = null){
        $this->db->select($slect1 . ',' . $slect2);
        if ($where != "") {
            $this->db->where($where);
        }
        if ($orderby != null) {
            $this->db->order_by($orderby);
        }
        $query = $this->db->get($tbl);

        if ($option != null) {
            $data[''] = $option;
        }
        
        foreach ($query->result_array() as $row) {
            $data[$row[$slect1]] = $row[$slect2];
        }
        return $data;
    }   

    public function _dropdownslist($where = null){
        $this->db->select('*');
        if($where != null) {
        	$this->db->where($where);
        }
        $this->db->order_by('job_process_name','asc');
        $query = $this->db->get($this->db->dbprefix('job_process'));
        $data[''] = "Select job process";
        foreach ($query->result_array() as $row) {
            $data[$row['job_process_id']] = $row['job_process_name'];
        }
        return $data;
    }
	
} 