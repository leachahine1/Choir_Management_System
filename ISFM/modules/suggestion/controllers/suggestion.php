<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Suggestion extends MX_Controller {
    /**
     * This controller is using to give any suggestion for the Choir_member in this school
     *
     * Maps to the following URL
     * 		http://rehearsalple.com/index.php/suggestion
     * 	- or -  
     * 		http://rehearsalple.com/index.php/suggestion/<method_name>
     */
    function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
    }
    //This function can make Choir suggestion for Choir Choir_members.
    public function makeSuggestion() {
        if ($this->input->post('submit', TRUE)) {
            $user = $this->ion_auth->user()->row();
            $day = date("m/d/y h:i:s A");
            $date = strtotime($day);
            $suggestion = array(
                'author_id' => $this->db->escape_like_str($user->id),
                'author_name' => $this->db->escape_like_str($user->username),
                'Choir' => $this->db->escape_like_str($this->input->post('Choir', TRUE)),
                'song' => $this->db->escape_like_str($this->input->post('song', TRUE)),
                'suggestion_title' => $this->db->escape_like_str($this->input->post('suggestionTitle', TRUE)),
                'suggestion' => $this->db->escape_like_str($this->input->post('fullSuggestion', TRUE)),
                'date' => $this->db->escape_like_str($date)
            );
            if ($this->db->insert('suggestion', $suggestion)) {
                redirect('suggestion/allSuggestion', 'refresh');
            }
        } else {
            $data['Choir'] = $this->common->getAllData('Choir');
            $this->load->view('temp/header');
            $this->load->view('makeSuggestion', $data);
            $this->load->view('temp/footer');
        }
    }
    //This function will return a Choir song via ajax
    public function ajaxChoirSong() {
        $Choir = $this->input->get('cla');
        $query = $this->common->getWhere('Choir_song', 'Choir_title', $Choir);
        if (!empty($query)) {
            echo '<label class="control-label col-md-3">'.lang('sugc_1').'</label>
                    <div class="col-md-6">
                        <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-Resource"></i>
                    </span>
                    <select name="song" class="form-control select2me" data-placeholder="Select..." required>';
            foreach ($query as $row) {
                echo "<option value=\'" . $row['song_title'] . "\'>" . $row['song_title'] . "</option>";
            }
            echo '</select></div></div>';
        } else {
            echo '<label class="control-label col-md-3">Choir Song</label>
                    <div class="col-md-6"><div class="alert alert-warning">
                        <strong>'.lang('sugc_2').'</strong> '.lang('sugc_3').'
                </div></div>';
        }
    }
    //This function can show all suggestion for the users in the system.
    public function allSuggestion() {
        $data['suggestion'] = $this->common->getAllData('suggestion');
        $this->load->view('temp/header');
        $this->load->view('allSuggestion', $data);
        $this->load->view('temp/footer');
    }
    //This function will return only user suggestion
    public function own_suggestion() {
        $data = array();
        $userId = $this->input->get('uisd');
        $query = $this->db->query("SELECT Choir_title FROM Choir_Choir_members WHERE user_id='$userId'");
        foreach ($query->result_array() as $row) {
            $ChoirTitle = $row['Choir_title'];
        }
        $data['suggestion'] = $this->common->getWhere('suggestion', 'Choir', $ChoirTitle);
        $this->load->view('temp/header');
        $this->load->view('allSuggestion', $data);
        $this->load->view('temp/footer');
    }
    //This function canshow full suggestion
    public function suggestionDetails() {
        $id = $this->input->get('id');
        $data['suggestion'] = $this->common->getWhere('suggestion', 'id', $id);
        $this->load->view('temp/header');
        $this->load->view('details', $data);
        $this->load->view('temp/footer');
    }
    //This function can delete suggestion
    public function deleteSuggestion() {
        $id = $this->input->get('id');
        if ($this->db->delete('suggestion', array('id' => $id))) {
            redirect('suggestion/allSuggestion', 'refresh');
        }
    }
}