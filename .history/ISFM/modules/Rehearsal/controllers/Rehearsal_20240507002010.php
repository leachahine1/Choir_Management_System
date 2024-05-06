<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Rehearsal extends MX_Controller {

    /**
     * This controller is using for 
     *
     * Maps to the following URL
     * 		http://rehearsalple.com/index.php/rehearsal
     * 	- or -  
     * 		http://rehearsalple.com/index.php/rehearsal/<method_name>
     */
    function __construct() {
        parent::__construct();
        $this->lang->load('auth');
        $this->load->model('rehearsalmodel');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
    }
    //This function load all rehearsal grade and point
    public function rehearsalGread() {
        $data['grade'] = $this->common->getAllData('rehearsal_grade');
        $this->load->view('temp/header');
        $this->load->view('rehearsalGread', $data);
        $this->load->view('temp/footer');
    }
    //THis function add new rehearsal grade
    public function addRehearsalGread() {
        if ($this->input->post('submit', TRUE)) {
            $gradeName = $this->input->post('gradeName', TRUE);
            $gradePoint = $this->input->post('gradePoint', TRUE);
            $numberFrom = $this->input->post('numberFrom', TRUE);
            $nameTo = $this->input->post('nameTo', TRUE);

            $data = array(
                'grade_name' => $this->db->escape_like_str($gradeName),
                'point' => $this->db->escape_like_str($gradePoint),
                'number_form' => $this->db->escape_like_str($numberFrom),
                'number_to' => $this->db->escape_like_str($nameTo)
            );
            $this->db->insert('rehearsal_grade', $data);

            redirect('rehearsal/rehearsalGread', 'refresh');
        } else {
            $this->load->view('temp/header');
            $this->load->view('addRehearsalGrade');
            $this->load->view('temp/footer');
        }
    }
    //This function will edit rehearsal grade and point
    public function editGrade() {
        $id = $this->input->get('id');
        if ($this->input->post('submit', TRUE)) {
            $gradeName = $this->input->post('gradeName', TRUE);
            $gradePoint = $this->input->post('gradePoint', TRUE);
            $numberFrom = $this->input->post('numberFrom', TRUE);
            $nameTo = $this->input->post('nameTo', TRUE);

            $editData = array(
                'grade_name' => $this->db->escape_like_str($gradeName),
                'point' => $this->db->escape_like_str($gradePoint),
                'number_form' => $this->db->escape_like_str($numberFrom),
                'number_to' => $this->db->escape_like_str($nameTo)
            );

            $this->db->where('id', $id);
            if ($this->db->update('rehearsal_grade', $editData)) {
                redirect('rehearsal/rehearsalGread', 'refresh');
            }
        } else {
            $data['gradInfo'] = $this->common->getWhere('rehearsal_grade', 'id', $id);
            $this->load->view('temp/header');
            $this->load->view('editGrade', $data);
            $this->load->view('temp/footer');
        }
    }
    //This function can delete rehearsal grade in this system
    public function deleteGrade() {
        $id = $this->input->get('id');
        if ($this->db->delete('rehearsal_grade', array('id' => $id))) {
            redirect('rehearsal/rehearsalGread', 'refresh');
        }
    }
    //This function is using for decleration new rehearsal for nay class.
    public function addRehearsal() {
        $data['s_Choir'] = $this->common->getAllData('Choir');
        if ($this->input->post('submit', TRUE)) {
            $rehearsalTitle = $this->input->post('rehearsalTitle', TRUE);
            $startDate = $this->input->post('startDate', TRUE);
            $Choir_id = $this->input->post('Choir_id', TRUE);
            $totleTime = $this->input->post('totleTime', TRUE);
            $rehearsalInfo = array(
                'year' => $this->db->escape_like_str(date('Y')),
                'rehearsal_title' => $this->db->escape_like_str($rehearsalTitle),
                'start_date' => $this->db->escape_like_str($startDate),
                'Choir_id' => $this->db->escape_like_str($Choir_id),
                'total_time' => $this->db->escape_like_str($totleTime),
                'publish' => $this->db->escape_like_str('Not Publish'),
                'final' => $this->db->escape_like_str($this->input->post('final', TRUE)),
                'status' => $this->db->escape_like_str('NoResult')
            );
            //Here is adding an rehearsal information into database
            if ($this->db->insert('add_rehearsal', $rehearsalInfo)) {
                $data['successMessage'] = '<div class="alert alert-success">
                                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"></button>
                                                <strong>' . lang('success') . '</strong> ' . lang('exac_1') . '" ' . $rehearsalTitle . ' " ' . lang('exac_2') . ' "' . $this->common->Choir_title($Choir_id) . '" ' . lang('exac_3') . '
                                        </div>';
                $data['rehearsalInfo'] = $this->common->getAllData('add_rehearsal');
                $data['song'] = $this->common->getWhere('Choir_song', 'Choir_id', $Choir_id);
                $data['weeklyDay'] = $this->common->getAllData('config_week_day');
                $this->load->view('temp/header');
                $this->load->view('addRutinSong', $data);
                $this->load->view('temp/footer');
            }
        } else {
            $this->load->view('temp/header');
            $this->load->view('addRehearsalRutine', $data);
            $this->load->view('temp/footer');
        }
    }
    //This function will complete an rehearsal routine after decletration that rehearsal.
    public function completRehearsalRoutin() {
        if ($this->input->post('submit', TRUE)) {
            $rehearsalId = $this->input->post('rehearsalId', TRUE);
            //this is the 1st song's informations for this rehearsal rutine
            if ($this->input->post('rehearsalSunjectFild', TRUE)) {
                $rehearsalDate = $this->input->post('rehearsalDate', TRUE);
                $song = $this->input->post('song', TRUE);
                $songCode = $this->input->post('songCode', TRUE);
                $romeNo = $this->input->post('romeNo', TRUE);
                $starTima = $this->input->post('starTima', TRUE);
                $endTima = $this->input->post('endTima', TRUE);
                $rehearsalShift = $this->input->post('rehearsalShift', TRUE);
                $routine = array(
                    'rehearsal_id' => $this->db->escape_like_str($rehearsalId),
                    'rehearsal_date' => $this->db->escape_like_str($rehearsalDate),
                    'rehearsal_song' => $this->db->escape_like_str($song),
                    'song_code' => $this->db->escape_like_str($songCode),
                    'rome_number' => $this->db->escape_like_str($romeNo),
                    'start_time' => $this->db->escape_like_str($starTima),
                    'end_time' => $this->db->escape_like_str($endTima),
                    'rehearsal_shift' => $this->db->escape_like_str($rehearsalShift),
                    'status' => $this->db->escape_like_str('NoResult')
                );
                //insert this song information into the database.
                $this->db->insert('rehearsal_routine', $routine);
            }
            //this is the 2nd song's informations for this rehearsal rutine
            if ($this->input->post('rehearsalSunjectFild_2', TRUE)) {
                $rehearsalDate = $this->input->post('rehearsalDate_2', TRUE);
                $song = $this->input->post('song_2', TRUE);
                $songCode = $this->input->post('song', TRUE);
                $romeNo = $this->input->post('romeNo_2', TRUE);
                $starTima = $this->input->post('starTima_2', TRUE);
                $endTima = $this->input->post('endTima_2', TRUE);
                $rehearsalShift = $this->input->post('rehearsalShift_2', TRUE);
                $routine = array(
                    'rehearsal_id' => $this->db->escape_like_str($rehearsalId),
                    'rehearsal_date' => $this->db->escape_like_str($rehearsalDate),
                    'rehearsal_song' => $this->db->escape_like_str($song),
                    'song_code' => $this->db->escape_like_str($songCode),
                    'rome_number' => $this->db->escape_like_str($romeNo),
                    'start_time' => $this->db->escape_like_str($starTima),
                    'end_time' => $this->db->escape_like_str($endTima),
                    'rehearsal_shift' => $this->db->escape_like_str($rehearsalShift),
                    'status' => $this->db->escape_like_str('NoResult')
                );
                //insert this song information into the database.
                $this->db->insert('rehearsal_routine', $routine);
            }
            //this is the 3rd song's informations for this rehearsal rutine
            if ($this->input->post('rehearsalSunjectFild_3', TRUE)) {
                $rehearsalDate = $this->input->post('rehearsalDate_3', TRUE);
                $song = $this->input->post('song_3', TRUE);
                $songe = $this->input->post('songCode_3', TRUE);
                $romeNo = $this->input->post('romeNo_3', TRUE);
                $starTima = $this->input->post('starTima_3', TRUE);
                $endTima = $this->input->post('endTima_3', TRUE);
                $rehearsalShift = $this->input->post('rehearsalShift_3', TRUE);
                $routine = array(
                    'rehearsal_id' => $this->db->escape_like_str($rehearsalId),
                    'rehearsal_date' => $this->db->escape_like_str($rehearsalDate),
                    'rehearsal_song' => $this->db->escape_like_str($song),
                    'song_code' => $this->db->escape_like_str($songCode),
                    'rome_number' => $this->db->escape_like_str($romeNo),
                    'start_time' => $this->db->escape_like_str($starTima),
                    'end_time' => $this->db->escape_like_str($endTima),
                    'rehearsal_shift' => $this->db->escape_like_str($rehearsalShift),
                    'status' => $this->db->escape_like_str('NoResult')
                );
                //insert this song information into the database.
                $this->db->insert('rehearsal_routine', $routine);
            }
            //this is the 4th song's informations for this rehearsal rutine
            if ($this->input->post('rehearsalSunjectFild_4', TRUE)) {
                $rehearsalDate = $this->input->post('rehearsalDate_4', TRUE);
                $song = $this->input->post('song_4', TRUE);
                $songCode = $this->input->post('songCode_4', TRUE);
                $romeNo = $this->input->post('romeNo_4', TRUE);
                $starTima = $this->input->post('starTima_4', TRUE);
                $endTima = $this->input->post('endTima_4', TRUE);
                $rehearsalShift = $this->input->post('rehearsalShift_4', TRUE);
                $routine = array(
                    'rehearsal_id' => $this->db->escape_like_str($rehearsalId),
                    'rehearsal_date' => $this->db->escape_like_str($rehearsalDate),
                    'rehearsal_song' => $this->db->escape_like_str($song),
                    'song_code' => $this->db->escape_like_str($songCode),
                    'rome_number' => $this->db->escape_like_str($romeNo),
                    'start_time' => $this->db->escape_like_str($starTima),
                    'end_time' => $this->db->escape_like_str($endTima),
                    'rehearsal_shift' => $this->db->escape_like_str($rehearsalShift),
                    'status' => $this->db->escape_like_str('NoResult')
                );
                //insert this song information into the database.
                $this->db->insert('rehearsal_routine', $routine);
            }
            //this is the 5th songinformations for this rehearsal rutine
            if ($this->input->post('rehearsalSunjectFild_5', TRUE)) {
                $rehearsalDate = $this->input->post('rehearsalDate_5', TRUE);
                $song = $this->input->post('song_5', TRUE);
                $songCode = $this->input->post('songCode_5', TRUE);
                $romeNo = $this->input->post('romeNo_5', TRUE);
                $starTima = $this->input->post('starTima_5', TRUE);
                $endTima = $this->input->post('endTima_5', TRUE);
                $rehearsalShift = $this->input->post('rehearsalShift_5', TRUE);
                $routine = array(
                    'rehearsal_id' => $this->db->escape_like_str($rehearsalId),
                    'rehearsal_date' => $this->db->escape_like_str($rehearsalDate),
                    'rehearsal_song' => $this->db->escape_like_str($song),
                    'song_code' => $this->db->escape_like_str($songCode),
                    'rome_number' => $this->db->escape_like_str($romeNo),
                    'start_time' => $this->db->escape_like_str($starTima),
                    'end_time' => $this->db->escape_like_str($endTima),
                    'rehearsal_shift' => $this->db->escape_like_str($rehearsalShift),
                    'status' => $this->db->escape_like_str('NoResult')
                );
                //insert this song information into the database.
                $this->db->insert('rehearsal_routine', $routine);
            }
            //this is the 6th song's informations for this rehearsal rutine
            if ($this->input->post('rehearsalSunjectFild_6', TRUE)) {
                $rehearsalDate = $this->input->post('rehearsalDate_6', TRUE);
                $song = $this->input->post('song_6', TRUE);
                $songCode = $this->input->post('songCode_6', TRUE);
                $romeNo = $this->input->post('romeNo_6', TRUE);
                $starTima = $this->input->post('starTima_6', TRUE);
                $endTima = $this->input->post('endTima_6', TRUE);
                $rehearsalShift = $this->input->post('rehearsalShift_6', TRUE);
                $routine = array(
                    'rehearsal_id' => $this->db->escape_like_str($rehearsalId),
                    'rehearsal_date' => $this->db->escape_like_str($rehearsalDate),
                    'rehearsal_song' => $this->db->escape_like_str($song),
                    'song_code' => $this->db->escape_like_str($song),
                    'rome_number' => $this->db->escape_like_str($romeNo),
                    'start_time' => $this->db->escape_like_str($starTima),
                    'end_time' => $this->db->escape_like_str($endTima),
                    'rehearsal_shift' => $this->db->escape_like_str($rehearsalShift),
                    'status' => $this->db->escape_like_str('NoResult')
                );
                //insert this song information into the database.
                $this->db->insert('rehearsal_routine', $routine);
            }
            //this is the 7th song's informations for this rehearsal rutine
            if ($this->input->post('rehearsalSunjectFild_7', TRUE)) {
                $rehearsalDate = $this->input->post('rehearsalDate_7', TRUE);
                $song = $this->input->post('song_7', TRUE);
                $songCode = $this->input->post('songCode_7', TRUE);
                $romeNo = $this->input->post('romeNo_7', TRUE);
                $starTima = $this->input->post('starTima_7', TRUE);
                $endTima = $this->input->post('endTima_7', TRUE);
                $rehearsalShift = $this->input->post('rehearsalShift_7', TRUE);
                $routine = array(
                    'rehearsal_id' => $this->db->escape_like_str($rehearsalId),
                    'rehearsal_date' => $this->db->escape_like_str($rehearsalDate),
                    'rehearsal_song' => $this->db->escape_like_str($song),
                    'song_code' => $this->db->escape_like_str($songCode),
                    'rome_number' => $this->db->escape_like_str($romeNo),
                    'start_time' => $this->db->escape_like_str($starTima),
                    'end_time' => $this->db->escape_like_str($endTima),
                    'rehearsal_shift' => $this->db->escape_like_str($rehearsalShift),
                    'status' => $this->db->escape_like_str('NoResult')
                );
                //insert this song information into the database.
                $this->db->insert('rehearsal_routine', $routine);
            }
            //this is the 8th song's informations for this rehearsal rutine
            if ($this->input->post('rehearsalSunjectFild_8', TRUE)) {
                $rehearsalDate = $this->input->post('rehearsalDate_8', TRUE);
                $song = $this->input->post('song_8', TRUE);
                $songCode = $this->input->post('songe_8', TRUE);
                $romeNo = $this->input->post('romeNo_8', TRUE);
                $starTima = $this->input->post('starTima_8', TRUE);
                $endTima = $this->input->post('endTima_8', TRUE);
                $rehearsalShift = $this->input->post('rehearsalShift_8', TRUE);
                $routine = array(
                    'rehearsal_id' => $this->db->escape_like_str($rehearsalId),
                    'rehearsal_date' => $this->db->escape_like_str($rehearsalDate),
                    'rehearsal_song' => $this->db->escape_like_str($song),
                    'song_code' => $this->db->escape_like_str($songCode),
                    'rome_number' => $this->db->escape_like_str($romeNo),
                    'start_time' => $this->db->escape_like_str($starTima),
                    'end_time' => $this->db->escape_like_str($endTima),
                    'rehearsal_shift' => $this->db->escape_like_str($rehearsalShift),
                    'status' => $this->db->escape_like_str('NoResult')
                );
                //insert this song information into the database.
                $this->db->insert('rehearsal_routine', $routine);
            }
            //this is the 9th song's informations for this rehearsal rutine
            if ($this->input->post('rehearsalSunjectFild_9', TRUE)) {
                $rehearsalDate = $this->input->post('rehearsalDate_9', TRUE);
                $song = $this->input->post('song_9', TRUE);
                $songCode = $this->input->post('songCode_9', TRUE);
                $romeNo = $this->input->post('romeNo_9', TRUE);
                $starTima = $this->input->post('starTima_9', TRUE);
                $endTima = $this->input->post('endTima_9', TRUE);
                $rehearsalShift = $this->input->post('rehearsalShift_9', TRUE);
                $routine = array(
                    'rehearsal_id' => $this->db->escape_like_str($rehearsalId),
                    'rehearsal_date' => $this->db->escape_like_str($rehearsalDate),
                    'rehearsal_song' => $this->db->escape_like_str($song),
                    'song_code' => $this->db->escape_like_str($songCode),
                    'rome_number' => $this->db->escape_like_str($romeNo),
                    'start_time' => $this->db->escape_like_str($starTima),
                    'end_time' => $this->db->escape_like_str($endTima),
                    'rehearsal_shift' => $this->db->escape_like_str($rehearsalShift),
                    'status' => $this->db->escape_like_str('NoResult')
                );
                //insert this song information into the database.
                $this->db->insert('rehearsal_routine', $routine);
            }
            //this is the 10th song's informations for this rehearsal rutine
            if ($this->input->post('rehearsalSunjectFild_10', TRUE)) {
                $rehearsalDate = $this->input->post('rehearsalDate_10', TRUE);
                $song = $this->input->post('song_10', TRUE);
                $songCode = $this->input->post('songCode_10', TRUE);
                $romeNo = $this->input->post('romeNo_10', TRUE);
                $starTima = $this->input->post('starTima_10', TRUE);
                $endTima = $this->input->post('endTima_10', TRUE);
                $rehearsalShift = $this->input->post('rehearsalShift_10', TRUE);
                $routine = array(
                    'rehearsal_id' => $this->db->escape_like_str($rehearsalId),
                    'rehearsal_date' => $this->db->escape_like_str($rehearsalDate),
                    'rehearsal_song' => $this->db->escape_like_str($song),
                    'song_code' => $this->db->escape_like_str($songCode),
                    'rome_number' => $this->db->escape_like_str($romeNo),
                    'start_time' => $this->db->escape_like_str($starTima),
                    'end_time' => $this->db->escape_like_str($endTima),
                    'rehearsal_shift' => $this->db->escape_like_str($rehearsalShift),
                    'status' => $this->db->escape_like_str('NoResult')
                );
                //insert this song information into the database.
                $this->db->insert('rehearsal_routine', $routine);
            }
            //this is the 11th song's informations for this rehearsal rutine
            if ($this->input->post('rehearsalSunjectFild_11', TRUE)) {
                $rehearsalDate = $this->input->post('rehearsalDate_11', TRUE);
                $song = $this->input->post('song_11', TRUE);
                $songCode = $this->input->post('songCode_11', TRUE);
                $romeNo = $this->input->post('romeNo_11', TRUE);
                $starTima = $this->input->post('starTima_11', TRUE);
                $endTima = $this->input->post('endTima_11', TRUE);
                $rehearsalShift = $this->input->post('rehearsalShift_11', TRUE);
                $routine = array(
                    'rehearsal_id' => $this->db->escape_like_str($rehearsalId),
                    'rehearsal_date' => $this->db->escape_like_str($rehearsalDate),
                    'rehearsal_song' => $this->db->escape_like_str($song),
                    'song_code' => $this->db->escape_like_str($songCode),
                    'rome_number' => $this->db->escape_like_str($romeNo),
                    'start_time' => $this->db->escape_like_str($starTima),
                    'end_time' => $this->db->escape_like_str($endTima),
                    'rehearsal_shift' => $this->db->escape_like_str($rehearsalShift),
                    'status' => $this->db->escape_like_str('NoResult')
                );
                //insert this song information into the database.
                $this->db->insert('rehearsal_routine', $routine);
            }
            //this is the 12th song's informations for this rehearsal rutine
            if ($this->input->post('rehearsalSunjectFild_12', TRUE)) {
                $rehearsalDate = $this->input->post('rehearsalDate_12', TRUE);
                $song = $this->input->post('song_12', TRUE);
                $songCode = $this->input->post('songCode_12', TRUE);
                $romeNo = $this->input->post('romeNo_12', TRUE);
                $starTima = $this->input->post('starTima_12', TRUE);
                $endTima = $this->input->post('endTima_12', TRUE);
                $rehearsalShift = $this->input->post('rehearsalShift_12', TRUE);
                $routine = array(
                    'rehearsal_id' => $this->db->escape_like_str($rehearsalId),
                    'rehearsal_date' => $this->db->escape_like_str($rehearsalDate),
                    'rehearsal_song' => $this->db->escape_like_str($song),
                    'song_code' => $this->db->escape_like_str($songCode),
                    'rome_number' => $this->db->escape_like_str($romeNo),
                    'start_time' => $this->db->escape_like_str($starTima),
                    'end_time' => $this->db->escape_like_str($endTima),
                    'rehearsal_shift' => $this->db->escape_like_str($rehearsalShift),
                    'status' => $this->db->escape_like_str('NoResult')
                );
                //insert this song information into the database.
                $this->db->insert('rehearsal_routine', $routine);
            }
            //this is the 13th song's informations for this rehearsal rutine
            if ($this->input->post('rehearsalSunjectFild_13', TRUE)) {
                $rehearsalDate = $this->input->post('rehearsalDate_13', TRUE);
                $song = $this->input->post('song_13', TRUE);
                $songCode = $this->input->post('songCode_13', TRUE);
                $romeNo = $this->input->post('romeNo_13', TRUE);
                $starTima = $this->input->post('starTima_13', TRUE);
                $endTima = $this->input->post('endTima_13', TRUE);
                $rehearsalShift = $this->input->post('rehearsalShift_13', TRUE);
                $routine = array(
                    'rehearsal_id' => $this->db->escape_like_str($rehearsalId),
                    'rehearsal_date' => $this->db->escape_like_str($rehearsalDate),
                    'rehearsal_song' => $this->db->escape_like_str($song),
                    'song_code' => $this->db->escape_like_str($songCode),
                    'rome_number' => $this->db->escape_like_str($romeNo),
                    'start_time' => $this->db->escape_like_str($starTima),
                    'end_time' => $this->db->escape_like_str($endTima),
                    'rehearsal_shift' => $this->db->escape_like_str($rehearsalShift),
                    'status' => $this->db->escape_like_str('NoResult')
                );
                //insert this song information into the database.
                $this->db->insert('rehearsal_routine', $routine);
            }
            //this is the 14th song's informations for this rehearsal rutine
            if ($this->input->post('rehearsalSunjectFild_14', TRUE)) {
                $rehearsalDate = $this->input->post('rehearsalDate_14', TRUE);
                $song = $this->input->post('song_14', TRUE);
                $songCode = $this->input->post('songCode_14', TRUE);
                $romeNo = $this->input->post('romeNo_14', TRUE);
                $starTima = $this->input->post('starTima_14', TRUE);
                $endTima = $this->input->post('endTima_14', TRUE);
                $rehearsalShift = $this->input->post('rehearsalShift_14', TRUE);
                $routine = array(
                    'rehearsal_id' => $this->db->escape_like_str($rehearsalId),
                    'rehearsal_date' => $this->db->escape_like_str($rehearsalDate),
                    'rehearsal_song' => $this->db->escape_like_str($song),
                    'song_code' => $this->db->escape_like_str($songCode),
                    'rome_number' => $this->db->escape_like_str($romeNo),
                    'start_time' => $this->db->escape_like_str($starTima),
                    'end_time' => $this->db->escape_like_str($endTima),
                    'rehearsal_shift' => $this->db->escape_like_str($rehearsalShift),
                    'status' => $this->db->escape_like_str('NoResult')
                );
                //insert this song information into the database.
                $this->db->insert('rehearsal_routine', $routine);
            }
            //this is the 15th song's informations for this rehearsal rutine
            if ($this->input->post('rehearsalSunjectFild_15', TRUE)) {
                $rehearsalDate = $this->input->post('rehearsalDate_15', TRUE);
                $song = $this->input->post('song_15', TRUE);
                $songCode = $this->input->post('songCode_15', TRUE);
                $romeNo = $this->input->post('romeNo_15', TRUE);
                $starTima = $this->input->post('starTima_15', TRUE);
                $endTima = $this->input->post('endTima_15', TRUE);
                $rehearsalShift = $this->input->post('rehearsalShift_15', TRUE);
                $routine = array(
                    'rehearsal_id' => $this->db->escape_like_str($rehearsalId),
                    'rehearsal_date' => $this->db->escape_like_str($rehearsalDate),
                    'rehearsal_song' => $this->db->escape_like_str($song),
                    'song_code' => $this->db->escape_like_str($songCode),
                    'rome_number' => $this->db->escape_like_str($romeNo),
                    'start_time' => $this->db->escape_like_str($starTima),
                    'end_time' => $this->db->escape_like_str($endTima),
                    'rehearsal_shift' => $this->db->escape_like_str($rehearsalShift),
                    'status' => $this->db->escape_like_str('NoResult')
                );
                //insert this song information into the database.
                $this->db->insert('rehearsal_routine', $routine);
            }
            $data['rutineInfo'] = $this->common->getWhere('rehearsal_routine', 'rehearsal_id', $rehearsalId);
            $data['rehearsalInfo'] = $this->common->getWhere('add_rehearsal', 'id', $rehearsalId);
            $data['schoolName'] = $this->common->schoolName();
            $this->load->view('temp/header');
            $this->load->view('rutineSuccess', $data);
            $this->load->view('temp/footer');
        }
    }
    //This function can delete rehearsal and rehearsal routine
    public function deleteRehearsalAndRoutine() {
        $rehearsalId = $this->input->get('rehearsalId', TRUE);
        if ($this->db->delete('add_rehearsal', array('id' => $rehearsalId))) {
            if ($this->db->delete('rehearsal_routine', array('rehearsal_id' => $rehearsalId))) {
                redirect('rehearsal/allRehearsalRutine', 'refresh');
            }
        }
    }
    //This function will select that which rehearsal routine 
    public function allRehearsalRutine() {
        $data['s_Choir'] = $this->common->getAllData('Choir');
        $this->load->view('temp/header');
        $this->load->view('selectAllRoutine', $data);
        $this->load->view('temp/footer');
    }
    //This function load class's rehearsal title which is declard previously by class title.
    public function ajaxChoirRehearsal() {
        $Choir_id = $this->input->get('q');    
        // Using Active Record to prevent SQL injection
        $query = $this->db->select('*')
                          ->from('add_rehearsal')
                          ->where('Choir_id', $Choir_id)
                          ->get();
    
        $data = $query->result_array();
    
        // Check if we have any data returned
        if (!empty($data)) {
            echo '<div class="form-group">
                      <label class="col-md-3 control-label">' . lang('exac_4') . '<span class="requiredStar"> * </span></label>
                      <div class="col-md-6">
                          <select name="rehearsalId" class="form-control">';
            foreach ($data as $sec) {
                echo '<option value="' . $sec['id'] . '">' . $sec['rehearsal_title'] . '</option>';
            }
            echo '</select></div>
                  </div>';
        } else {
            echo '<div class="form-group">
                      <label class="col-md-3 control-label"></label>
                      <div class="col-md-6">
                          <div class="alert alert-warning">
                              <strong>' . lang('exac_info') . '</strong> ' . lang('exac_5') . '
                          </div></div></div>';
        }
    }
    
    //This function show a success message when an Rehearsal added and made this rehearsal routine fully, with full rutine.
    public function routinView() {
        if ($this->input->post('submit', TRUE) && $this->input->post('rehearsalId', TRUE)) {
            $rehearsalId = $this->input->post('rehearsalId', TRUE);
            $data['rutineInfo'] = $this->common->getWhere('rehearsal_routine', 'rehearsal_id', $rehearsalId);
            $data['rehearsalInfo'] = $this->common->getWhere('add_rehearsal', 'id', $rehearsalId);
            $data['schoolName'] = $this->common->schoolName();
            $this->load->view('temp/header');
            $this->load->view('rutineSuccess', $data);
            $this->load->view('temp/footer');
        } else {
            echo lang('exac_6');
        }
    }
    //This function is using for select class and Choir_members for rehearsal attendance.
    public function selectRehearsalAttendance() {
        $data['s_Choir'] = $this->common->getAllData('Choir');
        $this->load->view('temp/header');
        $this->load->view('selectRehearsalAttendance', $data);
        $this->load->view('temp/footer');
    }
    //This function is using for taking Choir_members by class title for rehearsal attendence
    public function rehearsalAttendance() {
        $date = date("d/m/Y");
        if ($this->input->post('submit', TRUE)) {
            $rehearsalId = $this->input->get('id');
            $rehearsalTitle = $this->rehearsalmodel->rehearsalTitle($rehearsalId);
            $rehearsalSong = $this->rehearsalmodel->rehearsalSong($rehearsalId, $date);
            //Whene submit the attendence information after takeing the attendence
            $i = $this->input->post('in_velu', TRUE);
            $Choir_id = $this->input->post('Choir_id', TRUE);
            for ($x = 1; $x <= $i; $x++) {
                $roll = $this->input->post("roll_$x", TRUE);
                $name = $this->input->post("Choir_memberName_$x", TRUE);
                $present = $this->input->post("action_$x", TRUE);
                $userId = $this->input->post("userId_$x", TRUE);
                $Choir_memberInfoId = $this->input->post("Choir_memberInfoId_$x", TRUE);
                $section = $this->input->post("section_$x", TRUE);
                $data = array(
                    'date' => $this->db->escape_like_str($date),
                    'rehearsal_title' => $this->db->escape_like_str($rehearsalTitle),
                    'rehearsal_song' => $this->db->escape_like_str($rehearsalSong),
                    'user_id' => $this->db->escape_like_str($userId),
                    'Choir_member_id' => $this->db->escape_like_str($Choir_memberInfoId),
                    'roll_no' => $this->db->escape_like_str($roll),
                    'Choir_id' => $this->db->escape_like_str($Choir_id),
                    'section' => $this->db->escape_like_str($section),
                    'attendance' => $this->db->escape_like_str($present),
                    'Choir_member_title' => $this->db->escape_like_str($name),
                );
                //insert the $data information into "daily_attendance" database.
                $this->db->insert('rehearsal_attendanc', $data);
            }
            //Whene Rehearsal Attendance was full compleate then lode this page
            $data['previerAttendance'] = $this->rehearsalmodel->previewAttendance($Choir_id, $rehearsalTitle, $rehearsalSong);
            print_r($data);
            $data['ChoirTitle'] = $this->common->Choir_title($Choir_id);
            $this->load->view('temp/header');
            $this->load->view('viewRehearsalAttendance', $data);
            $this->load->view('temp/footer');
        } else {
            $rehearsalId = $this->input->post('rehearsalId', TRUE);
            $rehearsalTitle = $this->rehearsalmodel->rehearsalTitle($rehearsalId);
            $Choir_id = $this->input->post('Choir', TRUE);
            
            $check = $this->rehearsalmodel->checkRehearsal($rehearsalId);
            if ($check == 'Have An Rehearsal') {
                //Here is loding Choir_member for rehearsal attendance.
                //Get here Choir_members and informations by class title.
                $queryData = array();
                $query = $this->db->get_where('Choir_Choir_members', array('Choir_id' => $Choir_id));
                foreach ($query->result_array() as $row) {
                    $queryData[] = $row;
                }$data['Choir_members'] = $queryData;
                $data['rehearsalId'] = $rehearsalId;
                $data['rehearsalTitle'] = $rehearsalTitle;
                $data['rehearsalSong'] = $this->rehearsalmodel->rehearsalSong($rehearsalId, $date);
                $data['ChoirTitle'] = $this->common->Choir_title($Choir_id);
                if (!empty($data['Choir_members'])) {
                    $this->load->view('temp/header');
                    $this->load->view('rehearsalAttendance', $data);
                    $this->load->view('temp/footer');
                } else {
                    echo 'has no any Choir_member.';
                }
            } elseif ($check == 'No Any Rehearsal') {
                // $info['ChoirTitle'] = $ChoirTitle;
                $this->load->view('temp/header');
                $this->load->view('attendanceFaild');
                $this->load->view('temp/footer');
            }
        }
    }
    //This function load's rehearsal attendance view
    public function viewRehearsalAttendance() {
        if ($this->input->post('submit', TRUE)) {
            $ChoirTitle = $this->input->post('Choir', TRUE);
            $rehearsalTitle = $this->input->post('rehearsalTitle', TRUE);
            $songTitle = $this->input->post('songTitle', TRUE);
            $data['ChoirTitle'] = $ChoirTitle;
            $data['previerAttendance'] = $this->rehearsalmodel->previewAttendance($ChoirTitle, $rehearsalTitle, $songTitle);
            $this->load->view('temp/header');
            $this->load->view('viewRehearsalAttendance', $data);
            $this->load->view('temp/footer');
        } else {
            $data['s_Choir'] = $this->common->getAllData('Choir');
            $this->load->view('temp/header');
            $this->load->view('allRehearsalAttendanceView', $data);
            $this->load->view('temp/footer');
        }
    }
    //This function is called by ajax from view
    public function ajaxAttendanceView() {
        $Choir_id = $this->input->get('q');
        $query = $this->db->query("SELECT * FROM add_rehearsal WHERE Choir_id=$Choir_id");
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        if (!empty($data)) {
            echo '<div class="form-group">
                        <label class="col-md-3 control-label">' . lang('exac_4') . '<span class="requiredStar"> * </span></label>
                        <div class="col-md-6">
                            <select name="rehearsalTitle" class="form-control">';
            foreach ($data as $sec) {
                echo '<option value="' . $sec['rehearsal_title'] . '">' . $sec['rehearsal_title'] . '</option>';
            }
            echo '</select></div>
                        </div>';
        } else {
            echo '<div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-6">
                        <div class="alert alert-warning">
                                <strong>' . lang('exac_info') . '</strong> ' . lang('exac_7') . '
                        </div></div></div>';
        }
        $song = $this->common->getWhere('Choir_song', 'Choir_id', $Choir_id);
        if (!empty($song)) {
            echo '<div class="form-group">
                        <label class="col-md-3 control-label">' . lang('exac_8') . ' <span class="requiredStar"> * </span></label>
                        <div class="col-md-6">
                            <select name="songTitle" class="form-control">';
            foreach ($song as $sub) {
                echo '<option value="' . $sub['song_title'] . '">' . $sub['song_title'] . '</option>';
            }
            echo '</select></div>
                        </div>';
        } else {
            echo '<div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-6">
                        <div class="alert alert-warning">
                                <strong>' . lang('exac_info') . '</strong> ' . lang('exac_9') . '
                        </div></div></div>';
        }
    }
    //The rehearsal attendance can edit by this function.
    public function editRehearsalAttendance() {
        $id = $this->input->get('id');

        if ($this->input->post('submit', TRUE)) {
            $updateInfo = array(
                'attendance' => $this->db->escape_like_str($this->input->post('action', TRUE))
            );
            $this->db->where('id', $id);
            if ($this->db->update('rehearsal_attendanc', $updateInfo)) {
                redirect('rehearsal/viewRehearsalAttendance', 'refresh');
            }
        }
        $data['rehearsalAttendanceInf'] = $this->common->getWhere('rehearsal_attendanc', 'id', $id);
        $this->load->view('temp/header');
        $this->load->view('editRehearsalAttendance', $data);
        $this->load->view('temp/footer');
    }
    //Here is first time select class for result.
    public function makingResult() {
        if ($this->input->post('submit', TRUE)) {
            $Choir_id = $this->input->post('Choir_id', TRUE);
            $data['Choir_id'] = $Choir_id;
            $data['rehearsalId'] = $this->input->post('rehearsalID', TRUE);
            $data['songTitle'] = $this->input->post('rehearsalSongTitle', TRUE);
            $data['rehearsalRUtinID'] = $this->input->post('subjRutID', TRUE);
            $data['section_leaderInfo'] = $this->rehearsalmodel->section_leaderInfo($this->input->post('section_leaderUserId', TRUE));
            $queryData = array();
            $query = $this->db->get_where('Choir_Choir_members', array('Choir_id' => $Choir_id));
            foreach ($query->result_array() as $row) {
                $queryData[] = $row;
            }
            $data['Choir_members'] = $queryData;
            $data['gread'] = $this->common->getAllData('rehearsal_grade');
            $this->load->view('temp/header');
            $this->load->view('makingResult', $data);
            $this->load->view('temp/footer');
        } else {
            $data['s_Choir'] = $this->rehearsalmodel->getChoirTitle();
            $this->load->view('temp/header');
            $this->load->view('selectChoirResult', $data);
            $this->load->view('temp/footer');
        }
    }
    //This function will take class and give the class rehearsal title and song
    public function ajaxChoirResult() {
        $Choir_id = $this->input->get('q');
        $data = $this->rehearsalmodel->rehearsalTitleRes($Choir_id);
        if (!empty($data)) {
            echo '<div class="form-group">
                        <label class="col-md-3 control-label">' . lang('exac_4') . ' <span class="requiredStar"> * </span></label>
                        <div class="col-md-6">
                            <select onchange="rehearsalSong(this.value)" name="rehearsalID" class="form-control" data-validation="required" data-validation-error-msg="">
                            <option value="">' . lang('select') . '</option>';
            foreach ($data as $sec) {
                echo '<option value="' . $sec['id'] . '">' . $sec['rehearsal_title'] . '</option>';
            }
            echo '</select></div>
                        </div><div id="ajaxResult_2"></div>';
        } else {
            echo '<div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-6">
                        <div class="alert alert-warning">
                                <strong>' . lang('exac_info') . '</strong> ' . lang('exac_10') . '
                        </div></div></div>';
        }
    }
    //This function will show via ajax rehearsal song which are not compleated result
    public function ajaxRehearsalSong() {
        $rehearsalID = $this->input->get('erid');
        $song = $this->rehearsalmodel->rehearsalResSong($rehearsalID);
        if (!empty($song)) {
            echo '<div class="form-group">
                        <label class="col-md-3 control-label">' . lang('exac_8') . ' <span class="requiredStar"> * </span></label>
                        <div class="col-md-6">
                            <select onchange="rehearsalSongTitle(this.value)" name="subjRutID" class="form-control" data-validation="required" data-validation-error-msg="">
                            <option value="">' . lang('select') . '</option>';
            foreach ($song as $sub) {
                echo '<option value="' . $sub['id'] . '">' . $sub['rehearsal_song'] . '</option>';
            }
            echo '</select></div>
                        </div><div id="ajaxResult_3"></div>';
        } else {
            echo '<div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-6">
                        <div class="alert alert-warning">
                                <strong>' . lang('exac_info') . '</strong> ' . lang('exac_11') . '
                        </div></div></div>';
        }
    }
    //This function will returan rehearsal song title 
    public function ajaxRehearsalSubTitle() {
        $rehearsalId = $this->input->get('erid');
        $query = $this->db->query("SELECT rehearsal_song FROM rehearsal_routine WHERE id='$rehearsalId'");
        foreach ($query->result_array() as $row) {
            $data = $row['rehearsal_song'];
            echo '<input type="hidden" name="rehearsalSongTitle" value="' . $row['rehearsal_song'] . '">';
        }
    }
    //This function will submit result from section_leader.
    public function submitResult() {
        $i = $this->input->post('ivalue', TRUE);
        $rehearsalID = $this->input->post('rehearsalId', TRUE);
        $rehearsalTitle = $this->rehearsalmodel->rehearsalTitle($rehearsalID);
        $rehearsalRuId = $this->input->post('rehearsalRutinID', TRUE);
        $rehearsalSong = $this->rehearsalmodel->rehearsalSongTitle($rehearsalRuId);
        $Choir_id = $this->input->post('Choir_id', TRUE);
        $section_leaderName = $this->input->post('section_leaderName', TRUE);
        //here is checking this song is optionakl or not
        $date = date('d/m/Y');
        for ($a = 1; $a <= $i; $a++) {
            $rollNumber = $this->input->post("rollNumber_$a", TRUE);
            $result = $this->input->post("result_$a", TRUE);
            $greadInfo = $this->input->post("gread_$a", TRUE);
            $grade = explode(",", $greadInfo);
            $resultInfo = array(
                'rehearsal_id' => $this->db->escape_like_str($rehearsalID),
                'rehearsal_title' => $this->db->escape_like_str($rehearsalTitle),
                'Choir_id' => $this->db->escape_like_str($Choir_id),
                'Choir_member_name' => $this->db->escape_like_str($this->input->post("Choir_memberTitle_$a", TRUE)),
                'Choir_member_id' => $this->db->escape_like_str($this->input->post("Choir_memberId_$a", TRUE)),
                'roll_number' => $this->db->escape_like_str($this->input->post("rollNumber_$a", TRUE)),
                'rehearsal_song' => $this->db->escape_like_str($rehearsalSong),
                'result' => $this->db->escape_like_str($this->input->post("result_$a", TRUE)),
                'mark' => $this->db->escape_like_str($this->input->post("totalMark_$a", TRUE)),
                'grade' => $this->db->escape_like_str($grade[0]),
                'point' => $this->db->escape_like_str($grade[1]),
            );
            $this->db->insert('result_shit', $resultInfo);
        }
        $submitInfo = array(
            'Choir_id' => $this->db->escape_like_str($Choir_id),
            'rehearsal_title' => $this->db->escape_like_str($rehearsalTitle),
            'rehearsal_id' => $this->db->escape_like_str($rehearsalID),
            'date' => $this->db->escape_like_str($date),
            'song' => $this->db->escape_like_str($rehearsalSong),
            'submited' => $this->db->escape_like_str(0),
            'section_leader' => $this->db->escape_like_str($section_leaderName),
        );
        $songStatus = array(
            'status' => $this->db->escape_like_str('Result')
        );
        $this->db->where('id', $rehearsalRuId);
        $this->db->update('rehearsal_routine', $songStatus);
        if ($this->db->insert('result_submition_info', $submitInfo)) {
            $data['rehearsalTitle'] = $rehearsalTitle;
            $data['rehearsalSong'] = $rehearsalSong;
            $data['section_leaderName'] = $section_leaderName;
            $data['Choir_id'] = $Choir_id;
            $this->load->view('temp/header');
            $this->load->view('submitMessage', $data);
            $this->load->view('temp/footer');
        }
    }
    //This function work only for admin.
    //He can view how many result shit was submited for aprove by admin.
    public function aproveShitView() {
        $data['shitList'] = $this->common->getWhere('result_submition_info', 'submited', 0);
        $data['ChoirAction'] = $this->common->getWhere('result_action', 'status', 'Not Complete');
        $this->load->view('temp/header');
        $this->load->view('aproveShitView', $data);
        $this->load->view('temp/footer');
    }
    //This function can exes only admin and he can edit and Approve rehearsal rtesult shit
    public function checkResultShit() {
        $id = $this->input->get('id', TRUE);
        $query = $this->common->getWhere('result_submition_info', 'id', $id);
        $rehearsalTitle = $query[0]['rehearsal_title'];
        $Choir_id = $query[0]['Choir_id'];
        $song = $query[0]['song'];
        $data['rehearsalId'] = $id;
        $data['rehearsalTitle'] = $query[0]['rehearsal_title'];
        $data['Choir_id'] = $Choir_id;
        $data['section_leader'] = $query[0]['section_leader'];
        $data['song'] = $query[0]['song'];
        $data['resultShit'] = $this->rehearsalmodel->checkResultShit($Choir_id, $rehearsalTitle, $song);
        $this->load->view('temp/header');
        $this->load->view('checkResultShit', $data);
        $this->load->view('temp/footer');
    }
    //This function will edit Choir_member's result,number and grade,point
    public function editResult() {
        $id = $this->input->get('id');
        if ($this->input->post('submit', TRUE)) {
            $updateData = array(
                'result' => $this->db->escape_like_str($this->input->post('result', TRUE)),
                'mark' => $this->db->escape_like_str($this->input->post('mark', TRUE)),
                'point' => $this->db->escape_like_str($this->input->post('point', TRUE)),
                'grade' => $this->db->escape_like_str($this->input->post('gread', TRUE))
            );
            $this->db->where('id', $id);
            if ($this->db->update('result_shit', $updateData)) {
                redirect('rehearsal/aproveShitView', 'refresh');
            }
        } else {
            $data['gread'] = $this->common->getAllData('rehearsal_grade');
            $data['previousResult'] = $this->common->getWhere('result_shit', 'id', $id);
            $this->load->view('temp/header');
            $this->load->view('editResult', $data);
            $this->load->view('temp/footer');
        }
    }
    //This function will approuve result shit which is sent from section_leader.
    public function approuveResultShit() {
        $id = $this->input->get('id');
        $data = array(
            'submited' => $this->db->escape_like_str(1)
        );
        $this->db->where('id', $id);
        if ($this->db->update('result_submition_info', $data)) {
            $query = $this->common->getWhere('result_submition_info', 'id', $id);
            foreach ($query as $row) {
                $rowInfo = $row;
            }
            $Choir_id = $rowInfo['Choir_id'];
            $rehearsalTitle = $rowInfo['rehearsal_title'];
            $rehearsalId = $rowInfo['rehearsal_id'];
            $song = $rowInfo['song'];
            $approuveSong = $this->rehearsalmodel->approuveSongAmount($Choir_id, $rehearsalTitle);
            $ChoirSong = $this->rehearsalmodel->ChoirSongAmount($Choir_id);
            //By this if conditation we are chacking that all songs result was submited or not
            //When all songs result is submited in that time insert the informations in "result_action" table then it will ready for final calculation.
            if ($approuveSong == $ChoirSong) {
                $actionArrayt = array(
                    'Choir_id' => $this->db->escape_like_str($Choir_id),
                    'rehearsal_title' => $this->db->escape_like_str($rehearsalTitle),
                    'rehearsal_id' => $this->db->escape_like_str($rehearsalId),
                    'status' => $this->db->escape_like_str('Not Complete')
                );
                if ($this->db->insert('result_action', $actionArrayt)) {
                    redirect('rehearsal/aproveShitView', 'refresh');
                }
            } else {
                redirect('rehearsal/aproveShitView', 'refresh');
            }
        }
    }
    //This function will make finalresult for class Choir_members
    public function finalResult() {
        $rehearsalActionId = $this->input->get('id');
        $Choir_id = $this->input->get('Choir');
        $rehearsalTitle = $this->input->get('rehearsal');
        $rehearsalId = $this->input->get('rehearsalId');
        //Here taking a Choir_members list by class title
        $Choir_memberQuery = $this->common->getWhere('Choir_Choir_members', 'Choir_id', $Choir_id);
        foreach ($Choir_memberQuery as $row) {
            $Choir_memberId = $row['Choir_member_id'];
            $absent = $this->rehearsalmodel->absent($Choir_memberId);
            if ($absent == 0) {
                $fail = $this->rehearsalmodel->fail($Choir_memberId);
                if ($fail == 0) {
                    $ChoirSong = $this->rehearsalmodel->ChoirSongAmount($Choir_id);
                    $finalPoint = $this->rehearsalmodel->pointAverage($Choir_memberId, $ChoirSong);
                    $gradeAverage = $this->rehearsalmodel->averageGrade($finalPoint);
                    $totalMark = $this->rehearsalmodel->totalMark($Choir_memberId);
                    $finalResultArray = array(
                        'Choir_id' => $this->db->escape_like_str($Choir_id),
                        'rehearsal_id' => $this->db->escape_like_str($rehearsalId),
                        'rehearsal_title' => $this->db->escape_like_str($rehearsalTitle),
                        'Choir_member_id' => $this->db->escape_like_str($Choir_memberId),
                        'Choir_member_name' => $this->db->escape_like_str($row['Choir_member_title']),
                        'final_grade' => $this->db->escape_like_str($gradeAverage),
                        'point' => $this->db->escape_like_str($finalPoint),
                        'total_mark' => $this->db->escape_like_str($totalMark),
                        'status' => $this->db->escape_like_str('Pass'),
                    );
                    $this->db->insert('final_result', $finalResultArray);
                } else {
                    $ChoirSong = $this->rehearsalmodel->ChoirSongAmount($Choir_id);
                    $pointAverage = $this->rehearsalmodel->pointAverage($Choir_memberId, $ChoirSong);
                    $gradeAverage = $this->rehearsalmodel->averageGrade($pointAverage);
                    $totalMark = $this->rehearsalmodel->totalMark($Choir_memberId);
                    $finalResultArray = array(
                        'Choir_id' => $this->db->escape_like_str($Choir_id),
                        'rehearsal_id' => $this->db->escape_like_str($rehearsalId),
                        'rehearsal_title' => $this->db->escape_like_str($rehearsalTitle),
                        'Choir_member_id' => $this->db->escape_like_str($Choir_memberId),
                        'Choir_member_name' => $this->db->escape_like_str($row['Choir_member_title']),
                        'final_grade' => $this->db->escape_like_str($gradeAverage),
                        'point' => $this->db->escape_like_str($pointAverage),
                        'total_mark' => $this->db->escape_like_str($totalMark),
                        'status' => $this->db->escape_like_str('Fail'),
                        'fail_amount' => $this->db->escape_like_str($fail)
                    );
                    $this->db->insert('final_result', $finalResultArray);
                }
            } else {
                $finalResultArray = array(
                    'Choir_id' => $this->db->escape_like_str($Choir_id),
                    'rehearsal_id' => $this->db->escape_like_str($rehearsalId),
                    'rehearsal_title' => $this->db->escape_like_str($rehearsalTitle),
                    'Choir_member_id' => $this->db->escape_like_str($Choir_memberId),
                    'Choir_member_name' => $this->db->escape_like_str($row['Choir_member_title']),
                    'final_grade' => $this->db->escape_like_str('--'),
                    'point' => $this->db->escape_like_str('--'),
                    'total_mark' => $this->db->escape_like_str('--'),
                    'status' => $this->db->escape_like_str('Absent'),
                    'fail_amount' => $this->db->escape_like_str('--')
                );
                $this->db->insert('final_result', $finalResultArray);
            }
        }
        $rehearsalActionArray = array(
            'status' => $this->db->escape_like_str('Complete'),
            'publish' => $this->db->escape_like_str('Not Publish')
        );
        $this->db->where('id', $rehearsalActionId);
        if ($this->db->update('result_action', $rehearsalActionArray)) {
            $data['message'] = '<br><div class="alert alert-success">
                                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"></button>
                                                <strong>' . lang('success') . '</strong> ' . lang('exac_12') . ' "' . $rehearsalTitle . '" ' . lang('exac_13') . ' "' . $this->common->Choir_title($Choir_id) . '"' . lang('exac_14') . '<br>
                                                <strong>' . lang('exac_info') . ' </strong>' . lang('exac_15') . '   
                                        </div>';
            $data['shitList'] = $this->common->getWhere('result_submition_info', 'submited', 0);
            $data['ChoirAction'] = $this->common->getWhere('result_action', 'status', 'Not Complete');
            $this->load->view('temp/header');
            $this->load->view('aproveShitView', $data);
            $this->load->view('temp/footer');
        }
    }
    //This function select class for results 
    public function selectResult() {
        $data['result'] = $this->rehearsalmodel->publish('Complete', 'Publish');
        $this->load->view('temp/header');
        $this->load->view('selectResult', $data);
        $this->load->view('temp/footer');
    }
    //This function will show details result in a class 
    public function fullResult() {
        $Choir_id = $this->input->get('Choir');
        $rehearsalTitle = $this->input->get('rehearsal');
        $data['result'] = $this->rehearsalmodel->finalResultShow($Choir_id, $rehearsalTitle);
        $data['Choir'] = $Choir_id;
        $data['rehearsalTitle'] = $rehearsalTitle;
        $this->load->view('temp/header');
        $this->load->view('fullResult', $data);
        $this->load->view('temp/footer');
    }
    //By this function admin can publish rehearsal result in day.
    public function publishResult() {
        $query = $this->rehearsalmodel->publish('Complete', 'Not Publish');
        foreach ($query as $row) {
            $id = $row['id'];
            $rehearsalTitle = $row['rehearsal_title'];
            $Choir_id = $row['Choir_id'];
            

            $array = array(
                'publish' => $this->db->escape_like_str('Publish')
            );
            $this->db->where('id', $id);
            if ($this->db->update('result_action', $array)) {
                $this->db->update('add_rehearsal', $array, array('rehearsal_title' => $this->db->escape_like_str($rehearsalTitle), 'Choir_id' => $this->db->escape_like_str($Choir_id)));
            }
        }
        redirect('rehearsal/selectResult', 'refresh');
    }
    //This function will select Choir_memberfor know mark shit
    public function selectChoirMarksheet() {
        if ($this->input->post('submit', TRUE)) {
            if ($this->input->post('rehearsalId', TRUE) && $this->input->post('Choir_memberId', TRUE)) {
                $Choir_id = $this->input->post('Choir_id', TRUE);
                $rehearsalId = $this->input->post('rehearsalId', TRUE);
                $Choir_memberId = $this->input->post('Choir_memberId', TRUE);
                $data['markshit'] = $this->rehearsalmodel->markshit($rehearsalId, $Choir_id, $Choir_memberId);
                $data['rehearsalTitle'] = $this->rehearsalmodel->rehearsalTitle($rehearsalId);
                $data['Choir_memberId'] = $Choir_memberId;
                $data['Choir_memberName'] = $this->input->post('Choir_memberTitle', TRUE);
                $this->load->view('temp/header');
                $this->load->view('marksheet', $data);
                $this->load->view('temp/footer');
            } else {
                echo lang('exac_16');
            }
        } else {
            $data['Choir'] = $this->common->getAllData('Choir');
            $this->load->view('temp/header');
            $this->load->view('selectChoirMarksheet', $data);
            $this->load->view('temp/footer');
        }
    }
    //This function will called by ajax from view for load class markshit
    public function ajaxChoirMarkshit() {
        $Choir_id = $this->input->get('q');
        $query = $this->rehearsalmodel->rehearsalTitleForMarkshit($Choir_id);
        foreach ($query as $row) {
            $data[] = $row;
        }
        if (!empty($data)) {
            echo '<div class="form-group">
                        <label class="col-md-3 control-label">' . lang('exac_4') . ' <span class="requiredStar"> * </span></label>
                        <div class="col-md-6">
                            <select name="rehearsalId" class="form-control">';
            foreach ($data as $sec) {
                echo '<option value="' . $sec['id'] . '">' . $sec['rehearsal_title'] . '</option>';
            }
            echo '</select></div>
                        </div>';
            $Choir_member = $this->common->getWhere('Choir_Choir_members', 'Choir_id', $Choir_id);
            if (!empty($Choir_member)) {
                echo '<div class="form-group">
                            <label class="col-md-3 control-label">' . lang('exac_17') . ' <span class="requiredStar"> * </span></label>
                            <div class="col-md-6">
                                <select name="Choir_memberId" class="form-control">';
                foreach ($Choir_member as $stu) {
                    echo '<option value="' . $stu['Choir_member_id'] . '">' . $stu['Choir_member_title'] . '</option>';
                }
                echo '</select></div>
                    <input type="hidden" name="Choir_memberTitle" value="' . $stu['Choir_member_title'] . '">
                            </div>';
            } else {
                echo '<div class="form-group">
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-6">
                            <div class="alert alert-warning">
                                    <strong>' . lang('exac_info') . '</strong> ' . lang('exac_9') . '
                            </div></div></div>';
            }
        } else {
            echo '<div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-6">
                        <div class="alert alert-warning">
                                <strong>' . lang('exac_info') . '</strong> ' . lang('exac_18') . '
                        </div></div></div>';
        }
    }
    //This function will select Choir_member's own marksheet
    public function sel_ow_ma() {
        if ($this->input->post('submit', TRUE)) {
            if ($this->input->post('rehearsalId', TRUE)) {
                $Choir_id = $this->input->post('Choir_id', TRUE);
                $rehearsalId = $this->input->post('rehearsalId', TRUE);
                $user = $this->ion_auth->user()->row();
                $userId = $user->id;
                $Choir_memberId = $this->rehearsalmodel->Choir_member_id($userId);
                $data['markshit'] = $this->rehearsalmodel->markshit($rehearsalId, $Choir_id, $Choir_memberId);
                $data['rehearsalTitle'] = $this->rehearsalmodel->rehearsalTitle($rehearsalId);
                $data['Choir_memberId'] = $Choir_memberId;
                $data['Choir_memberName'] = $this->input->post('Choir_memberTitle', TRUE);
                $this->load->view('temp/header');
                $this->load->view('ow_marksheet', $data);
                $this->load->view('temp/footer');
            } else {
                echo lang('exac_16');
            }
        } else {
            $data['Choir'] = $this->common->getAllData('Choir');
            $this->load->view('temp/header');
            $this->load->view('sel_ow_ma', $data);
            $this->load->view('temp/footer');
        }
    }
    //This function will called by ajax from view for load class markshit
    public function ajax_ow_ma() {
        $Choir_id = $this->input->get('q');
        $query = $this->rehearsalmodel->rehearsalTitleForMarkshit($Choir_id);
        foreach ($query as $row) {
            $data[] = $row;
        }
        if (!empty($data)) {
            echo '<div class="form-group">
                        <label class="col-md-3 control-label">' . lang('exac_4') . ' <span class="requiredStar"> * </span></label>
                        <div class="col-md-6">
                            <select name="rehearsalId" class="form-control">';
            foreach ($data as $sec) {
                echo '<option value="' . $sec['id'] . '">' . $sec['rehearsal_title'] . '</option>';
            }
            echo '</select></div>
                        </div>';
        } else {
            echo '<div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-6">
                        <div class="alert alert-warning">
                                <strong>' . lang('exac_info') . '</strong> ' . lang('exac_18') . '
                        </div></div></div>';
        }
    }
}
