<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Song_model extends CI_Model {
    /**
     * This model is using into the sChoir controller
     * Load : $this->load->model('Choirmodel');
     */
    function __construct() {
        parent::__construct();
        $this->load->dbforge();
    }

    //This function will return an array which is in Choir song by Choir Id 
    public function Choir_op_sub($Choir_id) {
        $data = array();
        $query = $this->db->query("SELECT id,song_title FROM Choir_song WHERE Choir_id=$Choir_id");
        foreach ($query->result_array() as $row) {
            $data[] = $row;
        }
        return $data;
    }

    // Add this method inside the Song_model class

public function getSongCountsPerChoir() {
    $this->db->select('Choir_id, COUNT(*) as song_count');
    $this->db->from('Choir_song');
    $this->db->group_by('Choir_id');
    $query = $this->db->get();
    return $query->result_array();
}

}
