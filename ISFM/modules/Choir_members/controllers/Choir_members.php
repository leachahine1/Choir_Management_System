<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Choir_members extends MX_Controller {

    /**
     * This controller is using for controlling to Choir_members
     *
     * Maps to the following URL
     * 		http://rehearsalple.com/index.php/users
     * 	- or -  
     * 		http://rehearsalple.com/index.php/users/<method_name>
     */
    function __construct() {
        parent::__construct();
        $this->load->model('Choir_membermodel');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
    }
    //This function is used for get all Choir_members in this system.
    public function allChoir_member() {
        if ($this->input->post('submit', TRUE)) {
            $data['Choir_id'] = $this->input->post('Choir', TRUE);
            //If "Choir" and "section" fild is not empty the run this condition
            if ($this->input->post('Choir', TRUE) && $this->input->post('section', TRUE)) {
                //Search Choir_member by Choir,section.
                $Choir = $this->input->post('Choir', TRUE);
                $section = $this->input->post('section', TRUE);
                $data['section'] = $section;
                if ($section == 'all') {
                    $data['Choir_memberInfo'] = $this->Choir_membermodel->getChoir_memberByChoirSection($Choir, $section);
                    if (!empty($data)) {
                        //If the Choir have Choir_member then run here.
                        $this->load->view('temp/header');
                        $this->load->view('Choir_memberChoir', $data);
                        $this->load->view('temp/footer');
                    } else {
                        //If the Choir have no any Choir_member then print the massage in the view.
                        $data['message'] = 'This Choir is no Choir_member.';
                        $this->load->view('temp/header');
                        $this->load->view('Choir_memberChoir', $data);
                        $this->load->view('temp/footer');
                    }
                } else {
                    $data['Choir_memberInfo'] = $this->Choir_membermodel->getChoir_memberByChoirSection($Choir, $section);
                    if (!empty($data)) {
                        //If the Choir have Choir_member then run here.
                        $this->load->view('temp/header');
                        $this->load->view('Choir_memberChoir', $data);
                        $this->load->view('temp/footer');
                    } else {
                        //If the Choir have no any Choir_member then print the massage in the view.
                        $data['message'] = lang('stuc_1');
                        $this->load->view('temp/header');
                        $this->load->view('Choir_memberChoir', $data);
                        $this->load->view('temp/footer');
                    }
                }
            } elseif ($this->input->post('Choir', TRUE)) {
                //onley search Choir_member by Choir or all Choir_member the Choir.
                $Choir_id = $this->input->post('Choir', TRUE);
                $data['Choir_memberInfo'] = $this->Choir_membermodel->getAllChoir_member($Choir_id);
                if (!empty($data)) {
                    //If the Choir have Choir_member then run here.
                    $this->load->view('temp/header');
                    $this->load->view('Choir_memberChoir', $data);
                    $this->load->view('temp/footer');
                } else {
                    //If the Choir have no any Choir_member then print the massage in the view.
                    $data['message'] = lang('stuc_1');
                    $this->load->view('temp/header');
                    $this->load->view('Choir_memberChoir', $data);
                    $this->load->view('temp/footer');
                }
            }
        } else {
            //First of all this method run here and load Choir selecting view.
            $data['s_Choir'] = $this->common->selectChoir();
            $this->load->view('temp/header');
            $this->load->view('slectChoir_member', $data);
            $this->load->view('temp/footer');
        }
    }
    //This function is used for filtering to get Choir_members information
    //Whene Choir and section gave in the frontend, if the Choir have section he cane select the section and get Choir_member information in the viwe.
    public function ajaxChoirSection() {
        $ChoirTitle = $this->input->get('Choir_title');
        $query = $this->common->getWhere('Choir', 'Choir_title', $ChoirTitle);
        
   // $ChoirID = $this->input->get('id');
    //$query = $this->common->getWhere('Choir', 'id', $ChoirID);

        foreach ($query as $row) {
            $data = $row['section'];
        }
        if (!empty($data)) {
            $sectionArray = explode(",", $data);
            echo '<div Choir="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-4">
                            <select name="section" class="form-control">
                                <option value="all">' . lang('stu_sel_cla_velue_all') . '</option>';
           
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
                                <strong>' . lang('stu_sel_cla_no_Info') . '</strong> ' . lang('stu_sel_cla_no_section') . '
                        </div></div></div>';
        }
    }
    //This function is giving a Choir_member's the full information. 
    public function Choir_members_details() {
        $id = $this->input->get('id');
        $Choir_memberId = $this->input->get('sid');
        $data['Choir_memberInfo'] = $this->Choir_membermodel->Choir_memberDetails($id);
        $data['photo'] = $this->Choir_membermodel->Choir_memberPhoto($Choir_memberId);
        $this->load->view('temp/header');
        $this->load->view('Choir_membersDetails', $data);
        $this->load->view('temp/footer');
    }
    //This function is use for edit Choir_member's informations.
    public function editChoir_member() {
        $userId = $this->input->get('userId');
        $Choir_memberInfoId = $this->input->get('sid');
        $Choir_memberChoir = $this->input->get('di');
        $Choir_id = $this->input->get('Choir_id');
        if ($this->input->post('submit', TRUE)) {
            $username = $this->input->post('first_name', TRUE) . ' ' . $this->input->post('last_name', TRUE);
            $additional_data = array(
                'first_name' => $this->db->escape_like_str($this->input->post('first_name', TRUE)),
                'last_name' => $this->db->escape_like_str($this->input->post('last_name', TRUE)),
                'username' => $this->db->escape_like_str($username),
                'phone' => $this->db->escape_like_str($this->input->post('phone', TRUE)),
                'email' => $this->db->escape_like_str($this->input->post('email', TRUE))
            );
            $this->db->where('id', $userId);
            $this->db->update('users', $additional_data);
            $Choir_membersInfo = array(
                'Choir_member_id' => $this->db->escape_like_str($this->input->post('Choir_member_id', TRUE)),
                'Choir_id' => $this->db->escape_like_str($this->input->post('Choir', TRUE)),
                'farther_name' => $this->db->escape_like_str($this->input->post('father_name', TRUE)),
                'mother_name' => $this->db->escape_like_str($this->input->post('mother_name', TRUE)),
                'birth_date' => $this->db->escape_like_str($this->input->post('birthdate', TRUE)),
                'sex' => $this->db->escape_like_str($this->input->post('sex', TRUE)),
                'present_address' => $this->db->escape_like_str($this->input->post('present_address', TRUE)),
                'permanent_address' => $this->db->escape_like_str($this->input->post('permanent_address', TRUE)),
                'father_occupation' => $this->db->escape_like_str($this->input->post('father_occupation', TRUE)),
                'father_incom_range' => $this->db->escape_like_str($this->input->post('father_incom_range', TRUE)),
                'mother_occupation' => $this->db->escape_like_str($this->input->post('mother_occupation', TRUE)),
                'last_Choir_certificate' => $this->db->escape_like_str($this->input->post('previous_certificate', TRUE)),
                't_c' => $this->db->escape_like_str($this->input->post('tc', TRUE)),
                'academic_transcription' => $this->db->escape_like_str($this->input->post('at', TRUE)),
                'national_birth_certificate' => $this->db->escape_like_str($this->input->post('nbc', TRUE)),
                'testimonial' => $this->db->escape_like_str($this->input->post('testmonial', TRUE)),
                'documents_info' => $this->db->escape_like_str($this->input->post('submit_file_information', TRUE)),
                'blood' => $this->db->escape_like_str($this->input->post('blood', TRUE)),
            );
            $this->db->where('Choir_member_id', $Choir_memberInfoId);
            $this->db->update('Choir_member_info', $Choir_membersInfo);
            $additionalData3 = array(
                'Choir_title' => $this->db->escape_like_str($this->input->post('Choir')),
                'Choir_member_title' => $this->db->escape_like_str($username),
                'section' => $this->db->escape_like_str($this->input->post('section'))
            );
            $this->db->where('id', $Choir_memberChoir);
            $this->db->update('Choir_Choir_members', $additionalData3);
            $data['success'] = '<div class="alert alert-info alert-dismissable admisionSucceassMessageFont">
                                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button"></button>
                                                    <strong>' . lang('success') . '</strong> ' . lang('stuc_2') . '
                                            </div>';
            $data['ChoirChoir_members'] = $this->common->getWhere('Choir_Choir_members', 'id', $Choir_memberChoir);
            $data['Choir_memberInfo'] = $this->common->getWhere('Choir_member_info', 'Choir_member_id', $Choir_memberInfoId);
            $data['users'] = $this->common->getWhere('users', 'id', $userId);
            $data['s_Choir'] = $this->common->getAllData('Choir');
            $data['section'] = $this->Choir_membermodel->section($Choir_id);
            $this->load->view('temp/header');
            $this->load->view('editChoir_memberInfo', $data);
            $this->load->view('temp/footer');
        } else {
            //first here load the edit Choir_member view with Choir_member's previous value.
            $data['ChoirChoir_members'] = $this->common->getWhere('Choir_Choir_members', 'id', $Choir_memberChoir);
            $data['Choir_memberInfo'] = $this->common->getWhere('Choir_member_info', 'Choir_member_id', $Choir_memberInfoId);
            $data['users'] = $this->common->getWhere('users', 'id', $userId);
            $data['s_Choir'] = $this->common->getAllData('Choir');
            $data['sectiond'] = $this->Choir_membermodel->section($Choir_id);
            $this->load->view('temp/header');
            $this->load->view('editChoir_memberInfo', $data);
            $this->load->view('temp/footer');
        }
    }
    //This function is use for delete a Choir_member.
    public function Choir_memberDelete() {
        $id = $this->input->get('di');
        $Choir_memberInfoId = $this->input->get('sid');
        $userId = $this->input->get('userId');
        if ($this->db->delete('Choir_Choir_members', array('id' => $id)) && $this->db->delete('Choir_member_info', array('id' => $Choir_memberInfoId)) && $this->db->delete('users', array('id' => $userId))) {
            redirect('Choir_members/allChoir_member');
        }
    }
    //This function will return only logedin Choir_members information
    public function Choir_membersInfo() {
        $uid = $this->input->get('uisd');
        $data['Choir_memberInfo'] = $this->Choir_membermodel->ownChoir_memberDetails($uid);
        $data['photo'] = $this->Choir_membermodel->ownChoir_memberPhoto($uid);
        $this->load->view('temp/header');
        $this->load->view('Choir_membersDetails', $data);
        $this->load->view('temp/footer');
    }
}
