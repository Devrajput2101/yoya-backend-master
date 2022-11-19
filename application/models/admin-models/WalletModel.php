<?php defined('BASEPATH') OR exit('No direct script access allowed');
class WalletModel extends CI_Model {

	function __construct(){
		parent::__construct();
	}

	public function fetch_all_where($where){
		try {
			$this->db->select('*');
			$this->db->from($this->db->dbprefix('wallets'));
			$this->db->order_by('wallet_id','desc');
			$this->db->where($where);
			$return = $this->db->get();
			return $return;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
	
	public function balance($where){
		try {
		    $this->db->select('sum(case when wallet_transaction_type="1" then wallet_amount else -wallet_amount end) as balance');
		   	$this->db->where($where);
		   	$this->db->where('wallet_status','1');
			$return = $this->db->get($this->db->dbprefix('wallets'));
			$balance = 0;
			if($return->num_rows() > 0){
				$balance = $return->row()->balance;
			}

			return $balance;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}

	public function service_charge($where){
		try {
		    $this->db->select('sum(case when wallet_transaction_type="1" then wallet_amount end) as balance');
		   	$this->db->where($where);
		   	$this->db->where('wallet_status','1');
			$return = $this->db->get($this->db->dbprefix('wallets'));
			$balance = 0;
			if($return->num_rows() > 0){
				$balance = $return->row()->balance != null ? $return->row()->balance : 0;
			}
			return $balance;
		} catch (Exception $e) {
		  log_message('error',$e->getMessage());
		  return;
		}
	}
}