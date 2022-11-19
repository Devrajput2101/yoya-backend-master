<?php defined('BASEPATH') OR exit('No direct script access allowed');
class SearchModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}
	
// 	public function recent_search_list($where){
// 		try {
// 		    $this->db->select('drop_latitude,drop_distance_addresses,drop_longitude,drop_city');
// 			$this->db->from($this->db->dbprefix('order_request_drop'));
// 			$this->db->join($this->db->dbprefix('order_request'),$this->db->dbprefix('order_request').'.request_id ='.$this->db->dbprefix('order_request_drop').'.drop_request_id','right');
// 			$this->db->where($where);
// 			$this->db->limit(20);
// 			$this->db->order_by('drop_id','desc');
// 			$return = $this->db->get();
// 			return $return;
// 		} catch (Exception $e) {
// 		  log_message('error',$e->getMessage());
// 		  return;
// 		}
// 	}
	
	public function recent_search_list($where){
		try {
		    $this->db->select('request_pickup_latitude,request_pickup_longitude,request_pickup_address,request_pickup_city,request_id');
			$this->db->from($this->db->dbprefix('order_request'));
			$this->db->where($where);
			$return = $this->db->get();
			foreach($return->result() as $key => $data){
				$return->result()[$key]->request_drop_locations = $this->DropModel->fetch_drop_point(array('drop_request_id'=>$data->request_id))->result();
			}
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
}