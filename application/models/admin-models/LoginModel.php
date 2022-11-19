<?php 
class LoginModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function check_user_username($post){
		$this->db->select('*');
		$this->db->from($this->db->dbprefix('users'));
		$this->db->where('user_username',$post['username']);
		$checkuser = $this->db->get();
		if($checkuser->num_rows() > 0){
			return true;
		}
		return false;
	}

	public function fetch_user_by_username($post){
		$this->db->select('*');
		$this->db->from($this->db->dbprefix('users'));
		$this->db->where('user_username',$post['username']);
		$checkuser = $this->db->get()->row();
		return $checkuser;
	}
} 