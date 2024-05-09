<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Common extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->database();
        $this->load->dbforge();
    }
    //This function will return logo link
    public function logoTitle(){
        $data = array();
        $query =  $this->db->query("SELECT logo,school_name FROM configuration");
        foreach($query->result_array() as $row){
            $data[] = $row;
        }
        return $data;
    }
    
    //This function return the last inserted user id.
    function usersId() {
        $query = $this->db->query('SELECT id FROM users ORDER BY id DESC LIMIT 1');
        foreach ($query->result_array() as $row){
            $data = $row['id'];
        }
        return $data;
    }
    
    //This function select user access ability.
    public function user_access($role, $userId) {
        $data = array();
        $query = $this->db->query('SELECT ' . $role . ' FROM role_based_access WHERE user_id=' . $userId . ';')->row();
        foreach ($query as $row) {
            $data = $row;
        }
        if ($data == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    //This function show the Choir title for Choir selecting Choir
    public function selectChoir(){
        $data = array();
        $query = $this->db->query('SELECT id,Choir_title FROM Choir');
        foreach ($query->result_array() as $row){
            $data[] = $row;
        }
        return $data;
    } 
    
    //Total Choir_members will returan this function
    public function totalChoir_member() {
        $data = array();
        $query = $this->db->get('Choir_member_info');
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }return count($data);
    }
    
    //This function will cheack data table empty or not
    public function emptyCheack($a){
        $query = $this->db->query("SELECT * FROM $a")->row();
        if(empty($query)){
            return TRUE;
        }  else {
            return FALSE;
        }
    }

    //Total section_leaders will returan this function
    public function totalSection_leader() {
        $data = array();
        $query = $this->db->get('section_leaders_info');
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }return count($data);
    }

    //Total section_trainers will returan this function
    public function totalSection_trainers() {
        $data = array();
        $query = $this->db->get('section_trainers_info');
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }return count($data);
    }

    //Today total Attend Choir_member will returan this function
    public function totalAttendChoir_member() {
        $day = date("m/d/y");
        $date = strtotime($day);
        $data = array();
        $query = $this->db->get_where('daily_attendance', array('date' => $date, 'present_or_absent' => 'P'));
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }return count($data);
    }

    //This function will return time and date as a string
    public function iceTime() {
        $data = array();
        $query = $this->db->query('SELECT time_zone FROM configuration');
        foreach ($query->result_array() as $row) {
            $data = $row['time_zone'];
        }
        $datestring = "<i class=\"fa fa-clock-o\"></i> %h:%i %a  <i class=\"fa fa-calendar\"></i>  %d %M, %Y ";
        $now = now();
        $timezone = $data;
        $time = gmt_to_local($now, $timezone);
        echo mdate($datestring, $time);
    }

    //This function will return only Choir title by Choir id from Choir table.
    public function Choir_title($Choir_id){
        $data = array();
        $query = $this->db->query("SELECT Choir_title FROM Choir WHERE id=$Choir_id")->row();
            return $query->Choir_title;
    }

    public function ChoirIdInfo($a){
        $query = $this->db->query("SELECT id FROM Choir WHERE id=$a")->row();
        return $query;
    }
    
    //This function will show Choir_member title by Choir_member id
    public function Choir_member_title($Choir_member_id){
//        $data = array();
        $query = $this->db->query("SELECT Choir_member_nam FROM Choir_member_info WHERE Choir_member_id=$Choir_member_id")->row();
            return $query->Choir_member_nam;
    }
    
    //This function will return Choir_member ID by user ID
    public function Choir_member_id($user_id){
        if($this->ion_auth->in_group(3)){
            $query = $this->db->query("SELECT Choir_member_id FROM Choir_member_info WHERE user_id=$user_id")->row();
            return $query->Choir_member_id;
        }elseif ($this->ion_auth->in_group(5)) {
            $query = $this->db->query("SELECT Choir_member_id FROM section_trainers_info WHERE user_id=$user_id")->row();
            return $query->Choir_member_id;
        }
    }
    
    //Choir's short information will give this function 
    public function ChoirInfo(){
        $data = array();
        $query = $this->db->query("SELECT Choir_title,Choir_member_amount,attendance_percentices_daily,attend_percentise_yearly FROM Choir");
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }return $data;
    }

    function Choir_memberInfoId() {
        $maxid = 0;
        $row = $this->db->query('SELECT MAX(id) AS `maxid` FROM `Choir_member_info`')->row();
        if ($row) {
            $maxid = $row->maxid;
        }return $maxid;
    }

    public function getAllData($a) {
        $data = array();
        $query = $this->db->get($a);
        foreach ($query->result_array() as $row) {
            log_message('debug', 'Row data: ' . print_r($row, TRUE));
            $data[] = $row;
        }return $data;
    }

    public function getWhere($a, $b, $c) {
        $data = array();
        $query = $this->db->get_where($a, array($b => $c));
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }return $data;
    }

    public function getWhere22($a, $b, $c, $d, $e) {
        $data = array();
        $query = $this->db->get_where($a, array($b => $c, $d => $e));
        error_log($this->db->last_query());
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }return $data;
    }

    //THis function is take Choir title and make unic Roll nomber that Choir.
    //And return that roll number.
    public function rollNumber($a) {
        $query2 = $this->db->get_where('Choir_Choir_members', array('Choir_id' => $a));
        $qq = array();
        foreach ($query2->result_array() as $aa) {
            $qq[] = $aa;
        }
        $a = $qq;
        //return $a;
        $b = array();
        foreach ($a as $row) {
            $b[] = $row['roll_number'];
        }$c = $b;
        //return max($c);
        if (empty($a)) {
            $d = 1;
            return $d;
        } else {
            $c;
            $e = max($c);
            $e++;
            return $e;
        }
    }

    //This function will return total Choir_member amount in a Choir
    public function ChoirChoir_memberAmount($id) {
        $data = array();
        $query = $this->db->get_where('Choir', array('id' => $id));
        foreach ($query->result_array() as $row) {
            $data = $row;
        }
        $b = $data['Choir_member_amount'];
        $c = $b + 1;
        return $c;
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

    //This function return school name
    public function schoolName() {
        $data = array();
        $query = $this->db->get('configuration');
        foreach ($query->result_array() as $row) {
            $data = $row['school_name'];
        }return $data;
    }

    //This function return currency Choir name
    public function currencyChoir() {
        $data = array();
        $query = $this->db->get('configuration');
        foreach ($query->result_array() as $row) {
            $data = $row['currenct'];
        }return $data;
    }
    
    //This function will returan Choir_members information by id 
    public function stuInfoId($a){
        $query = $this->db->query("SELECT user_id,Choir_id,Choir_member_nam,Choir_member_photo FROM Choir_member_info WHERE Choir_member_id = $a")->row();
        return $query;
    }
    
    //This function will returan country code
    public function countryPhoneCode(){
        $query = $this->db->query("SELECT countryPhonCode FROM configuration")->row();
        return $query;
    }
    
    //This function will return section_leader's list
    public function section_leaderAttendance(){
        $data = array();
        $year = date('Y');
        $date = strtotime(date("d-m-Y"));
        $query = $this->db->query("SELECT employ_title,present_or_absent,attend_time FROM section_leader_attendance WHERE date=$date AND year = $year");
        foreach ($query->result_array() as $row){
            $data[] = $row;
        }
        return $data;
    }
    
    //This function will return Choir rehearsal term
    public function rehearsalTerm($a){
        $preRehearsalTerm = array();
        $query = $this->db->query("SELECT rehearsal_term FROM set_fees WHERE Choir_id = '$a'");
        foreach ($query->result_array() as $row){
            $preRehearsalTerm = $row['rehearsal_term'];
        }
        if($preRehearsalTerm == 0){
            $nextRehearsalTerm = $preRehearsalTerm + 1;
            return $nextRehearsalTerm;
        }  elseif ($preRehearsalTerm == 1) {
            $nextRehearsalTerm = $preRehearsalTerm + 1;
            return $nextRehearsalTerm;
        }  elseif ($preRehearsalTerm == 2) {
            $nextRehearsalTerm = $preRehearsalTerm + 1;
            return $nextRehearsalTerm;
        }  else {
            $nextRehearsalTerm = 1;
            return $nextRehearsalTerm;         
        }
    }
    
    //This function will return fee amount from configaration by Choir
    public function feeAmount($col,$ChoirTitle){
        $data = array();
        $query = $this->db->query("SELECT $col FROM set_fees WHERE Choir_title = '$ChoirTitle'");
//      return $query->$col;
        foreach ($query->result_array() as $row){
            $data = (int) $row[$col];
        }
        $value = $data;
        return $value;
    }
    
    //This function will return only have any entry by this current date
    public function cashResourceyes($table){
        $data = array();
        $date = strtotime(date('d-m-Y'));
        $query =  $this->db->query("SELECT id FROM $table WHERE date=$date ORDER BY id DESC LIMIT 1");
        foreach ($query->result_array() as $row){
            $data = $row['id'];
        }
        if(!empty($data)){
            return $data;
//            return TRUE;
        }  else {
            return FALSE;
        }
    }
    
    //This function will return cash resource item previous value
    public function cashResourceItem($si,$table){
        $data = array();
        $date = strtotime(date('d-m-Y'));
        $query =  $this->db->query("SELECT $si FROM $table WHERE date=$date ORDER BY id DESC LIMIT 1");
        foreach ($query->result_array() as $row){
            $data = $row["$si"];
        }
        return $data;
    }
    
    //This function will return only Choir list from "Choir" table.
    public function ChoirList(){
        $data = array();
        $query = $this->db->query("SELECT Choir_title FROM Choir");
        foreach ($query->result_array() as $row){
            $data[] = $row['Choir_title'];
        }return $data;
    }
    
    //This function will return final rehearsal by it's Choir name 
    public function finalRehearsal($ChoirTitle){
        $data =array();
//        $query  = $this->db->query("SELECT id FROM add_rehearsal WHERE Choir_title='$ChoirTitle' AND final='Final' AND publish='Publish'");
        $query  = $this->db->query("SELECT id FROM add_rehearsal WHERE Choir_title='$ChoirTitle' AND final='Final'");
        foreach ($query->result_array() as $row){
            $data[] = $row['id'];
        }
        return $data;
    }
    
    //This function will return Choir potional songs
    public function Choir_os($Choir_title)
    {
        $data = array();
        $query = $this->db->query("SELECT id,song_title FROM Choir_song WHERE Choir_title='$Choir_title' AND optional = 1");
        foreach ($query->result_array() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }
    //This function will show user group name
    public function group_name($gid){
        $data = array();
        $query = $this->db->query("SELECT name FROM groups WHERE id=$gid");
        foreach ($query->result_array() as $row){
            $group_name = $row['name'];
        }
        return $group_name;
    }
}
