<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Section_trainers extends CI_Controller {
    /**
     * This controller is using for 
     *
     * Maps to the following URL
     * 		http://rehearsalple.com/index.php/section_trainers
     * 	- or -  
     * 		http://rehearsalple.com/index.php/section_trainers/<method_name>
     */
    function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
    }
    //This function lode a view where is select Choir for know about section_trainers infomation
    public function section_trainersInformation() {
        if ($this->input->post('submit', TRUE)) {
            $Choir_id = $this->input->post('Choir_id', TRUE);
            $data['ChoirTitle'] = $this->common->Choir_title($Choir_id);
            $data['section_trainers'] = $this->common->getWhere('section_trainers_info', 'Choir_id', $Choir_id);
            $this->load->view('temp/header');
            $this->load->view('section_trainersInformation', $data);
            $this->load->view('temp/footer');
        } else {
            $data['s_Choir'] = $this->common->getAllData('Choir');
            $this->load->view('temp/header');
            $this->load->view('section_trainers', $data);
            $this->load->view('temp/footer');
        }
    }
    //This function is used for filtering to get Choir_members information(which Choir and which section if the section in that Choir)
    //If any one want to select Choir section for get that section's section_trainers thene he can call this ajax function from view file.
    public function ajaxChoirSection() {
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
                                <option value="all">' . lang('parc_1') . '</option>';
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
                                <strong>' . lang('parc_2') . '</strong> ' . lang('parc_3') . '
                        </div></div></div>';
        }
    }
    //This function will update the section_trainers information.
    public function editSection_trainersInfo() {
        $userID = $this->input->get('puid');
        $section_trainersInfoId = $this->input->get('painid');
        if ($this->input->post('submit', TRUE)) {
            $username = $this->input->post('first_name', TRUE) . ' ' . $this->input->post('last_name', TRUE);
            $additional_data = array(
                'username' => $this->db->escape_like_str($username),
                'first_name' => $this->db->escape_like_str($this->input->post('first_name', TRUE)),
                'last_name' => $this->db->escape_like_str($this->input->post('last_name', TRUE)),
                'phone' => $this->db->escape_like_str($this->input->post('phone', TRUE)),
                'email' => $this->db->escape_like_str($this->input->post('email', TRUE))
            );
            $this->db->where('id', $userID);
            $this->db->update('users', $additional_data);
            $additionalData1 = array(
                'section_trainers_name' => $this->db->escape_like_str($username),
                'relation' => $this->db->escape_like_str($this->input->post('guardianRelation', TRUE)),
                'email' => $this->db->escape_like_str($this->input->post('email', TRUE)),
                'phone' => $this->db->escape_like_str($this->input->post('phone', TRUE)),
            );
            $this->db->where('id', $section_trainersInfoId);
            $this->db->update('section_trainers_info', $additionalData1);
            $data['s_Choir'] = $this->common->getAllData('Choir');
            $data['success'] = '<br><div class="col-md-12"><div class="alert alert-info alert-dismissable admisionSucceassMessageFont">
                                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"></button>
                                                <strong>' . lang('success') . '</strong>' . lang('parc_4') . '
                                        </div></div>';
            $this->load->view('temp/header');
            $this->load->view('section_trainers', $data);
            $this->load->view('temp/footer');
        } else {
            $data['info'] = $this->common->getWhere('section_trainers_info', 'id', $section_trainersInfoId);
            $this->load->view('temp/header');
            $this->load->view('editSection_trainers', $data);
            $this->load->view('temp/footer');
        }
    }
    //This function is using for delete any section_trainers profile.
    public function deleteSection_trainers() {
        $userID = $this->input->get('UcsHeRnHdtfgrfGshId');
        $section_trainersInfoId = $this->input->get('pdfdsfAjhgdfrRdfeNdsfdtSjdcfgdInfOdfgdfhIdnfd');

        $this->db->delete('users', array('id' => $userID));
        $this->db->delete('section_trainers_info', array('id' => $section_trainersInfoId));

        redirect("section_trainers/section_trainersInformation", 'refresh');
    }
}
