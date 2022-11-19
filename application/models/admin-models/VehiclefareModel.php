<?php defined('BASEPATH') OR exit('No direct script access allowed');
class VehiclefareModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function save($data){
		try {
			$return = $this->db->insert($this->db->dbprefix('vehicles_fare'),$data);
			return $this->db->insert_id();
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
   public function update($where,$data){
		try {
			return $this->db->where($where)->update($this->db->dbprefix('vehicles_fare'),$data);
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	
	public function delete($where){
		try {
			return $this->db->where($where)->delete($this->db->dbprefix('vehicles_fare'));
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function fetch_all_vehiclefare(){
		try {
			$this->db->select($this->db->dbprefix('vehicles_fare').'.*,'.$this->db->dbprefix('vehicles').'.vehicle_name,'.$this->db->dbprefix('country').'.country_name,country_currency_symbols,'.$this->db->dbprefix('state').'.state_name,'.$this->db->dbprefix('cities').'.city_name');
			$this->db->from($this->db->dbprefix('vehicles_fare'));
			$this->db->join($this->db->dbprefix('country'),$this->db->dbprefix('country').'.country_id ='.$this->db->dbprefix('vehicles_fare').'.fare_country_id','left');
			$this->db->join($this->db->dbprefix('state'),$this->db->dbprefix('state').'.state_id ='.$this->db->dbprefix('vehicles_fare').'.fare_state_id','left');
			$this->db->join($this->db->dbprefix('cities'),$this->db->dbprefix('cities').'.city_id ='.$this->db->dbprefix('vehicles_fare').'.fare_city_id','left');
			$this->db->join($this->db->dbprefix('vehicles'),$this->db->dbprefix('vehicles').'.vehicle_id ='.$this->db->dbprefix('vehicles_fare').'.fare_vehicle_id','left');
			$this->db->order_by('fare_id','desc');
			$return = $this->db->get();
			return $return;
		}catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	public function fetch_vehiclefare_by_id($vehiclefare_id){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('vehicles_fare'));
			$this->db->where('fare_id',$vehiclefare_id);
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

	public function check_duplicate_fare($where){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('vehicles_fare'));
			if(!empty($where)){
				$this->db->where($where);
			}
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
} 