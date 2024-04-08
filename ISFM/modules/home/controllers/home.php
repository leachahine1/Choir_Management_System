<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends MX_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://rehearsalple.com/index.php/home
     * 	- or -  
     * 		http://rehearsalple.com/index.php/home/index
     */
    function __construct() {
        parent::__construct();
        $this->load->model('common');
        $this->load->model('homeModel');
        $this->load->helper('file');
        $this->load->helper('form');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
    }

    //This function will show the users dashboard
    public function index() {
        $user = $this->ion_auth->user()->row();
        $id = $user->id;
        $data['massage'] = $this->common->getWhere('massage', 'receiver_id', $id);
        $data['totalChoir_member'] = $this->common->totalChoir_member();
        $data['totalSection_leader'] = $this->common->totalSection_leader();
        $data['totalSection_trainers'] = $this->common->totalSection_trainers();
        $data['totalAttendChoir_member'] = $this->common->totalAttendChoir_member();
        $data['section_leaderAttendance'] = $this->common->section_leaderAttendance();
        $data['presentEmploy'] = $this->homeModel->presentEmploy();
        $data['absentEmploy'] = $this->homeModel->absentEmploy();
        $data['leaveEmploy'] = $this->homeModel->leaveEmploy();
        $data['event'] = $this->homeModel->all_event($id);
            $data['notice'] = $this->common->getAllData('notice_board');
            $data['ChoirAttendance'] = $this->homeModel->atten_chart();
            $data['ChoirInfo'] = $this->common->ChoirInfo();
            if ($this->ion_auth->is_Choir_member()) {
            //Whice notice is created for Choir_member these notice can see both Choir_members and section_trainers.
            $query = $this->common->getWhere('Choir_member_info', 'user_id', $id);
            foreach ($query as $row) {
                $Choir_id = $row['Choir_id'];
            }
            $data['Choir_id'] = $Choir_id;
            $data['day'] = $this->common->getAllData('config_week_day');
            $data['song'] = $this->common->getWhere('Choir_song', 'Choir_id', $Choir_id);
            $data['section_leader'] = $this->common->getAllData('section_leaders_info');
        }
        $this->load->view('temp/header', $data);
        $this->load->view('dashboard', $data);
        $this->load->view('temp/footer');
    }

