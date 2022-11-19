<?php defined('BASEPATH') OR exit('No direct script access allowed');
class DiscountModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function save($data){
		try {
			$return = $this->db->insert($this->db->dbprefix('discount'),$data);
			return $this->db->insert_id();
		}catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
   public function update($where,$data){
		try {
			return $this->db->where($where)->update($this->db->dbprefix('discount'),$data);
		}catch (Exception $e){
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	
	public function fetch_all_discount_records(){
		try {
			$this->db->select($this->db->dbprefix('discount').'.*,'.$this->db->dbprefix('country').'.country_name,'.$this->db->dbprefix('state').'.state_name,'.$this->db->dbprefix('cities').'.city_name');
			$this->db->from($this->db->dbprefix('discount'));
			$this->db->join($this->db->dbprefix('country'),$this->db->dbprefix('country').'.country_id ='.$this->db->dbprefix('discount').'.discount_country_id','left');
			$this->db->join($this->db->dbprefix('state'),$this->db->dbprefix('state').'.state_id ='.$this->db->dbprefix('discount').'.discount_state_id','left');
			$this->db->join($this->db->dbprefix('cities'),$this->db->dbprefix('cities').'.city_id ='.$this->db->dbprefix('discount').'.discount_city_id','left');
			$this->db->order_by('discount_id','desc');
			$return = $this->db->get();
			return $return;
		}catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	public function fetch_discount_by_id($discount_id){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('discount'));
			$this->db->where('discount_id',$discount_id);
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
    
    // get state method
    public function getState($country_id) {
        $this->db->select('state_id,state_name,state_country_id');
        $this->db->from($this->db->dbprefix('state'));
        $this->db->where('state_country_id',$country_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    
     // get city method
    public function getCity($state_id) {
        $this->db->select('city_id,city_name,city_state_id');
        $this->db->from($this->db->dbprefix('cities'));
        $this->db->where('city_state_id',$state_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    
	
} 