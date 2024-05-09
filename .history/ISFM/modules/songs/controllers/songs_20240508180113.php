<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Songs extends MX_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('song_model');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
    }
    //THis function add new song in a Choir
    public function addSong() {
        if ($this->input->post('submit', TRUE)) {
            $Choir_id = $this->input->post('Choir_id', TRUE);
            $song_1_a = $this->input->post('song_title_1', TRUE);
            $edition = $this->input->post('edition', TRUE);
            $writer_name = $this->input->post('writer_name', TRUE);
            $tableData = array(
                'Choir_id' => $this->db->escape_like_str($Choir_id),
                'year' => $this->db->escape_like_str(date('Y')),
                'song_title' => $this->db->escape_like_str($song_1_a),
                'edition' => $this->db->escape_like_str($edition),
                'writer_name' => $this->db->escape_like_str($writer_name),
                'optional' => $this->db->escape_like_str($this->input->post('optionalSong', TRUE))
            );
            if ($this->db->insert('Choir_song', $tableData)) {
                $data['success'] = '<div class="alert alert-info alert-dismissable admisionSucceassMessageFont">
                                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button"></button>
                                            <strong>'.lang('success').'</strong> '.lang('sub_1').' "' . $song_1_a . '" '.lang('sub_2').'
                                    </div>';
                $data['Choir'] = $this->common->getAllData('Choir');
                $data['section_leader'] = $this->common->getAllData('section_leaders_info');
                $this->load->view('temp/header');
                $this->load->view('addSong', $data);
                $this->load->view('temp/footer');
            }
        } else {
            $data['Choir'] = $this->common->getAllData('Choir');
            $data['section_leader'] = $this->common->getAllData('section_leaders_info');
            $this->load->view('temp/header');
            $this->load->view('addSong', $data);
            $this->load->view('temp/footer');
        }
    }
    //This function load all song with Choir
    public function allSong() {
        $data['SongInfo'] = $this->common->getAllData('Choir');
        $this->load->view('temp/header');
        $this->load->view('songInformation', $data);
        $this->load->view('temp/footer');
    }
    //This function view song deatils by Choir title
    public function ChoirSongDetails() {
        $Choir_id = $this->input->get('c_id');
        $data['SongInfo'] = $this->common->getWhere('Choir_song', 'Choir_id', $Choir_id);
        $this->load->view('temp/header');
        $this->load->view('ChoirSongDetails', $data);
        $this->load->view('temp/footer');
    }
    //This function will set Choir_members optional song
    public function set_optional() {
        if ($this->input->post('submit', TRUE)) {
            $stu_id = $this->input->post('Choir_member_id', TRUE);
            $upload_data = array(
                'optional_sub' => $this->db->escape_like_str($this->input->post('op_sub', TRUE))
            );
            $this->db->where('Choir_member_id', $stu_id);
            if ($this->db->update('Choir_Choir_members', $upload_data)) {
                $data['Choir'] = $this->common->getAllData('Choir');
                $data['message'] = '<div class="alert alert-success alert-dismissable">
								<button aria-hidden="true" data-dismiss="alert" class="close" type="button"></button>
								<strong>'.lang('success').'</strong> '.lang('sub_3').'
							</div>';
                $this->load->view('temp/header');
                $this->load->view('set_optional', $data);
                $this->load->view('temp/footer');
            }
        } else {
            $data['Choir'] = $this->common->getAllData('Choir');
            $this->load->view('temp/header');
            $this->load->view('set_optional', $data);
            $this->load->view('temp/footer');
        }
    }
    //This function will give the Choir_member information from Choir_memberID
    public function Choir_memberInfoById() {
        $Choir_memberId = $this->input->get('q', TRUE);
        $query = $this->common->stuInfoId($Choir_memberId);
        if (empty($query)) {
            echo '<div class="form-group">
                    <label class="col-md-3 control-label"></label>
                        <div class="col-md-6">
                        <div class="alert alert-danger">
                            <strong>'.lang('sub_4').'</strong> '.lang('sub_5').' <strong>' . $Choir_memberId . '</strong> '.lang('sub_6').'
                    </div></div></div>';
        } else {
            $Choir_id = $query->Choir_id;
            $Choir_title = $this->common->Choir_title($Choir_id);
            echo '<div class="row"><div class="col-md-offset-2 col-md-7 stuInfoIdBox">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="col-md-4 control-label">'.lang('sub_7').' <span class="requiredStar">  </span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="Choir_memberName" value="' . $query->Choir_member_nam . '" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">'.lang('sub_8').' <span class="requiredStar">  </span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="Choir_title" value="' . $Choir_title . '" readonly>
                            </div>
                        </div>
                        <div id="ajax_result2">
                            <div  class="col-md-offset-3 col-md-9">
                                <button type="button" class="btn purple btn-block" onclick="optional_song(this.value)" value="' . $Choir_id . '">'.lang('sub_10').'</button><br>
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" name="Choir_id" value="' . $Choir_id . '">
                    <div class="col-md-2">
                        <img src="assets/uploads/' . $query->Choir_member_photo . '" class="img-responsive" alt=""><br>
                    </div>
                </div></div>';
        }
    }

    // Add this function inside the Songs controller class

