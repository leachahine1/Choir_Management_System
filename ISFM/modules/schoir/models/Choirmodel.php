<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Choirmodel extends CI_Model {
    /**
     * This model is using into the sChoir controller
     * Load : $this->load->model('Choirmodel');
     */
    function __construct() {
        parent::__construct();
        $this->load->dbforge();
    }

    //This function sent an array to sChoir controller's "addChoirRoutin" function.
    public function ChoirSong($a) {
        $data = array();
        $query = $this->db->get_where('Choir', array('Choir_title' => $a));
        foreach ($query->result_array() as $row) {
            $data = $row;
        }return $data;
    }

    //This functionn is for get data from database with two condition.
    public function getWhere($a, $b, $c, $d, $e) {
        $data = array();
        $query = $this->db->get_where($a, array($b => $c, $d => $e));
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }return $data;
    }

    //This function return total Choir_member amount in a Choir
    public function totalChoirChoir_member($ChoirTitle) {
        $data = array();
        $query = $this->db->get_where('Choir_Choir_members', array('Choir_title' => $ChoirTitle));
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }return count($data);
    }

    //This function return section amount in a Choir
    public function totalChoirSection($c_id) {
        $data = array();
        $query = $this->db->get_where('Choir', array('id' => $c_id));
        foreach ($query->result_array() as $row) {
            $data = $row['section'];
        }
        if (!empty($data)) {
            $section = explode(',', $data);
            return count($section);
        } else {
            return 'No Section';
        }
    }

    public function ChoirCodeCheck($a) {
        $data = array();
        $query = $this->db->get('Choir');
        foreach ($query->result_array() as $row) {
            $data[] = $row['ChoirCode'];
        }
        if (in_array($a, $data)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    //This function will return true or false final rehearsal and result compleate or not
    public function chFiExRe($Choir_id) {
        $query = $this->db->query("SELECT publish,status FROM add_rehearsal WHERE Choir_id='$Choir_id' AND final='Final'");
        foreach ($query->result_array() as $row) {
            $publich = $row['publish'];
            $status = $row['status'];
        }
        if (!empty($publich)) {
            if ($publich == 'Publish') {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    //This function will make marite list 
    public function meritList($rehearsalId) {
        $data = array();
        $query = $this->db->query("SELECT Choir_member_id,total_mark FROM final_result WHERE rehearsal_id='$rehearsalId'");
        foreach ($query->result_array() as $row) {
            $index = $row['Choir_member_id'];
            $data["$index"] = $row['total_mark'];
        }
        arsort($data);
        $ri = 1;
        foreach ($data as $key => $value) {
            $meritList = array(
                'maride_list' => $ri
            );
            $this->db->where('Choir_member_id', $key);
            $this->db->update('final_result', $meritList);
            $ri++;
        }
    }

    //This function will return Choir section Choir_member capacity
    public function sectionCap($ChoirId) {
        $data = array();
        $query = $this->db->query("SELECT section_Choir_member_capacity FROM Choir WHERE id='$ChoirId'");
        foreach ($query->result_array() as $row) {
            return $row['section_Choir_member_capacity'];
        }
    }

    //This function will return Choir_member new Choir section by his Choir_memberid
    public function sectionSelect($Choir_memberId, $i) {
        $data = array();
        $query = $this->db->query("SELECT Choir_title,sex FROM Choir WHERE Choir_member_id='$Choir_memberId'");
        foreach ($query->result_array() as $row) {
            
        }
    }
}
