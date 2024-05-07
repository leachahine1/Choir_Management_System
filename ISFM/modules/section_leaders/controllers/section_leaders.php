<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Section_leaders extends MX_Controller {

    /**
     * This controller is using for control section_leaders work
     * 
     * Maps to the following URL
     * 		http://rehearsalple.com/index.php/section_leaders
     * 	- or -  
     * 		http://rehearsalple.com/index.php/section_leaders/<method_name>
     */
    function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
        $this->load->model('section_leadermodel');
    }

    //This function gives all section_leader's short informattion in a table view
    public function allSection_leaders() {
        $data['section_leader'] = $this->section_leadermodel->allSection_leaders();
        $this->load->view('temp/header');
        $this->load->view('section_leaders', $data);
        $this->load->view('temp/footer');
    }
    public function section_leadersInformation() {
        if ($this->input->post('submit', TRUE)) {
            $Choir_id = $this->input->post('Choir_id', TRUE);
            $selected_section = $this->input->post('section', TRUE); // Get selected section name
            $data['Choir_title'] = $this->common->Choir_title($Choir_id);
            $data['selected_section'] = $selected_section; // Pass selected section name to the view
            $data['section_leaders'] = $this->common->getWhere22('section_leaders_info', 'Choir_id', $Choir_id, 'section', $selected_section); // Fetch trainers for the selected section
            $this->load->view('temp/header');
            $this->load->view('section_leadersInformation', $data);
            $this->load->view('temp/footer');
        } else {
            $data['s_Choir'] = $this->common->getAllData('Choir');
            $this->load->view('temp/header');
            $this->load->view('section_leaders', $data);
            $this->load->view('temp/footer');
        }
    }

    public function ajaxChoirSection() {
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

    //This function gives all details about any section_leader
    public function section_leaderDetails() {
        $id = $this->input->get('id');
        $userId = $this->input->get('uid');
        $data['section_leader'] = $this->common->getWhere('section_leaders_info', 'id', $id);
        $data['user'] = $this->common->getWhere('users', 'id', $userId);
        $this->load->view('temp/header');
        $this->load->view('section_leaderDetails', $data);
        $this->load->view('temp/footer');
    }
    //This function is using for editing a section_leader informations
    //And admin an select group  
    function edit_section_leader() {
        $userId = $this->input->get('uid');
        $section_leaderId = $this->input->get('id');
        if ($this->input->post('submit', TRUE)) {
            $edu_1 = '';
            $edu_2 = '';
            $edu_3 = '';
            $edu_4 = '';
            $edu_5 = '';
            if ($this->input->post('dd_1', TRUE)) {
                $edu_1 = $this->input->post('dd_1') . ',' . $this->input->post('scu_1', TRUE) . ',' . $this->input->post('result_1', TRUE) . ',' . $this->input->post('paYear_1', TRUE);
            }
            if ($this->input->post('dd_2', TRUE)) {
                $edu_2 = $this->input->post('dd_2') . ',' . $this->input->post('scu_2', TRUE) . ',' . $this->input->post('result_2', TRUE) . ',' . $this->input->post('paYear_2', TRUE);
            }
            if ($this->input->post('dd_3', TRUE)) {
                $edu_3 = $this->input->post('dd_3') . ',' . $this->input->post('scu_3', TRUE) . ',' . $this->input->post('result_3', TRUE) . ',' . $this->input->post('paYear_3', TRUE);
            }
            if ($this->input->post('dd_4', TRUE)) {
                $edu_4 = $this->input->post('dd_4') . ',' . $this->input->post('scu_4', TRUE) . ',' . $this->input->post('result_4', TRUE) . ',' . $this->input->post('paYear_4', TRUE);
            }
            if ($this->input->post('dd_5', TRUE)) {
                $edu_5 = $this->input->post('dd_5') . ',' . $this->input->post('scu_5', TRUE) . ',' . $this->input->post('result_5', TRUE) . ',' . $this->input->post('paYear_5');
            }
            $username = strtolower($this->input->post('first_name', TRUE)) . ' ' . strtolower($this->input->post('last_name', TRUE));
            $additional_data = array(
                'username' => $this->db->escape_like_str($username),
                'email' => $this->db->escape_like_str($this->input->post('email', TRUE)),
                'first_name' => $this->db->escape_like_str($this->input->post('first_name', TRUE)),
                'last_name' => $this->db->escape_like_str($this->input->post('last_name', TRUE)),
                'phone' => $this->db->escape_like_str($this->input->post('phone', TRUE)),
            );
            $this->db->where('id', $userId);
            $this->db->update('users', $additional_data);
            $section_leadersInfo = array(
                'fullname' => $this->db->escape_like_str($username),
                'farther_name' => $this->db->escape_like_str($this->input->post('father_name', TRUE)),
                'mother_name' => $this->db->escape_like_str($this->input->post('mother_name', TRUE)),
                'birth_date' => $this->db->escape_like_str($this->input->post('birthdate', TRUE)),
                'sex' => $this->db->escape_like_str($this->input->post('sex', TRUE)),
                'present_address' => $this->db->escape_like_str($this->input->post('present_address', TRUE)),
                'permanent_address' => $this->db->escape_like_str($this->input->post('permanent_address', TRUE)),
                'position' => $this->db->escape_like_str($this->input->post('position', TRUE)),
                'working_hour' => $this->db->escape_like_str($this->input->post('workingHoure', TRUE)),
                'educational_qualification_1' => $this->db->escape_like_str($edu_1),
                'educational_qualification_2' => $this->db->escape_like_str($edu_2),
                'educational_qualification_3' => $this->db->escape_like_str($edu_3),
                'educational_qualification_4' => $this->db->escape_like_str($edu_4),
                'educational_qualification_5' => $this->db->escape_like_str($edu_5),
                'cv' => $this->db->escape_like_str($this->input->post('cv', TRUE)),
                'educational_certificat' => $this->db->escape_like_str($this->input->post('educational_certificat', TRUE)),
                'exprieance_certificatte' => $this->db->escape_like_str($this->input->post('exc', TRUE)),
                'files_info' => $this->db->escape_like_str($this->input->post('submited_info', TRUE))
            );
            $this->db->where('id', $section_leaderId);
            $this->db->update('section_leaders_info', $section_leadersInfo);
            $data['section_leader'] = $this->common->getAllData('section_leaders_info');
            $this->load->view('temp/header');
            $this->load->view('section_leaders', $data);
            $this->load->view('temp/footer');
        } else {
            //get all data about this section_leader from the "user" table
            $data['userInfo'] = $this->common->getWhere('users', 'id', $userId);
            $data['section_leaderInfo'] = $this->common->getWhere('section_leaders_info', 'id', $section_leaderId);
            //get all groupe information and current group information to view file by "$data" array.
            $data['groups'] = $this->ion_auth->groups()->result_array();
            $data['currentGroups'] = $this->ion_auth->get_users_groups($userId)->result();
            $this->load->view('temp/header');
            $this->load->view('editSection_leader', $data);
            $this->load->view('temp/footer');
        }
    }
    //This function is use for delete a section_leader.
    public function section_leaderDelete() {
        $section_leaderId = $this->input->get('id');
        $userId = $this->input->get('uid');
        $this->db->delete('section_leaders_info', array('id' => $section_leaderId));
        $this->db->delete('users', array('id' => $userId));
        redirect('section_leaders/allSection_leaders', 'refresh');
    }
}