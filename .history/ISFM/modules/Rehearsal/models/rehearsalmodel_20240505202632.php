<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class RehearsalModel extends CI_Model {
    /**
     * This model is using into the Rehearsal controller
     * Load : $this->load->model('rehearsalmodel');
     */
    function __construct() {
        parent::__construct();
        $this->load->dbforge();
    }

    //This function is checking that have any rehearsal in that date.
    public function checkRehearsal($a, $b) {
        $data = array();
        $query = $this->db->get_where('rehearsal_routine', array('rehearsal_id' => $a, 'rehearsal_date' => $b));
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        $data = array_filter($data);
        if (!empty($data)) {
            return 'Have An Rehearsal';
        } else {
            return 'No Any Rehearsal';
        }
    }

    //This function will return only Choir title
    public function getChoirTitle() {
        $data = array();
        $query = $this->db->query("SELECT id,Choir_title FROM Choir");
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }return $data;
    }

    //This function will return rehearsal title which result is not compleated 
    public function rehearsalTitleRes($Choir_id) {
        $data = array();
        $query = $this->db->query("SELECT id,rehearsal_title FROM add_rehearsal WHERE Choir_id=$Choir_id");
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }return $data;
    }

    //This function will return which song's result will not publish
    public function rehearsalResSong($rehearsalId) {
        $data = array();
        $query = $this->db->query("SELECT id,rehearsal_song FROM rehearsal_routine WHERE rehearsal_id='$rehearsalId' ");
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }return $data;
    }

    //This function will check Choir_members optional song
    public function che_opt_sub($Choir_member_id, $songTitle) {
        $data = array();
        $query = $this->db->query("SELECT id FROM Choir_Choir_members WHERE Choir_member_id=$Choir_member_id AND optional_sub = '$songTitle'");
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        if (!empty($data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //This function is returan Rehearsal Title by RehearsalId.
    public function rehearsalTitle($id) {
        $data = array();
        $query2 = $this->db->query("SELECT rehearsal_title FROM add_rehearsal WHERE id=$id");
        foreach ($query2->result_array() as $row) {
            return $row['rehearsal_title'];
        }
    }

    //This function is returan Rehearsal  song by RehearsalId.
    public function rehearsalSongTitle($id) {
        $data = array();
        $query = $this->db->query("SELECT rehearsal_song FROM rehearsal_routine WHERE id='$id'");
        foreach ($query->result_array() as $row) {
            return $row['rehearsal_song'];
        }
    }

    //This function will return rehearsal song by rehearsal id and date
    public function rehearsalSong($a, $b) {
        $data = array();
        $query = $this->db->get_where('rehearsal_routine', array('rehearsal_id' => $a, 'rehearsal_date' => $b));
        foreach ($query->result_array() as $row) {
            return $row['rehearsal_song'];
        }
    }

    //This function return previous attendance view
    public function previewAttendance($a, $b, $c) {
        $data = array();
        $query = $this->db->get_where('rehearsal_attendanc', array('Choir_id' => $a, 'rehearsal_title' => $b, 'rehearsal_song' => $c));
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }return $data;
    }

    //This function gives tyeachers view.
    public function section_leaderInfo($userId) {
        $data = array();
        $query = $this->db->get_where('section_leaders_info', array('user_id' => $userId));
        foreach ($query->result_array() as $row) {
            $data = $row;
        }return $data;
    }

    //This function return result sheet
    public function checkResultShit($Choir_id, $rehearsalTitle, $song) {
        $data = array();
        $query = $this->db->get_where('result_shit', array('Choir_id' => $Choir_id, 'rehearsal_title' => $rehearsalTitle, 'rehearsal_song' => $song));
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }return $data;
    }

    public function approuveSongAmount($Choir_id, $rehearsalTitle) {
        $query = $this->db->get_where('result_submition_info', array('Choir_id' => $Choir_id, 'rehearsal_title' => $rehearsalTitle, 'submited' => '1'));
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        $songAmount = count($data);
        return $songAmount;
    }

    //This function return Choir song amount
    public function ChoirSongAmount($Choir_id) {
        $song = array();
        $query = $this->db->query("SELECT id FROM Choir_song WHERE Choir_id=$Choir_id AND optional!=1");
        foreach ($query->result_array() as $row) {
            $song[] = $row;
        }
        $songAmount = count($song);
        return $song;
    }

    //This function return absent amountby any Choir_member id
    public function absent($Choir_memberId) {
        $data = array();
        $query = $this->db->get_where('result_shit', array('Choir_member_id' => $Choir_memberId, 'result' => 'Absent'));
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        if (!empty($data)) {
            $failAmount = count($data);
        } else {
            $failAmount = 0;
        }
        return $failAmount;
    }

    //This function return fail amount by any Choir_member Id.
    public function fail($Choir_memberId) {
        $data = array();
        $query = $this->db->get_where('result_shit', array('Choir_member_id' => $Choir_memberId, 'result' => 'Fail'));
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        if (!empty($data)) {
            $failAmount = count($data);
        } else {
            $failAmount = 0;
        }
        return $failAmount;
    }

    //This function return a rehearsal title in a class.
    public function rehearsalTitleForMarkshit($Choir_id) {
        $data = array();
        $query = $this->db->get_where('add_rehearsal', array('Choir_id' => $Choir_id, 'publish' => 'Publish'));
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }return $data;
    }

    //THis function count the total point avarage that point.
    public function pointAverage($Choir_memberId, $ChoirSong){
        $data = array();
//      $query = $this->db->get_where('result_shit', array('Choir_member_id' => $Choir_memberId));
        $query = $this->db->query("SELECT point FROM result_shit WHERE Choir_member_id=$Choir_memberId");
        foreach ($query->result_array() as $row) {
            $data[] = $row['point'];
        }
        $totalPoint = array_sum($data);
        $result = $totalPoint / $ChoirSong;
        return round($result, 2);
    }

    //This function select the grade by the average point.
    public function averageGrade($point) {
        if ($point < 1) {
            $garde = 'F';
        } elseif ($point >= 1 & $point <= 1.99) {
            $garde = 'D';
        } elseif ($point >= 2 & $point <= 2.99) {
            $garde = 'C';
        } elseif ($point >= 3 & $point <= 3.49) {
            $garde = 'B';
        } elseif ($point >= 3.5 & $point <= 3.99) {
            $garde = 'A-';
        } elseif ($point >= 4 & $point <= 4.99) {
            $garde = 'A';
        } elseif ($point >= 5) {
            $garde = 'A+';
        }
        return $garde;
    }

    //This function count the total mark for Choir_member's rehearsal.
    public function totalMark($Choir_memberId) {
        $data = array();
        $query = $this->db->get_where('result_shit', array('Choir_member_id' => $Choir_memberId));
        foreach ($query->result_array() as $row) {
            $data[] = $row['mark'];
        }
        $totalPoint = array_sum($data);
        return $totalPoint;
    }

    //This function return the data for final reslt.
    public function finalResultShow($Choir_id, $rehearsalTitle) {
        $data = array();
        $query = $this->db->get_where('result_shit', array('Choir_id' => $Choir_id, 'rehearsal_title' => $rehearsalTitle));
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    //This function help to publish the result.
    public function publish($a, $b) {
        $data = array();
        $query = $this->db->get_where('result_action', array('status' => $a, 'publish' => $b));
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }return $data;
    }

    //This function return markshit by rehearsaltitle,class title and Choir_member id.
    public function markshit($rehearsalId, $Choir_id, $Choir_memberId) {
        $data = array();
        $query = $this->db->get_where('result_shit', array('rehearsal_id' => $rehearsalId, 'Choir_id' => $Choir_id, 'Choir_member_id' => $Choir_memberId));
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }return $data;
    }

    //This function will return Choir_member id by user id
    public function Choir_member_id($user_id) {
        $data = array();
        $query = $this->db->query("SELECT Choir_member_id FROM Choir_member_info WHERE user_id='$user_id'");
        foreach ($query->result_array() as $row) {
            $data = $row['Choir_member_id'];
        }
        return $data;
    }
}
