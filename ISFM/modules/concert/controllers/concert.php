<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Concert extends MX_Controller {
    /**
     * This controller is using for managing full concert in this school
     *
     * Maps to the following URL
     * 		http://rehearsalple.com/index.php/concert
     * 	- or -  
     * 		http://rehearsalple.com/index.php/concert/<method_name>
     */
    function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
    }
    
    //This function is using to add new concert in this school
    public function addConcert() {
        if ($this->input->post('submit', TRUE)) {
            $concertsName = $this->input->post('concertName', TRUE);
            $concertsRoom = $this->input->post('roomAmount', TRUE);
            $concertInfo = array(
                'concert_name' => $this->db->escape_like_str($concertsName),
                'concert_for' => $this->db->escape_like_str($this->input->post('concertFor', TRUE)),
                'room_amount' => $this->db->escape_like_str($concertsRoom),
            );
            if ($this->db->insert('concert', $concertInfo)) {
                $nuid = $this->db->insert_id();
                $userid = $nuid - 1;
                for ($i = 1; $i <= $concertsRoom; $i++) {
                    $concertInfo_2 = array(
                        'concert_id' => $nuid,
                        'concert_name' => $this->db->escape_like_str($concertsName),
                        'room' => $this->db->escape_like_str('Room No: ' . $i)
                    );
                    $this->db->insert('concert_room', $concertInfo_2);
                }
                redirect('concert/concertReport', 'refresh');
            }
        } else {
            $this->load->view('temp/header');
            $this->load->view('addConcert');
            $this->load->view('temp/footer');
        }
    }

    //This function is using to add new concert in this school
    public function addSeat() {
        if ($this->input->post('submit', TRUE)) {
            $concertsId = $this->input->post('concerts', TRUE);
            $query = $this->common->getWhere('concert', 'id', $concertsId);
            $room = $this->input->post('room', TRUE);
            foreach ($query as $row) {
                $concert_name = $row['concert_name'];
            }
            $seat_number = $this->input->post('Seat', TRUE);
            for ($i = 1; $i <= $seat_number; $i++) {
                $tableData = array(
                    'concert_id' => $this->db->escape_like_str($concertsId),
                    'concert_name' => $this->db->escape_like_str($concert_name),
                    'room_number' => $this->db->escape_like_str($room),
                    'seat_number' => $this->db->escape_like_str('Seat No: ' . $i),
                );
                $this->db->insert('concert_seat', $tableData);
            }
            $tableData_2 = array(
                'seat_amount' => $seat_number,
                'free_seat' => $seat_number
            );
            if ($this->db->update('concert_room', $tableData_2, array('concert_id' => $concertsId, 'room' => $room))) {
                redirect('concert/concertReport', 'refresh');
            }
        } else {
            $data['concert'] = $this->common->getAllData('concert');
            $this->load->view('temp/header');
            $this->load->view('addSeat', $data);
            $this->load->view('temp/footer');
        }
    }

    //This function give the room amount in a concerts and send the value by ajax
    public function ajaxConcertRoom() {
        $id = $this->input->get('q');
        $query = $this->common->getWhere('concert', 'id', $id);
        foreach ($query as $row) {
            $roomAmount = $row['room_amount'];
        }
        echo '<option value="">' . lang('dorc_1') . '</option>';
        for ($i = 1; $i <= $roomAmount; $i++) {
            echo '<option value="Room No: ' . $i . '">Room No: ' . $i . ' </option>';
        }
    }

    //This function give the full concert report
    public function concertReport() {
        $data['concert'] = $this->common->getAllData('concert');
        $data['concertRoom'] = $this->common->getAllData('concert_room');
        $data['concert_seat'] = $this->common->getAllData('concert_seat');
        $this->load->view('temp/header');
        $this->load->view('concertReport', $data);
        $this->load->view('temp/footer');
    }

    //This function will select men  for the seat
    public function selectMember() {
        $data['concerts'] = $this->common->getAllData('concert');
        $this->load->view('temp/header');
        $this->load->view('selectMember', $data);
        $this->load->view('temp/footer');
    }

    //This function return seat in a room
    public function ajaxSeatAmount() {
        $concerts = $this->input->get('g');
        $room = $this->input->get('q');
        $query = $this->common->getWhere22('concert_seat', 'concert_name', $concerts, 'room_number', $room);
        if (!empty($query)) {
            $i = 1;
            foreach ($query as $row) {
                if (!empty($row['Choir_member_id'])) {
                    echo '<div class="alert alert-success">
                                                <strong>' . $row['seat_number'] . '</strong>' . $row['Choir_member_name'] . '
                                                <a href="index.php/concert/removeSeatMember?id=' . $row['id'] . '" onClick="javascript:return dconfirm();" class="btn dorButton red"> ' . lang('dorc_2') . '</a>
                                        </div>';
                } else {
                    echo '<div class="alert alert-success">
                                                <strong>' . $row['seat_number'] . '</strong> &nbsp;&nbsp; Blank seat
                                                <a href="index.php/concert/seatResourceing?id=' . $row['id'] . '" class="btn dorButton green-meadow"> ' . lang('dorc_3') . ' </a>
                                        </div>';
                }
            }
        } else {
            echo '<div class="alert alert-danger">
                            <strong>' . lang('dorc_4') . ' </strong> ' . lang('dorc_5') . '
                    </div>';
        }
    }

    //This function can resource a seat
    public function seatResourceing() {
        $id = $this->input->get('id');
        if ($this->input->post('submit', TRUE)) {
            $tdata = array(
                'Choir_member_id' => $this->db->escape_like_str($this->input->post('Choir_memberId', TRUE)),
                'Choir_member_name' => $this->db->escape_like_str($this->input->post('sudentName', TRUE)),
                'Choir' => $this->db->escape_like_str($this->input->post('Choir_id', TRUE)),
                'roll_number' => $this->db->escape_like_str($this->input->post('roll', TRUE))
            );
            $this->db->where('id', $id);
            if ($this->db->update('concert_seat', $tdata)) {
                redirect('concert/concertReport', 'refresh');
            }
        } else {
            $this->load->view('temp/header');
            $this->load->view('seatBook');
            $this->load->view('temp/footer');
        }
    }

    //This function give the Choir_member informations
    public function ajaxChoir_memberInfo() {
        $Choir_memberId = $this->input->get('q');
        $query = $this->common->getWhere('Choir_member_info', 'Choir_member_id', $Choir_memberId);
        if (!empty($query)) {
            foreach ($query as $row) {
                echo '<div class="form-group">
                            <label class="control-label col-md-3">' . lang('dorc_6') . '</label>
                            <div class="col-md-8">
                                <input type="text" readonly="" placeholder="' . $row['Choir_member_nam'] . '" class="form-control" name="sudentName" value="' . $row['Choir_member_nam'] . '">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">' . lang('dorc_7') . '</label>
                            <div class="col-md-8">
                                <input type="text" readonly="" placeholder="" class="form-control" name="Choir" value="' . $this->common->Choir_title($row['Choir_id']) . '">
                            </div>
                        </div>
                        <input type="hidden" name="Choir_id" value="' . $row['Choir_id'] . '">
                        <div class="form-group">
                            <label class="control-label col-md-3">' . lang('dorc_8') . '</label>
                            <div class="col-md-8">
                                <input type="text" readonly="" placeholder="' . $row['roll_number'] . '" class="form-control" name="roll" value="' . $row['roll_number'] . '">
                            </div>
                        </div>';
            }
        } else {
            echo '<div class="alert alert-danger">
                            <strong>' . lang('dorc_9') . '</strong> ' . lang('dorc_10') . ' 
                    </div>';
        }
    }

    //This function can remove any seat member's information
    public function removeSeatMember() {
        $id = $this->input->get('id');
        $tdata = array(
            'Choir_member_id' => '',
            'Choir_member_name' => '',
            'Choir' => '',
            'roll_number' => ''
        );
        $this->db->where('id', $id);
        if ($this->db->update('concert_seat', $tdata)) {
            redirect('concert/concertReport', 'refresh');
        }
    }

    //This function can show tha full details about concerts
    public function showDeatails() {
        $id = $this->input->get('id');
        $data['details'] = $this->common->getWhere('concert_seat', 'id', $id);
        $this->load->view('temp/header');
        $this->load->view('concertsDetails', $data);
        $this->load->view('temp/footer');
    }

}
