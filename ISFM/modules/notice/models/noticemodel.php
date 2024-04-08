<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class noticemodel extends CI_Model {
    /**
     * This model is using into the Notice controller
     * Load : $this->load->model('noticemodel');
     */
    function __construct() {
        parent::__construct();
        $this->load->dbforge();
    }

    //This function is using for the get all and Section_leader's notice by SQL where query.
    public function getSection_leaderNotice() {
        $data = array();
        $query = $this->db->query("SELECT * FROM notice_board WHERE receiver='section_leader' OR receiver='all'");
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }return $data;
    }

    //This function is using for the get all and Choir_member's notice by SQL where query.
    public function getChoir_memberNotice() {
        $data = array();
        $query = $this->db->query("SELECT * FROM notice_board WHERE receiver='Choir_member' OR receiver='all'");
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }return $data;
    }

    //This function is using for the get all Employe's and Accountends's notice by SQL where query.
    public function getEANotice() {
        $data = array();
        $query = $this->db->query("SELECT * FROM notice_board WHERE receiver='all'");
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }return $data;
    }

}
