<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class AttendanceModule extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->load->dbforge();
    }

    //This function returan a day only.
    public function day() {
        $a = date("d");
        return $a;
    }

    //This function is returan an integer as a monthly Choir amount.
    public function ChoirAmountMonthly($var) {
        $maxid = 0;
        $row = $this->db->query("SELECT MAX(Choir_amount_monthly) AS `maxid` FROM `daily_attendance` WHERE Choir_member_id='$var'")->row();
        if ($row) {
            $maxid = $row->maxid;
        }return $maxid + 1;
    }

    //This function is returan an integer as a yearly Choir amount.
    public function ChoirAmountYearly($var) {
        $maxid = 0;
        $row = $this->db->query("SELECT MAX(Choir_amount_yearly) AS `maxid` FROM `daily_attendance` WHERE Choir_member_id='$var'")->row();
        if ($row) {
            $maxid = $row->maxid;
        }return $maxid + 1;
    }

    //This function is returan an integer as a monthly attend's amount.
    public function attendAmountMonthly($var) {
        $maxid = 0;
        $row = $this->db->query("SELECT MAX(attend_amount_monthly) AS `maxid` FROM `daily_attendance` WHERE Choir_member_id='$var'")->row();
        if ($row) {
            $maxid = $row->maxid;
        }return $maxid + 1;
    }

    //This function is returan an integer as a yearly attend's amount.
    public function attendAmountYearly($var) {
        $maxid = 0;
        $row = $this->db->query("SELECT MAX(attend_amount_yearly) AS `maxid` FROM `daily_attendance` WHERE Choir_member_id='$var'")->row();
        if ($row) {
            $maxid = $row->maxid;
        }return $maxid + 1;
    }

    //This function used to findout monthly attendence % by an Choir_member monthly.
    public function attendPercentiseMonthly($ver_1, $ver_2) {
        $a = $ver_1 * 100;
        $b = $a / $ver_2;
        return $b;
    }

    //This function used to findout monthly attendence % by an Choir_member monthly.
    public function attendPercentiseYearly($ver_1, $ver_2) {
        $a = $ver_1 * 100;
        $b = $a / $ver_2;
        return $b;
    }

    public function allChoir_membersDailyAttendence($date, $ChoirTitle) {
        $data = array();
        $query = $this->db->get_where('daily_attendance', array('date' => $date, 'Choir_title' => $ChoirTitle));
        foreach ($query->result_array() as $row) {
            $data[] = $row['percentise_month'];
        } $a = $data;
        $return = count($a);
        $allPercentise = array_sum($a);
        $garPercentise = $allPercentise / $return;
        return $garPercentise;
    }

    public function allChoir_membersYearlyAttendence($date, $ChoirTitle) {
        $data = array();
        $query = $this->db->get_where('daily_attendance', array('date' => $date, 'Choir_title' => $ChoirTitle));
        foreach ($query->result_array() as $row) {
            $data[] = $row['percentise_year'];
        } $a = $data;
        $return = count($a);
        $allPercentise = array_sum($a);
        $garPercentise = $allPercentise / $return;
        return $garPercentise;
    }

    //This function will return section_leader's list
    public function section_leaderList() {
        $data = array();
        $year = date('Y');
        $date = strtotime(date("d-m-Y"));
        $query = $this->db->query("SELECT id,employ_title FROM section_leader_attendance WHERE present_or_absent = 'Absent' AND date=$date AND year = $year");
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    //This function will cheack that today section_leader attendance taken or note
    public function todaySection_leaderAtt($date) {
        $year = date('Y');
        $query = $this->db->query("SELECT id FROM section_leader_attendance WHERE year='$year' AND date='$date'");
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        if (!empty($data)) {
            return 'Taken';
        }
    }

    //This function will return attend employees info
    public function attend_employe() {
        $data = array();
        $year = date('Y');
        $date = strtotime(date('d-m-Y'));
        $query = $this->db->query("SELECT id,date,employ_id,employ_title,present_or_absent,attend_time FROM section_leader_attendance WHERE year='$year'");
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }
}
