<?php
defined("BASEPATH") or exit("No direct script access allowed");
class ReasoncancelModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function save($data)
    {
        try {
            $return = $this->db->insert(
                $this->db->dbprefix("cancel_reason"),
                $data
            );
            return $this->db->insert_id();
        } catch (Exception $e) {
            log_message("error", $e->getMessage());
            return;
        }
    }

    public function update($where, $data)
    {
        try {
            return $this->db
                ->where($where)
                ->update($this->db->dbprefix("cancel_reason"), $data);
        } catch (Exception $e) {
            log_message("error", $e->getMessage());
            return;
        }
    }

    public function fetch_all_cancelation()
    {
        try {
            $this->db->select("*");
            $this->db->from($this->db->dbprefix("cancel_reason"));

            $this->db->order_by("reason_id", "desc");
            $return = $this->db->get();
            return $return;
        } catch (Exception $e) {
            log_message("error", $e->getMessage());
            return;
        }
    }

    public function fetch_reasoncancel_by_id($reason_id)
    {
        try {
            $this->db->select("*");
            $this->db->from($this->db->dbprefix("cancel_reason"));
            $this->db->where("reason_id", $reason_id);
            $checkuser = $this->db->get()->row();
            return $checkuser;
        } catch (Exception $e) {
            log_message("error", $e->getMessage());
            return;
        }
    }

    
}
