<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class LibraryModel extends CI_Model {
    /**
     * This model is using into the Library controller
     * Load : $this->load->model('studentmodel');
     */
    function __construct() {
        parent::__construct();
        $this->load->dbforge();
    }
    
    //This function will return resources amount
    public function resourcesAmount() {
        $maxid = 0;
        $row = $this->db->query('SELECT MAX(resources_amount) AS `maxid` FROM `resources`')->row();
        if ($row) {
            $maxid = $row->maxid;
        }return $maxid + 1;
    }
    
    //This function will return resources amount
    public function resources_id() {
        $y = date('Y');
        $maxid = 0;
        $row = $this->db->query('SELECT MAX(resources_amount) AS `maxid` FROM `resources`')->row();
        if ($row) {
            $maxid = $row->maxid;
        }
        $s = $maxid + 1;
        return $y . $s;
    }

    //This function will select all libreary member list
    public function member_list() {
        $data = array();
        $query = $this->db->query("SELECT * FROM library_member");
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    //This function will return issued resource amount for a member
    public function issued_resource_amount($member_number) {
        $data = array();
        $query = $this->db->query("SELECT id FROM resources WHERE issu_member_no='$member_number'");
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return count($data);
    }
}
