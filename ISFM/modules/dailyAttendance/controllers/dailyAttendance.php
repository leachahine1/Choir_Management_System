<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class DailyAttendance extends MX_Controller {
//    private $input;

    /**
     * This is DailyAttendance Controller in Choir Module.
     *
     * Maps to the following URL
     * 		http://rehearsalple.com/index.php/dailyAttendance
     * 	- or -  
     * 		http://rehearsalple.com/index.php/dailyAttendance/index
     */
    function __construct() {
        parent::__construct();
        $this->load->model('attendancemodule');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
    }

    //This function show the Choir & section for selecting Choir to take attendance 
    public function selectChoirAttendance() {
        $data['s_Choir'] = $this->common->getAllData('Choir');
        $this->load->view('temp/header');
        $this->load->view('selectChoirAttendance', $data);
        $this->load->view('temp/footer');
    }

    //This function is used for take attendence to Choir Choir_members
    public function attendance() {
        if ($this->input->post('submit', TRUE)) {
            //Whene submit the attendence information after takeing the attendence
            $i = $this->input->post('in_velu', TRUE);
            $day = date("d-m-Y");
            $date = strtotime($day);
            $ChoirTitle = $this->input->post('ChoirTitle', TRUE);
            for ($x = 1; $x <= $i; $x++) {
                $roll = $this->input->post("roll_$x", TRUE);
                $name = $this->input->post("atudentName_$x", TRUE);
                $present = "";
                if ($this->input->post("action_$x", TRUE)) {
                    if ($this->input->post("action_$x", TRUE) === 'P') {
                        $present = "P";
                    } else {
                        $present = "A";
                    }
                }
                $userId = $this->input->post("userId_$x", TRUE);
                $Choir_memberInfoId = $this->input->post("Choir_memberInfoId_$x", TRUE);
                $section = $this->input->post("section_$x", TRUE);
                $data = array(
                    'date' => $this->db->escape_like_str($date),
                    'user_id' => $this->db->escape_like_str($userId),
                    'Choir_member_id' => $this->db->escape_like_str($Choir_memberInfoId),
                    'Choir_title' => $this->db->escape_like_str($ChoirTitle),
                    'present_or_absent' => $this->db->escape_like_str($present),
                    'section' => $this->db->escape_like_str($section),
                    'roll_no' => $this->db->escape_like_str($roll),
                    'Choir_member_title' => $this->db->escape_like_str($name),
                );
                //insert the $data information into "daily_attendance" database.
                $this->db->insert('daily_attendance', $data);
                //Take Choir and attend amount monthly and make the attendence percintise monthly 
                $ChoirAmountMonthly = $this->attendancemodule->ChoirAmountMonthly($Choir_memberInfoId);
                if ($this->input->post("action_$x", TRUE) === 'P') {
                    $attendAmountMonthly = $this->attendancemodule->attendAmountMonthly($Choir_memberInfoId);
                } else {
                    $previousAttendAmountM = $this->attendancemodule->attendAmountMonthly($Choir_memberInfoId);
                    $todayAttendAmountM = 1;
                    $attendAmountMonthly = $previousAttendAmountM - $todayAttendAmountM;
                }
                $attendencePercenticeMonthly = $this->attendancemodule->attendPercentiseMonthly($attendAmountMonthly, $ChoirAmountMonthly);
                //Take Choir and attend amount yearly and make the attendence percintise yearly 
                $ChoirAmountYearly = $this->attendancemodule->ChoirAmountYearly($Choir_memberInfoId);
                if ($this->input->post("action_$x", TRUE) === 'P') {
                    $attendAmountYearly = $this->attendancemodule->attendAmountYearly($Choir_memberInfoId);
                } else {
                    $previousAttendAmountY = $this->attendancemodule->attendAmountYearly($Choir_memberInfoId);
                    $todayAttendAmountY = 1;
                    $attendAmountYearly = $previousAttendAmountY - $todayAttendAmountY;
                }
                $attendencePercenticeYearly = $this->attendancemodule->attendPercentiseYearly($attendAmountYearly, $ChoirAmountYearly);
                $data_1 = array(
                    'Choir_amount_monthly' => $this->db->escape_like_str($ChoirAmountMonthly),
                    'Choir_amount_yearly' => $this->db->escape_like_str($ChoirAmountYearly),
                    'attend_amount_monthly' => $this->db->escape_like_str($attendAmountMonthly),
                    'attend_amount_yearly' => $this->db->escape_like_str($attendAmountYearly),
                    'percentise_month' => $this->db->escape_like_str($attendencePercenticeMonthly),
                    'percentise_year' => $this->db->escape_like_str($attendencePercenticeYearly),
                );
                $this->db->update('daily_attendance', $data_1, array('Choir_member_id' => $Choir_memberInfoId, 'date' => $date));
                $data_2 = array(
                    'attendance_percentices_daily' => $this->db->escape_like_str($attendencePercenticeMonthly)
                );
                $this->db->update('Choir_Choir_members', $data_2, array('Choir_member_id' => $Choir_memberInfoId, 'Choir_title' => $ChoirTitle));
            }
            $dailyChoirAttendencePercentise = $this->attendancemodule->allChoir_membersDailyAttendence($date, $ChoirTitle);
            $yearChoirAttendencePercentise = $this->attendancemodule->allChoir_membersYearlyAttendence($date, $ChoirTitle);
            $data_3 = array(
                'attendance_percentices_daily' => $this->db->escape_like_str($dailyChoirAttendencePercentise),
                'attend_percentise_yearly' => $this->db->escape_like_str($yearChoirAttendencePercentise)
            );
            $this->db->where('Choir_title', $ChoirTitle);
            $this->db->update('Choir', $data_3);
            redirect('dailyAttendance/attendanceCompleteMessage', 'refresh');
        } else {
            //Load attendence view before takeing attendence with Choir,All section and specific Choir section
            $ChoirTitle = $this->input->post('Choir_title', TRUE);
            if ($this->input->post('section', TRUE)) {
                $Section = $this->input->post('section', TRUE);
                if ($Section == 'all') {
                    //if want any Choir's specific section's Choir_members attendence sheet,then work this erea.
                    $queryData = array();
                    $query = $this->db->get_where('Choir_Choir_members', array('Choir_title' => $ChoirTitle));
                    foreach ($query->result_array() as $row) {
                        $queryData[] = $row;
                    }$data['Choir_members'] = $queryData;
                    if (!empty($data['Choir_members'])) {
                        $this->load->view('temp/header');
                        $this->load->view('attendance', $data);
                        $this->load->view('temp/footer');
                    } else {
                        echo $ChoirTitle . ' and all section are no any Choir_member.';
                    }
                } elseif ($Section != 'all') {
                    //if want All section's Choir_members attendence sheet,then work this erea.
                    $queryData = array();
                    $query = $this->db->get_where('Choir_Choir_members', array('Choir_title' => $ChoirTitle, 'section' => $Section));
                    foreach ($query->result_array() as $row) {
                        $queryData[] = $row;
                    }$data['Choir_members'] = $queryData;
                    if (!empty($data['Choir_members'])) {
                        $this->load->view('temp/header');
                        $this->load->view('attendance', $data);
                        $this->load->view('temp/footer');
                    } else {
                        echo $ChoirTitle . ' and ' . $Section . ' section are no any Choir_member.';
                    }
                }
            } else {
                //whene want any Choir Choir_members attendence sheet only,then work this erea.
                $queryData = array();
                $query = $this->db->get_where('Choir_Choir_members', array('Choir_title' => $ChoirTitle));
                foreach ($query->result_array() as $row) {
                    $queryData[] = $row;
                }
                $data['Choir_members'] = $queryData;
                if (!empty($data['Choir_members'])) {
                    $this->load->view('temp/header');
                    $this->load->view('attendance', $data);
                    $this->load->view('temp/footer');
                } else {
                    echo $ChoirTitle . ' are no any Choir_member.';
                }
            }
        }
    }

    //This function send a message that Attendance Was completed.
    //And gives two link for re-check and can edit the attendance.
    public function attendanceCompleteMessage() {
        $this->load->view('temp/header');
        $this->load->view('attendenceCompleateMessage');
        $this->load->view('temp/footer');
    }

    //This function is used for filtering to get Choir_members information(which Choir and which section if the section in that Choir)
    public function ajaxChoirAttendanceSection() {
        $ChoirTitle = $this->input->get('q');
        $query = $this->common->getWhere('Choir', 'Choir_title', $ChoirTitle);
        foreach ($query as $row) {
            $data = $row;
        }
        echo '<input type="hidden" name="Choir" value="' . $ChoirTitle . '">';
        if (!empty($data['section'])) {
            $section = $data['section'];
            $sectionArray = explode(",", $section);
            echo '<div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-4">
                            <select name="section" class="form-control">
                                <option value="all">' . lang('attc_1') . '</option>';
            foreach ($sectionArray as $sec) {
                echo '<option value="' . $sec . '">' . $sec . '</option>';
            }
            echo '</select></div>
                    </div>';
        } else {
            $section = 'This class has no section.';
            echo '<div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-6">
                        <div class="alert alert-warning">
                                <strong>Info!</strong> ' . $section . '
                        </div></div></div>';
        }
    }

    public function selectAttendancePreview() {
        $data['s_Choir'] = $this->common->getAllData('Choir');
        $this->load->view('temp/header');
        $this->load->view('selectAttendencePreview', $data);
        $this->load->view('temp/footer');
    }

    public function attendencePreview() {
        //Load attendence view before takeing attendence with Choir,All section and specific Choir section
        $ChoirTitle = $this->input->post('Choir_title', TRUE);
        $date = $this->input->post('date', TRUE);
        $intDate = strtotime($date);
        if ($this->input->post('section', TRUE)) {
            $Section = $this->input->post('section', TRUE);
            if ($Section == 'all') {
                //if want any Choir's specific section's Choir_members attendence sheet,then work this erea.
                $queryData = array();
                $query = $this->db->get_where('daily_attendance', array('Choir_title' => $ChoirTitle, 'date' => $intDate));
                foreach ($query->result_array() as $row) {
                    $queryData[] = $row;
                }$data['Choir_members'] = $queryData;
                if (!empty($data['Choir_members'])) {
                    $this->load->view('temp/header');
                    $this->load->view('attendencePreview', $data);
                    $this->load->view('temp/footer');
                } else {
                    echo $ChoirTitle . ' and all section are no any Choir_member.';
                }
            } elseif ($Section != 'all') {
                //if want All section's Choir_members attendence sheet,then work this erea.
                //if want any Choir's specific section's Choir_members attendence sheet,then work this erea.
                $queryData = array();
                $query = $this->db->get_where('daily_attendance', array('Choir_title' => $ChoirTitle, 'date' => $intDate, 'section' => $Section));
                foreach ($query->result_array() as $row) {
                    $queryData[] = $row;
                }
                $data['Choir_members'] = $queryData;
                if (!empty($data['Choir_members'])) {
                    $this->load->view('temp/header');
                    $this->load->view('attendencePreview', $data);
                    $this->load->view('temp/footer');
                } else {
                    echo $ChoirTitle . ' and ' . $Section . ' section are no any Choir_member.';
                }
            }
        } else {
            //whene want any Choir Choir_members attendence sheet only,then work this erea.
            $queryData = array();
            $query = $this->db->get_where('daily_attendance', array('Choir_title' => $ChoirTitle, 'date' => $intDate));
            foreach ($query->result_array() as $row) {
                $queryData[] = $row;
            }
            $data['Choir_members'] = $queryData;
            if (!empty($data['Choir_members'])) {
                $this->load->view('temp/header');
                $this->load->view('attendencePreview', $data);
                $this->load->view('temp/footer');
            } else {
                echo $ChoirTitle . ' ' . lang('attc_2');
            }
        }
    }

    //This function send Choir section to view by ajax. 
    public function ajaxAttendencePreview() {
        $ChoirTitle = $this->input->get('q', TRUE);
        $query = $this->common->getWhere('Choir', 'Choir_title', $ChoirTitle);
        foreach ($query as $row) {
            $data = $row;
        }
        echo '<input type="hidden" name="Choir" value="' . $ChoirTitle . '">';
        if (!empty($data['section'])) {
            $section = $data['section'];
            $sectionArray = explode(",", $section);
            echo '<div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-4">
                            <select name="section" class="form-control">
                                <option value="all">' . lang('attc_1') . '</option>';
            foreach ($sectionArray as $sec) {
                echo '<option value="' . $sec . '">' . $sec . '</option>';
            }
            echo '</select></div>
                    </div>';
        } else {
            $section = 'This class has no section.';
            echo '<div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-6">
                        <div class="alert alert-warning">
                                <strong>' . lang('attc_3') . ' </strong> ' . $section . '
                        </div></div></div>';
        }
    }

    //This function can edit and update the related table's info.
    public function editAttendance() {
        $id = $this->input->get('ghtnidjdfjkid', TRUE);
        $day = date("m/d/y");
        $date = strtotime($day);
        if ($this->input->post('submit', TRUE)) {
            $Choir_memberInfoId = $this->input->post('Choir_memberInfoId', TRUE);
            $ChoirTitle = $this->input->post('ChoirTitle', TRUE);

            $present = "";
            if ($this->input->post("action", TRUE)) {
                if ($this->input->post("action", TRUE) == 'P') {
                    $present = "P";
                } else {
                    $present = "A";
                }
            }
            //Take Choir and attend amount monthly and make the attendence percintise monthly 
            $ChoirAmountMonthly = $this->attendancemodule->ChoirAmountMonthly($Choir_memberInfoId);
            if ($this->input->post("action", TRUE) == 'P') {
                $previousAttendAmountM = $this->attendancemodule->attendAmountMonthly($Choir_memberInfoId);
                $todayAttendAmountM = 2;
                $attendAmountMonthly = $previousAttendAmountM + $todayAttendAmountM;
            } else {
                $previousAttendAmountM = $this->attendancemodule->attendAmountMonthly($Choir_memberInfoId);
                $todayAttendAmountM = 2;
                $attendAmountMonthly = $previousAttendAmountM - $todayAttendAmountM;
            }
            $attendencePercenticeMonthly = $this->attendancemodule->attendPercentiseMonthly($attendAmountMonthly, $ChoirAmountMonthly);
            //Take Choir and attend amount yearly and make the attendence percintise yearly 
            $ChoirAmountYearly = $this->attendancemodule->ChoirAmountYearly($Choir_memberInfoId);
            if ($this->input->post("action", TRUE) == 'P') {
                $previousAttendAmountY = $this->attendancemodule->attendAmountYearly($Choir_memberInfoId);
                $todayAttendAmountY = 2;
                $attendAmountYearly = $previousAttendAmountY + $todayAttendAmountY;
            } else {
                $previousAttendAmountY = $this->attendancemodule->attendAmountYearly($Choir_memberInfoId);
                $todayAttendAmountY = 2;
                $attendAmountYearly = $previousAttendAmountY - $todayAttendAmountY;
            }
            $attendencePercenticeYearly = $this->attendancemodule->attendPercentiseYearly($attendAmountYearly, $ChoirAmountYearly);
            $tableData = array(
                'present_or_absent' => $this->db->escape_like_str($present),
                'Choir_amount_monthly' => $this->db->escape_like_str($ChoirAmountMonthly),
                'Choir_amount_yearly' => $this->db->escape_like_str($ChoirAmountYearly),
                'attend_amount_monthly' => $this->db->escape_like_str($attendAmountMonthly),
                'attend_amount_yearly' => $this->db->escape_like_str($attendAmountYearly),
                'percentise_month' => $this->db->escape_like_str($attendencePercenticeMonthly),
                'percentise_year' => $this->db->escape_like_str($attendencePercenticeYearly),
            );
            $this->db->update('daily_attendance', $tableData, array('Choir_member_id' => $Choir_memberInfoId, 'date' => $date));
            $tableData_1 = array(
                'attendance_percentices_daily' => $this->db->escape_like_str($attendencePercenticeMonthly)
            );
            $this->db->update('Choir_Choir_members', $tableData_1, array('Choir_member_id' => $Choir_memberInfoId, 'Choir_title' => $ChoirTitle));
            redirect('dailyAttendance/attendanceEditCompleteMessage', 'refresh');
        } else {
            $data['editInfo'] = $this->common->getWhere('daily_attendance', 'id', $id);
            //load the attendance edit view with information.
            $this->load->view('temp/header');
            $this->load->view('editAttendance', $data);
            $this->load->view('temp/footer');
        }
    }

    public function attendanceEditCompleteMessage() {
        $this->load->view('temp/header');
        $this->load->view('attendanceEditCompleteMessage');
        $this->load->view('temp/footer');
    }

    //This functio check section_leader security password
    public function t_a_s_p() {
        if ($this->input->post('submit', TRUE)) {
            $password = $this->input->post('password', TRUE);
            $security = $this->db->query('SELECT t_a_s_p FROM configuration');
            foreach ($security->result_array() as $row) {
                $data = $row['t_a_s_p'];
            }
            if ($password == $data) {
                $today = strtotime(date('d-m-Y'));
                if ($this->attendancemodule->todaySection_leaderAtt($today) == 'Taken') {
                    redirect('dailyAttendance/section_leaderAttendance', 'refresh');
                } else {
                    $query = $this->db->query("SELECT id,username FROM users WHERE user_status='Employee' AND NOT (leave_status='Leave' AND leave_start<='$today' AND leave_end>='$today')");
                    foreach ($query->result_array() as $row) {
                        $tData = array(
                            'year' => date('Y'),
                            'date' => strtotime(date("d-m-Y")),
                            'employ_id' => $row['id'],
                            'employ_title' => $row['username'],
                            'present_or_absent' => 'Absent'
                        );
                        $this->db->insert('section_leader_attendance', $tData);
                    }
                    redirect('dailyAttendance/section_leaderAttendance', 'refresh');
                }
            } else {
                $dat['message'] = '<div class="alert alert-danger alert-dismissable">
								<button aria-hidden="true" data-dismiss="alert" class="close" type="button"></button>
								<strong>' . lang('attc_4') . ' </strong> ' . lang('attc_5') . '
							</div>';
                $this->load->view('temp/header');
                $this->load->view('selcetTeacAttView', $dat);
                $this->load->view('temp/footer');
            }
        } else {
            $this->load->view('temp/header');
            $this->load->view('selcetTeacAttView');
            $this->load->view('temp/footer');
        }
    }

    //Start section_leader attendance's function now.
    //take section_leader attendance
    public function section_leaderAttendance() {
        if ($this->input->post('submit', TRUE)) {
            $query = $this->db->query('SELECT time_zone FROM configuration');
            foreach ($query->result_array() as $row) {
                $data = $row['time_zone'];
            }
            $datestring = "%h:%i %a";
            $now = now();
            $timezone = $data;
            $time = gmt_to_local($now, $timezone);
            $compTime = mdate($datestring, $time);
            $section_leaderAttenId = $this->input->post('section_leader', TRUE);
            if ($this->input->post('presAbsent', TRUE) == 'Absent') {
                $compTime = '';
            }
            $insertData = array(
                'id' => $section_leaderAttenId,
                'present_or_absent' => $this->input->post('presAbsent', TRUE),
                'attend_time' => $compTime
            );
            $this->db->where('id', $section_leaderAttenId);
            if ($this->db->update('section_leader_attendance', $insertData)) {
                redirect('dailyAttendance/section_leaderAttendance', 'refresh');
            }
        } else {
            $data['section_leader'] = $this->attendancemodule->section_leaderList();
            $this->load->view('temp/header');
            $this->load->view('teacAtteView', $data);
            $this->load->view('temp/footer');
        }
    }

    //This function will return employee attendance information
    public function employe_atten_view() {
        $data['employee'] = $this->attendancemodule->attend_employe();
        $this->load->view('temp/header');
        $this->load->view('employe_atten_view', $data);
        $this->load->view('temp/footer');
    }

}
