<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Section_trainers extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
    }

    public function section_trainersInformation() {
        if ($this->input->post('submit', TRUE)) {
            $Choir_id = $this->input->post('Choir_id', TRUE);
            $selected_section = $this->input->post('section', TRUE); // Get selected section name
            $data['Choir_title'] = $this->common->Choir_title($Choir_id);
            $data['selected_section'] = $selected_section; // Pass selected section name to the view
            $data['section_trainers'] = $this->common->getWhere22('section_trainers_info', 'Choir_id', $Choir_id, 'section', $selected_section); // Fetch trainers for the selected section
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

<<<<<<< HEAD
=======
    
    //This function will update the section_trainers information.
>>>>>>> 881bea0
    public function editSection_trainersInfo() {
        $userId = $this->input->get('puid');
        $section_trainersInfoId = $this->input->get('painid');
    
        if ($this->input->post('submit', TRUE)) {
            // Process form data
            $username = $this->input->post('first_name', TRUE) . ' ' . $this->input->post('last_name', TRUE);
            $additional_data = array(
                'username' => $this->db->escape_like_str($username),
                'first_name' => $this->db->escape_like_str($this->input->post('first_name', TRUE)),
                'last_name' => $this->db->escape_like_str($this->input->post('last_name', TRUE)),
                'phone' => $this->db->escape_like_str($this->input->post('phone', TRUE)),
                'email' => $this->db->escape_like_str($this->input->post('email', TRUE)),
            );
    
            // Update user info
            $this->db->where('id', $userId);
            $this->db->update('users', $additional_data);
    
            $additionalData1 = array(
                'section_trainers_name' => $this->db->escape_like_str($username),
                'level' => $this->db->escape_like_str($this->input->post('guardianLevel', TRUE)),
                'email' => $this->db->escape_like_str($this->input->post('email', TRUE)),
                'phone' => $this->db->escape_like_str($this->input->post('phone', TRUE)),
            );
    
            // Update trainers info
            $this->db->where('id', $section_trainersInfoId);
            $this->db->update('section_trainers_info', $additionalData1);
    
            $data['success'] = '<br><div class="col-md-12"><div class="alert alert-info alert-dismissable admisionSucceassMessageFont">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button"></button>
            <strong>' . lang('success') . '</strong>' . lang('parc_4') . '
                </div></div>';
            $this->load->view('temp/header');
            $this->load->view('section_trainers', $data);
            $this->load->view('temp/footer');
        } else {
            // Load edit form
            $data['info'] = $this->common->getWhere('section_trainers_info', 'id', $section_trainersInfoId);
            if (empty($data['info'])) {
                $data['info'] = array(); // Ensure $info is always an array
            }
    
            $this->load->view('temp/header');
            $this->load->view('editSection_trainers', $data);
            $this->load->view('temp/footer');
        }
    }
<<<<<<< HEAD

=======
    
    
    
    //This function is using for delete any section_trainers profile.
>>>>>>> 881bea0
    public function deleteSection_trainers() {
        $userID = $this->input->get('UcsHeRnHdtfgrfGshId');
        $section_trainersInfoId = $this->input->get('pdfdsfAjhgdfrRdfeNdsfdtSjdcfgdInfOdfgdfhIdnfd');

        $this->db->delete('users', array('id' => $userID));
        $this->db->delete('section_trainers_info', array('id' => $section_trainersInfoId));

        redirect("section_trainers/section_trainersInformation", 'refresh');
    }
}