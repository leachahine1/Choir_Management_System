<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Section_leadermodel extends CI_Model {
    /**
     * This model is using into the Choir_members controller
     * Load : $this->load->model('Choir_membermodel');
     */
    function __construct() {
        parent::__construct();
        $this->load->dbforge();
    }

    //This functiion will return all section_leader information
    public function allSection_leaders() {
        $data = array();
        $query = $this->db->query("SELECT * FROM section_leaders_info");
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
}