<?php defined('BASEPATH') OR exit('No direct script access allowed');
class CitysModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function save($data){
		try {
			$return = $this->db->insert($this->db->dbprefix('cities'),$data);
			return $this->db->insert_id();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
   public function update($where,$data){
		try {
			return $this->db->where($where)->update($this->db->dbprefix('cities'),$data);
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	
	public function fetch_all_city(){
		try {
			$this->db->select($this->db->dbprefix('cities').'.*,'.$this->db->dbprefix('country').'.country_name,'.$this->db->dbprefix('state').'.state_name');
			$this->db->from($this->db->dbprefix('cities'));
			$this->db->join($this->db->dbprefix('state'),$this->db->dbprefix('state').'.state_id ='.$this->db->dbprefix('cities').'.city_state_id','left');
			$this->db->join($this->db->dbprefix('country'),$this->db->dbprefix('country').'.country_id ='.$this->db->dbprefix('cities').'.city_country_id','left');
			$this->db->order_by('city_id','desc');
			$return = $this->db->get();
			return $return;
		}catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	public function fetch_city_by_id($city_id){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('cities'));
			$this->db->where('city_id',$city_id);
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
        $this->db->order_by('city_name','asc');
        $query = $this->db->get($this->db->dbprefix('cities'));
        $data[''] = "--Select Cities--";
        foreach ($query->result_array() as $row) {
            $data[$row['city_id']] = $row['city_name'];
        }
        return $data;
    }

     // get state method
    public function getCity($state_id) {
    	try {
	        $this->db->select('*');
	        $this->db->from($this->db->dbprefix('cities'));
	        $this->db->where('city_state_id',$state_id);
	        $query = $this->db->get();
	        return $query->result_array();
	    } catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
    }
	
} 