public function graphs() {
    // Your graph-related logic goes here
    
    // For example, let's say you want to display a bar chart of song counts per Choir
    // You can fetch the data from the database using your model and pass it to a view
    
    // Fetch data from the model
    $song_counts_per_choir = $this->song_model->getSongCountsPerChoir();

    // Pass the data to a view
    $data['song_counts'] = $song_counts_per_choir;
    $this->load->view('temp/header');
    $this->load->view('Graphs', $data); // Assuming you have a view named graphs_view.php
    $this->load->view('temp/footer');
}

    //This function will return class optional song
    public function optional_song() {
        $Choir_id = $this->input->get('c_id', TRUE);
        $song = $this->song_model->Choir_op_sub($Choir_id);
        echo '<div class="form-group">
                    <label class="col-md-4 control-label">'.lang('sub_9').' <span class="requiredStar"> * </span></label>
                    <div class="col-md-8">
                        <select class="form-control" name="op_sub" data-validation="required">
                            <option value="">'.lang('select').'</option>';
        foreach ($song as $row) {
            echo '<option value="' . $row['song_title'] . '">' . $row['song_title'] . '</option>';
        }
        echo '</select>
                    </div>
                </div>';
    }
public function results() {
     if ($this->input->post('submit', True)) {
            $stu_id = $this->input->post('Choir_member_id', TRUE);
            $upload_data = array(
                'optional_sub' => $this->db->escape_like_str($this->input->post('op_sub', TRUE))
            );


            $this->db->where('Choir_member_id', $stu_id);
            if ($this->db->update('Choir_Choir_members', $upload_data)) {

             $data_to_save = array(
                'Choir_member_id' => $stu_id,
                'song_title' => $upload_data
            );

            // Convert data to JSON format
            $json_data = json_encode($data_to_save);

            // Write JSON data to song_title.json file
            $json_file = 'song_title.json';
            file_put_contents($json_file, $json_data);

        // Read JSON file contents
        $jsonData = file_get_contents($json_file);
        $data = json_decode($jsonData);

        // Check if the JSON data is not empty
        if (!empty($data)) {
            // Execute Python script and capture both stdout and stderr
            $pythonScript = 'C:\xampp\htdocs\Choir_Management_System-final\comparison\FYP-master\final_results.py';
            $pythonPath = 'C:\Users\Charles\AppData\Local\Programs\Python\Python312\python.exe';
            exec("$pythonPath $pythonScript 2>&1", $output, $returnCode);

            // Log errors and output to a file
            $errorLog = fopen('error_log.txt', 'a'); // Open log file in append mode
            if ($returnCode !== 0) {
                fwrite($errorLog, "Error executing Python script:\n");
            }
            foreach ($output as $line) {
                fwrite($errorLog, "$line\n");
            }
            fclose($errorLog); // Close the error log file
        } else {
            echo "JSON data is empty.";
            // Handle the case where JSON data is empty
        }
    }
}
    // Load the view
    $this->load->view('temp/header');
    $this->load->view('results');
    $this->load->view('temp/footer');
}


public function deleteFiles() {
    // Delete images
    $files = glob('Images/*.png'); // Get all PNG files in the Images directory
    foreach ($files as $file) {
        unlink($file); // Delete each PNG file
    }

    // Delete song_title.json
    unlink('song_title.json');

}
}