//    public function index() {
//        $user = $this->ion_auth->user()->row();
//        $id = $user->id;
//        $data['massage'] = $this->common->getWhere('massage', 'receiver_id', $id);
//        $data['totalChoir_member'] = $this->common->totalChoir_member();
//        $data['totalSection_leader'] = $this->common->totalSection_leader();
//        $data['totalSection_trainers'] = $this->common->totalSection_trainers();
//        $data['totalAttendChoir_member'] = $this->common->totalAttendChoir_member();
//        $data['section_leaderAttendance'] = $this->common->section_leaderAttendance();
//        $data['presentEmploy'] = $this->homeModel->presentEmploy();
//        $data['absentEmploy'] = $this->homeModel->absentEmploy();
//        $data['leaveEmploy'] = $this->homeModel->leaveEmploy();
//        $data['event'] = $this->homeModel->all_event($id);
//        if ($this->ion_auth->is_admin()) {
//            $data['notice'] = $this->common->getAllData('notice_board');
//            $data['ChoirAttendance'] = $this->homeModel->atten_chart();
//            $data['ChoirInfo'] = $this->common->classInfo();
//        } elseif ($this->ion_auth->is_section_leader()) {
//            //If this user have section_leader's previlize, he can view only that notice whice notice is created for only section_leader.
//            $data['notice'] = $this->common->getSection_leaderNotice();
//            $data['ChoirInfo'] = $this->common->classInfo();
//        } elseif ($this->ion_auth->is_Choir_member()) {
//            //Whice notice is created for Choir_member these notice can see both Choir_members and section_trainers.
//            $data['notice'] = $this->common->getChoir_memberNotice();
//            $query = $this->common->getWhere('Choir_member_info', 'user_id', $id);
//            foreach ($query as $row) {
//                $Choir_id = $row['Choir_id'];
//            }
//            $data['Choir_id'] = $Choir_id;
//            $data['day'] = $this->common->getAllData('config_week_day');
//            $data['subject'] = $this->common->getWhere('Choir_subject', 'Choir_id', $Choir_id);
//            $data['section_leader'] = $this->common->getAllData('section_leaders_info');
//        } elseif ($this->ion_auth->is_section_trainers()) {
//            //Whice notice is created for Choir_member these notice can see both Choir_members and section_trainers.
//            $data['notice'] = $this->common->getChoir_memberNotice();
//        }
//        $this->load->view('temp/header', $data);
//        $this->load->view('dashboard', $data);
//        $this->load->view('temp/footer');
//    }
//    
    public function profileView() {
        $user = $this->ion_auth->user()->row();
        $data['userprofile'] = $this->common->getWhere('users', 'id', $user->id);
        if ($this->input->post('submit', TRUE)) {
            $data_up = array(
                'first_name' => $this->db->escape_like_str($this->input->post('firstName', TRUE)),
                'last_name' => $this->db->escape_like_str($this->input->post('lastName', TRUE)),
                'username' => $this->db->escape_like_str($this->input->post('userName', TRUE)),
                'phone' => $this->db->escape_like_str($this->input->post('mobileNumber', TRUE)),
                'email' => $this->db->escape_like_str($this->input->post('email', TRUE)),
            );
            $this->db->where('id', $user->id);
            if ($this->db->update('users', $data_up)) {
                redirect('home/profileView', 'refresh');
            }
        } else {
            $this->load->view('temp/header');
            $this->load->view('profileView', $data);
            $this->load->view('temp/footer');
        }
    }

    public function profileImage() {
        $user = $this->ion_auth->user()->row();
        if ($this->ion_auth->is_admin()) {
            if (empty($user->profile_image)) {
                //Here is uploading the Choir_member's photo.
                $config['upload_path'] = './assets/uploads/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '10000';
                $config['max_width'] = '10240';
                $config['max_height'] = '7680';
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                $this->upload->do_upload();
                $uploadFileInfo = $this->upload->data();
                $data_update = array(
                    'profile_image' => $this->db->escape_like_str($uploadFileInfo['file_name'])
                );
                $this->db->where('id', $user->id);
                if ($this->db->update('users', $data_update)) {
                    redirect('home/profileView', 'refresh');
                }
            } else {
                $path = 'assets/uploads/' . $user->profile_image;
                //$userprofile = $this->common->getWhere('users', 'id',$user->id);
                if (unlink($path)) {
                    //Here is uploading the Choir_member's photo.
                    $config['upload_path'] = './assets/uploads/';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size'] = '10000';
                    $config['max_width'] = '10240';
                    $config['max_height'] = '7680';
                    $config['encrypt_name'] = TRUE;

                    $this->load->library('upload', $config);
                    $this->upload->do_upload();
                    $uploadFileInfo = $this->upload->data();
                    $data_update = array(
                        'profile_image' => $this->db->escape_like_str($uploadFileInfo['file_name'])
                    );

                    $this->db->where('id', $user->id);
                    if ($this->db->update('users', $data_update)) {
                        redirect('home/profileView', 'refresh');
                    }
                } else {
                    echo lang('desc_1');
                }
            }
        } elseif ($this->ion_auth->is_section_leader()) {
            if (empty($user->profile_image)) {
                //Here is uploading the Choir_member's photo.
                $config['upload_path'] = './assets/uploads/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '10000';
                $config['max_width'] = '10240';
                $config['max_height'] = '7680';
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                $this->upload->do_upload();
                $uploadFileInfo = $this->upload->data();
                $data_update = array(
                    'profile_image' => $this->db->escape_like_str($uploadFileInfo['file_name'])
                );
                $this->db->where('id', $user->id);
                if ($this->db->update('users', $data_update)) {
                    redirect('home/profileView', 'refresh');
                }
            } else {
                $path = 'assets/uploads/' . $user->profile_image;
                //$userprofile = $this->common->getWhere('users', 'id',$user->id);
                if (unlink($path)) {
                    //Here is uploading the Choir_member's photo.
                    $config['upload_path'] = './assets/uploads/';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size'] = '10000';
                    $config['max_width'] = '10240';
                    $config['max_height'] = '7680';
                    $config['encrypt_name'] = TRUE;

                    $this->load->library('upload', $config);
                    $this->upload->do_upload();
                    $uploadFileInfo = $this->upload->data();
                    $data_update = array(
                        'profile_image' => $this->db->escape_like_str($uploadFileInfo['file_name'])
                    );
                    $this->db->where('id', $user->id);
                    if ($this->db->update('users', $data_update)) {
                        
                        $this->db->where('user_id', $user->id);
                        if ($this->db->update('section_leaders_info')) {
                            redirect('home/profileView', 'refresh');
                        }
                    }
                } else {
                    echo lang('desc_1');
                }
            }
        } elseif ($this->ion_auth->is_Choir_member()) {
            if (empty($user->profile_image)) {
                //Here is uploading the Choir_member's photo.
                $config['upload_path'] = './assets/uploads/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '10000';
                $config['max_width'] = '10240';
                $config['max_height'] = '7680';
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                $this->upload->do_upload();
                $uploadFileInfo = $this->upload->data();
                $data_update = array(
                    'profile_image' => $this->db->escape_like_str($uploadFileInfo['file_name'])
                );
                $this->db->where('id', $user->id);
                if ($this->db->update('users', $data_update)) {
                    redirect('home/profileView', 'refresh');
                }
            } else {
                $path = 'assets/uploads/' . $user->profile_image;
                //$userprofile = $this->common->getWhere('users', 'id',$user->id);
                if (unlink($path)) {
                    //Here is uploading the Choir_member's photo.
                    $config['upload_path'] = './assets/uploads/';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size'] = '10000';
                    $config['max_width'] = '10240';
                    $config['max_height'] = '7680';
                    $config['encrypt_name'] = TRUE;
                    $this->load->library('upload', $config);
                    $this->upload->do_upload();
                    $uploadFileInfo = $this->upload->data();
                    $data_update = array(
                        'profile_image' => $this->db->escape_like_str($uploadFileInfo['file_name'])
                    );
                    $this->db->where('id', $user->id);
                    if ($this->db->update('users', $data_update)) {
                        $data_update_3 = array(
                            'Choir_member_photo' => $this->db->escape_like_str($uploadFileInfo['file_name'])
                        );
                        $this->db->where('user_id', $user->id);
                        if ($this->db->update('Choir_member_info', $data_update_3)) {
                            redirect('home/profileView', 'refresh');
                        }
                    }
                } else {
                    echo lang('desc_1');
                }
            }
        } elseif ($this->ion_auth->is_section_trainers()) {
            if (empty($user->profile_image)) {
                //Here is uploading the Choir_member's photo.
                $config['upload_path'] = './assets/uploads/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '10000';
                $config['max_width'] = '10240';
                $config['max_height'] = '7680';
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                $this->upload->do_upload();
                $uploadFileInfo = $this->upload->data();
                $data_update = array(
                    'profile_image' => $this->db->escape_like_str($uploadFileInfo['file_name'])
                );
                $this->db->where('id', $user->id);
                if ($this->db->update('users', $data_update)) {
                    redirect('home/profileView', 'refresh');
                }
            } else {
                $path = 'assets/uploads/' . $user->profile_image;
                //$userprofile = $this->common->getWhere('users', 'id',$user->id);
                if (unlink($path)) {
                    //Here is uploading the Choir_member's photo.
                    $config['upload_path'] = './assets/uploads/';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size'] = '10000';
                    $config['max_width'] = '10240';
                    $config['max_height'] = '7680';
                    $config['encrypt_name'] = TRUE;
                    $this->load->library('upload', $config);
                    $this->upload->do_upload();
                    $uploadFileInfo = $this->upload->data();
                    $data_update = array(
                        'profile_image' => $this->db->escape_like_str($uploadFileInfo['file_name'])
                    );
                    $this->db->where('id', $user->id);
                    if ($this->db->update('users', $data_update)) {
                        redirect('home/profileView', 'refresh');
                    }
                } else {
                    echo lang('desc_1');
                }
            }
        }
    }

    //Thid function will show the calender with event
    public function calender() {
        $user = $this->ion_auth->user()->row();
        $userId = $user->id;
        if ($this->input->post('submit', TRUE)) {
            $title = $this->input->post('title', TRUE);
            $start_date = $this->input->post('start_date', TRUE);
            $end_date = $this->input->post('end_date', TRUE);
            $color = $this->input->post('color', TRUE);
            $url = $this->input->post('url', TRUE);
            $event_info = array(
                'title' => $this->db->escape_like_str($title),
                'start_date' => $this->db->escape_like_str($start_date),
                'end_date' => $this->db->escape_like_str($end_date),
                'color' => $this->db->escape_like_str($color),
                'url' => $this->db->escape_like_str($url),
                'user_id' => $userId
            );
            if ($this->db->insert('calender_events', $event_info)) {
                redirect('home/calender', 'refresh');
            }
        } else {
            $data['event'] = $this->homeModel->all_event($userId);
            $this->load->view('temp/header');
            $this->load->view('calender', $data);
            $this->load->view('temp/footer');
        }
    }

    public function addEvent() {
        $user = $this->ion_auth->user()->row();
        $userId = $user->id;
        if ($this->input->post('submit', TRUE)) {
            $title = $this->input->post('title', TRUE);
            $start_date = $this->input->post('start_date', TRUE);
            $end_date = $this->input->post('end_date', TRUE);
            $color = $this->input->post('color', TRUE);
            $url = $this->input->post('url', TRUE);
            $user = $this->ion_auth->user()->row();
            $userId = $user->id;
            $event_info = array(
                'title' => $this->db->escape_like_str($title),
                'start_date' => $this->db->escape_like_str($start_date),
                'end_date' => $this->db->escape_like_str($end_date),
                'color' => $this->db->escape_like_str($color),
                'url' => $this->db->escape_like_str($url),
                'user_id' => $this->db->escape_like_str($userId)
            );
            if ($this->db->insert('calender_events', $event_info)) {
                redirect('home/addEvent', 'refresh');
            }
        } else {
            $data['event'] = $this->homeModel->all_event($userId);
            $this->load->view('temp/header');
            $this->load->view('events', $data);
            $this->load->view('temp/footer');
        }
    }

    //This function will edit events information
    public function edit_event() {
        if ($this->input->post('submit', TRUE)) {
            $eve_id = $this->input->post('eve_id', TRUE);
            $title = $this->input->post('title', TRUE);
            $start_date = $this->input->post('start_date', TRUE);
            $end_date = $this->input->post('end_date', TRUE);
            $color = $this->input->post('color', TRUE);
            $url = $this->input->post('url', TRUE);
            $user = $this->ion_auth->user()->row();
            $userId = $user->id;
            $event_info = array(
                'title' => $this->db->escape_like_str($title),
                'start_date' => $this->db->escape_like_str($start_date),
                'end_date' => $this->db->escape_like_str($end_date),
                'color' => $this->db->escape_like_str($color),
                'url' => $this->db->escape_like_str($url),
                'user_id' => $this->db->escape_like_str($userId)
            );
            $this->db->where('id', $eve_id);
            if ($this->db->update('calender_events', $event_info)) {
                redirect('home/addEvent', 'refresh');
            }
        } else {
            $event_id = $this->input->get('eve_id');
            $data['event'] = $this->homeModel->single_event($event_id);
            $this->load->view('temp/header');
            $this->load->view('edit_event', $data);
            $this->load->view('temp/footer');
        }
    }

    public function iceTime() {
        $time = $this->common->iceTime();
    }
    //This function will delete clender event
    public function delete_event() {
        $id = $this->input->get('eve_id');
        
        if ($this->db->delete('calender_events', array('id' => $id))) {
            $data['event'] = $this->homeModel->all_event($userId);
            $data['message'] = '<div class="alert alert-success alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
								<strong>Success!</strong> The event was deleted successfully.
							</div>';
            $this->load->view('temp/header');
            $this->load->view('events', $data);
            $this->load->view('temp/footer');
        }
    }
}
