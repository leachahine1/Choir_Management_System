<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Messagemodel extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->load->dbforge();
    }

    //This function return all Choir_members phone number.
    public function Choir_memberNumber($a, $b, $c = NULL) {
        $number = array();
        if ($a == 'Choir_member') {
            //The message receiver group is Choir_member.
            if ($b == 'AllChoir_memberSchool') {
                $query = $this->db->query('SELECT phone FROM Choir_member_info');
                foreach ($query->result_array() as $row) {
                    $number[] = $row['phone'];
                }
            } elseif (!empty($b)) {
                if ($c == 'AllChoir_membersChoir') {
                    $query = $this->db->query("SELECT phone FROM Choir_member_info WHERE Choir_title ='$b'");
                    foreach ($query->result_array() as $row) {
                        $number[] = $row['phone'];
                    }
                } else {
                    $query = $this->db->query("SELECT phone FROM Choir_member_info WHERE Choir_member_id =$c");
                    foreach ($query->result_array() as $row) {
                        $number[] = $row['phone'];
                    }
                }
            }
        } elseif ($a == 'Section_leader') {
            //The message receiver group is section_leader.
            if ($b == 'AllSection_leader') {
                $query = $this->db->query('SELECT phone FROM section_leaders_info');
                foreach ($query->result_array() as $row) {
                    $number[] = $row['phone'];
                }
            } elseif (!empty($b)) {
                $query = $this->db->query("SELECT phone FROM section_leaders_info WHERE user_id = $b");
                foreach ($query->result_array() as $row) {
                    $number[] = $row['phone'];
                }
            }
        } else {
            //The message receiver group is parents.
        }
        return $number;
    }
}
