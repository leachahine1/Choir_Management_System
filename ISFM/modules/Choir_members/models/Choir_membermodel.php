<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Choir_membermodel extends CI_Model {
    /**
     * This model is using into the Choir_members controller
     * Load : $this->load->model('Choir_membermodel');
     */
    function __construct() {
        parent::__construct();
        $this->load->dbforge();
    }

    //This function return class section 
    public function ChoirSection($Choir_id) {
        $data = array();
        $query = $this->db->query("SELECT section FROM Choir WHERE id=$Choir_id");
        if (!$query) {
            log_message('error', 'Query failed: '.$this->db->last_query());
            return []; // or handle error appropriately
        }
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    //This function return all Choir_member in a class.
    public function getAllChoir_member($a) {
        $query = $this->db->get_where('Choir_Choir_members', array('Choir_id' => $a, 'year' => date('Y')));
        echo $this->db->last_query(); // Add this to see the generated query
    
        $data = array();
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
    

    public function getChoir_memberByChoirSection($a, $b) {
        if ($b == 'all') {
            $query = $this->db->get_where('Choir_Choir_members', array('Choir_id' => $a));
            $data = array();
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }return $data;
        } else {
            $query = $this->db->get_where('Choir_Choir_members', array('Choir_id' => $a, 'section' => $b));
            $data = array();
            foreach ($query->result_array() as $row) {
                $data[] = $row;
            }return $data;
        }
    }

    //THis function return Choir_member's picture name from database.
    public function Choir_memberPhoto($Choir_memberId) {
        $query = $this->db->get_where('Choir_member_info', array('Choir_member_id' => $Choir_memberId));
        $data = array();
        foreach ($query->result_array() as $row) {
            $data = $row;
        }
        return $data['Choir_member_photo'];
    }

    //THis function return Choir_member's picture name from database.
    public function ownChoir_memberPhoto($userId) {
        $query = $this->db->get_where('Choir_member_info', array('user_id' => $userId));
        $data = array();
        foreach ($query->result_array() as $row) {
            $data = $row;
        }
        return $data['Choir_member_photo'];
    }

    //This function return a Choir_member's details by Choir_member database row id.
    public function Choir_memberDetails($a) {
        $query = $this->db->get_where('Choir_Choir_members', array('id' => $a));
        $data = array();
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    //This function return a Choir_member's details by Choir_member database row id.
    public function ownChoir_memberDetails($a) {
        $query = $this->db->get_where('Choir_Choir_members', array('user_id' => $a));
        $data = array();
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    //This function return a class section by this class title.
    public function section($a) {
        $query = $this->common->getWhere('Choir', 'Choir_title', $a);
        foreach ($query as $row) {
            $data = $row;
        }
        //making here Choir Section fild.
        if (!empty($data['section'])) {
            $section = $data['section'];
            $sectionArray = explode(",", $section);
            return $sectionArray;
        } else {
            $section = 'This Choir has no section.';
            return $section;
        }
    }

    //This function return markshit by rehearsaltitle,class title and Choir_member id.
    public function markshit($rehearsalTitle, $Choir_id, $Choir_memberId) {
        $data = array();
        $query = $this->db->get_where('result_shit', array('rehearsal_title' => $rehearsalTitle, 'Choir_id' => $Choir_id, 'Choir_member_id' => $Choir_memberId));
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }return $data;
    }
}
