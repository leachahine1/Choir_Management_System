<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class SChoir extends MX_Controller {
    /**
     * This controller is use for add Choir and maintain Choir
     *
     * Maps to the following URL
     * 		http://rehearsalple.com/index.php/SChoir
     * 	- or -  
     * 		http://rehearsalple.com/index.php/SChoir/<method_name>
     */
    function __construct() {
        parent::__construct();
        $this->load->model('Choirmodel');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
    }
    //This function is useing for add a new Choir and section.
    public function addChoir() {
        if ($this->input->post('submit', TRUE)) {
            $ChoirTitle = $this->input->post('Choir_title', TRUE);
            $group = $this->input->post('group', TRUE);
            if ($this->input->post('group_2', TRUE)) {
                $group = $this->input->post('group', TRUE) . ',' . $this->input->post('group_2', TRUE);
            }
            if ($this->input->post('group_3', TRUE)) {
                $group = $this->input->post('group', TRUE) . ',' . $this->input->post('group_2', TRUE) . ',' . $this->input->post('group_3', TRUE);
            }
            $section = $this->input->post('section', TRUE);
            if ($this->input->post('section_2', TRUE)) {
                $section = $this->input->post('section', TRUE) . ',' . $this->input->post('section_2', TRUE);
            }
            if ($this->input->post('section_3', TRUE)) {
                $section = $this->input->post('section', TRUE) . ',' . $this->input->post('section_2', TRUE) . ',' . $this->input->post('section_3', TRUE);
            }
            if ($this->input->post('section_4', TRUE)) {
                $section = $this->input->post('section', TRUE) . ',' . $this->input->post('section_2', TRUE) . ',' . $this->input->post('section_3', TRUE) . ',' . $this->input->post('section_4', TRUE);
            }
            if ($this->input->post('section_5', TRUE)) {
                $section = $this->input->post('section', TRUE) . ',' . $this->input->post('section_2', TRUE) . ',' . $this->input->post('section_3', TRUE) . ',' . $this->input->post('section_4', TRUE) . ',' . $this->input->post('section_5', TRUE);
            }
            $capicity = $this->input->post('capicity', TRUE);
            $ChoirCode = $this->input->post('Choir_code', TRUE);
            $tableData = array(
                'Choir_title' => $this->db->escape_like_str($ChoirTitle),
                'Choir_group' => $this->db->escape_like_str($group),
                'section' => $this->db->escape_like_str($section),
                'section_Choir_member_capacity' => $this->db->escape_like_str($capicity),
                'ChoirCode' => $this->db->escape_like_str($ChoirCode)
            );
            if ($this->db->insert('Choir', $tableData)) {
                $data['success'] = '<div class="alert alert-info alert-dismissable admisionSucceassMessageFont">
                                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button"></button>
                                            <strong>'.lang('success').'</strong>'.lang('clasc_1').' "' . $ChoirTitle . '" '.lang('clasc_2').'
                                    </div>';
                $data['ChoirInfo'] = $this->common->getAllData('Choir');
                $this->load->view('temp/header');
                $this->load->view('allChoir', $data);
                $this->load->view('temp/footer');
            }
        } else {
            $data['section_leader'] = $this->common->getAllData('section_leaders_info');
            $this->load->view('temp/header');
            $this->load->view('addChoirSection', $data);
            $this->load->view('temp/footer');
        }
    }
    
    //This function can edit Choir information
    public function deleteChoir() {
        $id = $this->input->get('id');
        if ($this->db->delete('Choir', array('id' => $id))) {
            redirect('sChoir/allChoir/', 'refresh');
        }
    }
    
    //This function is useing for geting all Choir short information
    public function allChoir() {
        $data['ChoirInfo'] = $this->common->getAllData('Choir');
        $this->load->view('temp/header');
        $this->load->view('allChoir', $data);
        $this->load->view('temp/footer');
    }
    
    //This function is useing for a Choir's full informtion
    public function ChoirDetails() {
        $Choir_id = $this->input->get('c_id');
        $data['Choir'] = $this->common->getWhere('Choir', 'id', $Choir_id);
        $data['day'] = $this->common->getAllData('config_week_day');
        $data['song'] = $this->common->getWhere('Choir_song', 'Choir_id', $Choir_id);
        $data['section_leader'] = $this->common->getAllData('section_leaders_info');
        $data['ChoirSection'] = $this->Choirmodel->totalChoirSection($Choir_id);
        $this->load->view('temp/header');
        $this->load->view('ChoirDetails', $data);
        $this->load->view('temp/footer');
    }
    //This function lode the view for select which Choir routine add or make
    public function selectChoirRoutin() {
        $data['ChoirTile'] = $this->common->getAllData('Choir');
        $data['day'] = $this->common->getAllData('config_week_day');
        $this->load->view('temp/header');
        $this->load->view('selectChoirRoutine', $data);
        $this->load->view('temp/footer');
    }
    //This function is useing for add new Choir routine
    public function addChoirRoutin() {
        $Choir_id = $this->input->post('Choir', TRUE);
        $ChoirTitle = $this->common->Choir_title($Choir_id);
        //if admin set section for any Choir then bellow [if(){ condition]  will execute ***(Start)***
        if ($this->input->post('section', TRUE)) {
            $section = $this->input->post('section', TRUE);
            //if admin set "all" section for any Choir then bellow [if(){ condition]  will execute ***(Start)***
            if ($section == 'all') {
                if ($this->input->post('submit2', TRUE)) {
                    $day = $this->input->post('day', TRUE);
                    $song = $this->input->post('song', TRUE);
                    $section_leader = $this->input->post('section_leader', TRUE);
                    $startTime = $this->input->post('startTime', TRUE);
                    $endTime = $this->input->post('endTime', TRUE);
                    $roomNumber = $this->input->post('roomNumber', TRUE);
                    $tableData = array(
                        'Choir_id' => $this->db->escape_like_str($Choir_id),
                        'day_title' => $this->db->escape_like_str($day),
                        'section' => $this->db->escape_like_str($section),
                        'song' => $this->db->escape_like_str($song),
                        'song_section_leader' => $this->db->escape_like_str($section_leader),
                        'start_time' => $this->db->escape_like_str($startTime),
                        'end_time' => $this->db->escape_like_str($endTime),
                        'room_number' => $this->db->escape_like_str($roomNumber)
                    );
                    $tableData2 = array(
                        'song_section_leader' => $this->db->escape_like_str($section_leader),
                    );
                    if ($this->db->insert('Choir_routine', $tableData) && $this->db->update('Choir_song', $tableData2, array('Choir_id' => $Choir_id, 'song_title' => $song))) {
                        $data['ChoirTile'] = $ChoirTitle;
                        $data['Choir_id'] = $Choir_id;
                        $data['day'] = $this->common->getAllData('config_week_day');
                        $data['song'] = $this->common->getWhere('Choir_song', 'Choir_id', $Choir_id);
                        $data['section_leader'] = $this->common->getAllData('section_leaders_info');
                        $this->load->view('temp/header');
                        $this->load->view('addChoirRoutin', $data);
                        $this->load->view('temp/footer');
                    }
                } else {
                    $data['ChoirTile'] = $ChoirTitle;
                    $data['Choir_id'] = $Choir_id;
                    $data['day'] = $this->common->getAllData('config_week_day');
                    $data['song'] = $this->common->getWhere('Choir_song', $Choir_id);
                    $data['section_leader'] = $this->common->getAllData('section_leaders_info');
                    $this->load->view('temp/header');
                    $this->load->view('addChoirRoutin', $data);
                    $this->load->view('temp/footer');
                }
            }
            //if admin set "Section A or any specific section" for any Choir then bellow [ealse{ condition]  will execute ***(Start)***
            else {
                if ($this->input->post('submit2', TRUE)) {
                    $day = $this->input->post('day', TRUE);
                    $song = $this->input->post('song', TRUE);
                    $section_leader = $this->input->post('section_leader', TRUE);
                    $startTime = $this->input->post('startTime', TRUE);
                    $endTime = $this->input->post('endTime', TRUE);
                    $roomNumber = $this->input->post('roomNumber', TRUE);
                    $tableData = array(
                        'Choir_id' => $this->db->escape_like_str($Choir_id),
                        'day_title' => $this->db->escape_like_str($day),
                        'section' => $this->db->escape_like_str($section),
                        'song' => $this->db->escape_like_str($song),
                        'song_section_leader' => $this->db->escape_like_str($section_leader),
                        'start_time' => $this->db->escape_like_str($startTime),
                        'end_time' => $this->db->escape_like_str($endTime),
                        'room_number' => $this->db->escape_like_str($roomNumber)
                    );
                    $tableData2 = array(
                        'song_section_leader' => $this->db->escape_like_str($section_leader),
                    );
                    if ($this->db->insert('Choir_routine', $tableData) && $this->db->update('Choir_song', $tableData2, array('Choir_id' => $Choir_id, 'songtle' => $song))) {
                        $data['ChoirTile'] = $ChoirTitle;
                        $data['Choir_id'] = $Choir_id;
                        $data['day'] = $this->common->getAllData('config_week_day');
                        $data['song'] = $this->common->getWhere('Choir_song', 'Choir_id', $Choir_id);
                        $data['section_leader'] = $this->common->getAllData('section_leaders_info');
                        $this->load->view('temp/header');
                        $this->load->view('addChoirRoutin', $data);
                        $this->load->view('temp/footer');
                    }
                } else {
                    $data['ChoirTile'] = $ChoirTitle;
                    $data['Choir_id'] = $Choir_id;
                    $data['day'] = $this->common->getAllData('config_week_day');
                    $data['song'] = $this->common->getWhere('Choir_song', 'Choir_id', $Choir_id);
                    $data['section_leader'] = $this->common->getAllData('section_leaders_info');
                    $this->load->view('temp/header');
                    $this->load->view('addChoirRoutin', $data);
                    $this->load->view('temp/footer');
                }
            }
        }
        //if admin do not set section for any Choir then bellow [else{ condition]  will execute ***(Start)***
        else {
            if ($this->input->post('submit2', TRUE)) {
                $day = $this->input->post('day', TRUE);
                $song = $this->input->post('song', TRUE);
                $section_leader = $this->input->post('section_leader', TRUE);
                $startTime = $this->input->post('startTime', TRUE);
                $endTime = $this->input->post('endTime', TRUE);
                $roomNumber = $this->input->post('roomNumber', TRUE);
                $tableData = array(
                    'Choir_id' => $this->db->escape_like_str($Choir_id),
                    'day_title' => $this->db->escape_like_str($day),
                    'song' => $this->db->escape_like_str($song),
                    'song_section_leader' => $this->db->escape_like_str($section_leader),
                    'start_time' => $this->db->escape_like_str($startTime),
                    'end_time' => $this->db->escape_like_str($endTime),
                    'room_number' => $this->db->escape_like_str($roomNumber)
                );
                $tableData2 = array(
                    'song_section_leader' => $this->db->escape_like_str($section_leader),
                );
                //$this->db->where(array('Choir_title' => $ChoirTitle,'song_title' =>$song));
                if ($this->db->insert('Choir_routine', $tableData) && $this->db->update('Choir_song', $tableData2, array('Choir_id' => $Choir_id, 'song_title' => $song))) {
                    $data['ChoirTile'] = $ChoirTitle;
                    $data['Choir_id'] = $Choir_id;
                    $data['day'] = $this->common->getAllData('config_week_day');
                    $data['song'] = $this->common->getWhere('Choir_song', 'Choir_id', $Choir_id);
                    $data['section_leader'] = $this->common->getAllData('section_leaders_info');
                    $this->load->view('temp/header');
                    $this->load->view('addChoirRoutin', $data);
                    $this->load->view('temp/footer');
                }
            } else {
                $data['ChoirTile'] = $ChoirTitle;
                $data['Choir_id'] = $Choir_id;
                $data['day'] = $this->common->getAllData('config_week_day');
                $data['song'] = $this->common->getWhere('Choir_song', 'Choir_id', $Choir_id);
                $data['section_leader'] = $this->common->getAllData('section_leaders_info');
                $this->load->view('temp/header');
                $this->load->view('addChoirRoutin', $data);
                $this->load->view('temp/footer');
            }
        }
    }

    //This function gives us Choir section and Choir info.
    public function ajaxChoirInfo() {
        $Choir_id = $this->input->get('q');
        $query = $this->common->getWhere('Choir', 'id', $Choir_id);
        foreach ($query as $row) {
            $data = $row;
        }
        echo '<input type="hidden" name="Choir_title" value="' . $data['id'] . '">';
        if (!empty($data['section'])) {
            $section = $data['section'];
            $sectionArray = explode(",", $section);
            echo '<div class="form-group">
                        <label class="col-md-3 control-label">'.lang('clasc_3').' <span class="requiredStar"> * </span></label>
                        <div class="col-md-6">
                            <select name="section" class="form-control">
                                <option value="all">'.lang('clasc_4').'</option>';
            foreach ($sectionArray as $sec) {
                echo '<option value="' . $sec . '">' . $sec . '</option>';
            }
            echo '</select></div>
                    </div>';
        } else {
            echo '<div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-6">
                        <div class="alert alert-warning">
                                <strong>'.lang('clasc_5').'</strong> '.lang('clasc_6').'
                        </div></div></div>';
        }
    }
    //This function check Choir code data type and leanth
    public function ajaxChoirCodeInfo() {
        $ChoirCode = $this->input->get('q');
        if ($ChoirCode <= 99) {
            if ($this->Choirmodel->ChoirCodeCheck($ChoirCode) == TRUE) {
                echo '<input type="hidden" value="' . $ChoirCode . '" name="Choir_code">';
            } else {
                echo ''.lang('clasc_7').' " ' . $ChoirCode . ' " '.lang('clasc_8');
            }
        } else {
            echo lang('clasc_9');
        }
    }
    //This function gives a view for serlect Choir routine
    public function selectAllRoutine() {
        $data['ChoirTile'] = $this->common->getAllData('Choir');
        $data['day'] = $this->common->getAllData('config_week_day');
        $this->load->view('temp/header');
        $this->load->view('selectAllRoutine', $data);
        $this->load->view('temp/footer');
    }
    //This function gives a Choir routine after selecting a Choir
    public function allChoirRoutine() {
        if ($this->input->post('submit', TRUE)) {
            $Choir_id = $this->input->post('Choir', TRUE);
            $data['Choir_id'] = $Choir_id;
            $data['day'] = $this->common->getAllData('config_week_day');
            $data['song'] = $this->common->getWhere('Choir_song', 'Choir_id', $Choir_id);
            $data['section_leader'] = $this->common->getAllData('section_leaders_info');
            $this->load->view('temp/header');
            $this->load->view('viewRoutine', $data);
            $this->load->view('temp/footer');
        }
    }
    //By this function edit routine previous information 
    public function editRoutine() {
        $routinChoirId = $this->input->get('id', TRUE);
        $Choir_id = $this->input->get('Choir', TRUE);
        if ($this->input->post('update', TRUE)) {
            $day = $this->input->post('day', TRUE);
            $song = $this->input->post('song', TRUE);
            $section_leader = $this->input->post('section_leader', TRUE);
            $startTime = $this->input->post('startTime', TRUE);
            $endTime = $this->input->post('endTime', TRUE);
            $roomNumber = $this->input->post('roomNumber', TRUE);
            $tableData = array(
                'day_title' => $this->db->escape_like_str($day),
                'song' => $this->db->escape_like_str($song),
                'song_section_leader' => $this->db->escape_like_str($section_leader),
                'start_time' => $this->db->escape_like_str($startTime),
                'end_time' => $this->db->escape_like_str($endTime),
                'room_number' => $this->db->escape_like_str($roomNumber)
            );
            $this->db->where('id', $routinChoirId);
            if ($this->db->update('Choir_routine', $tableData)) {
                $data['Choir_id'] = $Choir_id;
                $data['day'] = $this->common->getAllData('config_week_day');
                $data['song'] = $this->common->getWhere('Choir_song', 'Choir_id', $Choir_id);
                $data['section_leader'] = $this->common->getAllData('section_leaders_info');
                $this->load->view('temp/header');
                $this->load->view('viewRoutine', $data);
                $this->load->view('temp/footer');
            }
        } else {
            $data['Choir_id'] = $Choir_id;
            $data['day'] = $this->common->getAllData('config_week_day');
            $data['song'] = $this->common->getWhere('Choir_song', 'Choir_id', $Choir_id);
            $data['previousRoutin'] = $this->common->getWhere('Choir_routine', 'id', $routinChoirId);
            $data['section_leader'] = $this->common->getAllData('section_leaders_info');
            $this->load->view('temp/header');
            $this->load->view('editRoutine', $data);
            $this->load->view('temp/footer');
        }
    }
    //By this function we can delet a Choir routine
    public function deleteRoutine() {
        $routinChoirId = $this->input->get('id');
        $Choir_id = $this->input->get('Choir_id');
        if ($this->db->delete('Choir_routine', array('id' => $routinChoirId))) {
            $data['Choir_id'] = $Choir_id;
            $data['day'] = $this->common->getAllData('config_week_day');
            $data['song'] = $this->common->getWhere('Choir_song', 'Choir_id', $Choir_id);
            $data['section_leader'] = $this->common->getAllData('section_leaders_info');
            $data['message'] = '<div class="alert alert-warning alert-dismissable">
								<button aria-hidden="true" data-dismiss="alert" class="close" type="button"></button>
								<strong>'.lang('clasc_10').'</strong> '.lang('clasc_11').'
							</div>';
            $this->load->view('temp/header');
            $this->load->view('viewRoutine', $data);
            $this->load->view('temp/footer');
        }
    }
    //This function will show Choir_member's and section_trainer's own Choir routine
    public function ownChoirRoutin() {
        $data = array();
        $userId = $this->input->get('uisd');
        $query = $this->db->query("SELECT Choir_id FROM Choir_member_info WHERE user_id='$userId'");
        foreach ($query->result_array() as $row) {
            $Choir_id = $row['Choir_id'];
        }
        $data['Choir_id'] = $Choir_id;
        $data['day'] = $this->common->getAllData('config_week_day');
        $data['song'] = $this->common->getWhere('Choir_song', 'Choir_id', $Choir_id);
        $data['section_leader'] = $this->common->getAllData('section_leaders_info');
        $this->load->view('temp/header');
        $this->load->view('viewRoutine', $data);
        $this->load->view('temp/footer');
    }
    //This function gives us Choir section and Choir info.
    public function ajaxpromotion() {
        $ChoirTitle = $this->input->get('q');
        $query = $this->common->getWhere('Choir', 'Choir_title', $ChoirTitle);
        foreach ($query as $row) {
            $data = $row;
        }
        echo '<input type="hidden" name="Choir" value="' . $ChoirTitle . '">';
        if (!empty($data['section'])) {
            $section = $data['section'];
            $sectionArray = explode(",", $section);
            $i = 0;
            foreach ($sectionArray as $se) {
                $i++;
            }
            for ($a = 1; $a <= $i; $a++) {
                echo '<div class="form-group">
                        <label class="col-md-3 control-label">'.lang('clasc_3').' ' . $a . '<span class="requiredStar"> * </span></label>
                        <div class="col-md-6">
                            <select name="section_' . $a . '" class="form-control" data-validation="required" data-validation-error-msg="">
                                <option value="">'.lang('select').'</option>';
                foreach ($sectionArray as $sec) {
                    echo '<option value="' . $sec . '">' . $sec . '</option>';
                }
                echo '</select></div></div>';
            }
            $b = $a - 1;
            echo '<input type="hidden" name="sectionAmount" value="' . $b . '">';
        } else {
            echo '<div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-6">
                        <div class="alert alert-warning">
                                <strong>'.lang('clasc_5').'</strong> '.lang('clasc_6').'
                        </div></div></div>';
        }
    }
    //This function will work for promotion 
    public function promotion() {
        if ($this->input->post('submit', TRUE)) {
            $ChoirId = $this->input->post('Choir', TRUE);
            if ($this->Choirmodel->chFiExRe($ChoirId)) {
                $rehearsalId = $this->Choirmodel->chFiExRe($ChoirId);
                $this->Choirmodel->meritList($rehearsalId);
                $nextChoir_id = $this->input->post('nextChoir', TRUE);
                $query = $this->db->query("SELECT Choir_member_id,status,maride_list FROM final_result WHERE rehearsal_id='$rehearsalId'");
                $i = 1;
                $sm = 1;
                foreach ($query->result_array() as $row) {
                    $Choir_memberId = $row['Choir_member_id'];
                    $status = $row['status'];
                    $newRoll = $row['maride_list'];
                    //Here is chacking this Choir_member is pass the rehearsal or not.
                    if ($status == 'Pass') {
                        $section = '';
                        $sectionCap = $this->Choirmodel->sectionCap($ChoirId);
                        $sectionCap2 = $sectionCap * 2;
                        $sectionCap3 = $sectionCap * 3;
                        $sectionCap4 = $sectionCap * 4;
                        $sectionCap5 = $sectionCap * 5;
                        if ($i <= $sectionCap) {
                            $section = $this->input->post('section_1', TRUE);
                        } elseif ($i > $sectionCap && $i <= $sectionCap2) {
                            $section = $this->input->post('section_2', TRUE);
                        } elseif ($i > $sectionCap2 && $i <= $sectionCap3) {
                            $section = $this->input->post('section_3', TRUE);
                        } elseif ($i > $sectionCap3 && $i <= $sectionCap4) {
                            $section = $this->input->post('section_4', TRUE);
                        } elseif ($i > $sectionCap4 && $i <= $sectionCap5) {
                            $section = $this->input->post('section_5', TRUE);
                        }
                        $arrayChoirStud = array(
                            'year' => $this->db->escape_like_str($this->input->post('nextYear', TRUE)),
                            'roll_number' => $this->db->escape_like_str($newRoll),
                            'Choir_id' => $this->db->escape_like_str($nextChoir_id),
                            'Choir_title' => $this->db->escape_like_str($this->common->Choir_title($nextChoir_id)),
                            'section' => $this->db->escape_like_str($section),
                            'attendance_percentices_daily' => $this->db->escape_like_str(0),
                        );
                        $this->db->where('Choir_member_id', $Choir_memberId);
                        if ($this->db->update('Choir_Choir_members', $arrayChoirStud)) {
                            $arrayChoirInfo = array(
                                'Choir_member_amount' => $this->db->escape_like_str($sm),
                                'attendance_percentices_daily' => $this->db->escape_like_str(0),
                                'attend_percentise_yearly' => $this->db->escape_like_str(0)
                            );
                            $this->db->where('id', $nextChoir_id);
                            $this->db->update('Choir', $arrayChoirInfo);

                            $arrayDormiSeat = array(
                                'Choir' => $this->db->escape_like_str($nextChoir_id),
                                'roll_number' => $this->db->escape_like_str($newRoll)
                            );
                            $this->db->where('Choir', $ChoirTitle);
                            $this->db->update('concert_seat', $arrayDormiSeat);
                            $arraySection_trainersInfo = array(
                                'Choir_id' => $this->db->escape_like_str($nextChoir_id)
                            );
                            $this->db->where('Choir_member_id', $Choir_memberId);
                            $this->db->update('section_trainers_info', $arraySection_trainersInfo);
                            $arrrayStudInfo = array(
                                'year' => $this->db->escape_like_str($this->input->post('nextYear', TRUE)),
                                'roll_number' => $this->db->escape_like_str($newRoll),
                                'Choir_id' => $this->db->escape_like_str($nextChoir_id),
                            );
                            $this->db->where('Choir_member_id', $Choir_memberId);
                            $this->db->update('Choir_member_info', $arrrayStudInfo);
                        }
                        $sm++;
                    }
                    $i++;
                }
                $data['message'] = lang('clasc_12');
                $data['ChoirTile'] = $this->common->getAllData('Choir');
                $this->load->view('temp/header');
                $this->load->view('promotion', $data);
                $this->load->view('temp/footer');
            } else {
                $data['message'] = lang('clasc_13');
                $data['ChoirTile'] = $this->common->getAllData('Choir');
                $this->load->view('temp/header');
                $this->load->view('promotion', $data);
                $this->load->view('temp/footer');
            }
        } else {
            $data['ChoirTile'] = $this->common->getAllData('Choir');
            $this->load->view('temp/header');
            $this->load->view('promotion', $data);
            $this->load->view('temp/footer');
        }
    }
}
