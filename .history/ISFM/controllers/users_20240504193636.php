<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Users extends CI_Controller {

    /**
     * This controller is using for add new users (New Choir_member,Section_leader and Parents) in this system 
     *
     * Maps to the following URL
     * 		http://rehearsalple.com/index.php/users
     * 	- or -  
     * 		http://rehearsalple.com/index.php/users/<method_name>
     */
    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
    }

    //This function is using for add new Choir_member
    function admission() {
        $Choir_id = $this->db->escape_like_str($this->input->post('Choir', TRUE));
        if ($this->input->post('submit', TRUE)) {
            $tables = $this->config->item('tables', 'ion_auth');
            $username = $this->input->post('first_name') . ' ' . $this->input->post('last_name');
            $email = strtolower($this->input->post('email', TRUE));
            $password = $this->input->post('password', TRUE);
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
            $phone = $this->input->post('phoneCode', TRUE) . '' . $this->input->post('phone', TRUE);
            //This array information's are sending to "user" table as a core information as a user this system
            $additional_data = array(
                'first_name' => $this->db->escape_like_str($this->input->post('first_name', TRUE)),
                'last_name' => $this->db->escape_like_str($this->input->post('last_name', TRUE)),
                'phone' => $this->db->escape_like_str($phone),
                'profile_image' => $uploadFileInfo['file_name'],
            );
            $group_ids = array('group_id' => 3);
            $Choir_id = $this->db->escape_like_str($this->input->post('Choir', TRUE));
            $Choir_title = $this->common->Choir_title($Choir_id);
            if ($this->ion_auth->register($username, $password, $email, $additional_data, $group_ids)) {
                $userid = $this->common->usersId();
                //This array information's are sending to "Choir_member_info" table.
                $Choir_membersInfo = array(
                    'year' => date('Y'),
                    'user_id' => $this->db->escape_like_str($userid),
                    'Choir_member_id' => $this->db->escape_like_str($this->input->post('Choir_member_id', TRUE)),
                    'roll_number' => $this->db->escape_like_str($this->input->post('roll_number', TRUE)),
                    'Choir_id' => $this->db->escape_like_str($Choir_id),
                    'Choir_member_nam' => $this->db->escape_like_str($username),
                    'farther_name' => $this->db->escape_like_str($this->input->post('father_name', TRUE)),
                    'mother_name' => $this->db->escape_like_str($this->input->post('mother_name', TRUE)),
                    'birth_date' => $this->db->escape_like_str($this->input->post('birthdate', TRUE)),
                    'sex' => $this->db->escape_like_str($this->input->post('sex', TRUE)),
                    'present_address' => $this->db->escape_like_str($this->input->post('present_address', TRUE)),
                    'permanent_address' => $this->db->escape_like_str($this->input->post('permanent_address', TRUE)),
                    'phone' => $this->db->escape_like_str($phone),
                    'father_occupation' => $this->db->escape_like_str($this->input->post('father_occupation', TRUE)),
                    'father_incom_range' => $this->db->escape_like_str($this->input->post('father_incom_range', TRUE)),
                    'mother_occupation' => $this->db->escape_like_str($this->input->post('mother_occupation', TRUE)),
                    'Choir_member_photo' => $this->db->escape_like_str($uploadFileInfo['file_name']),
                    'last_Choir_certificate' => $this->db->escape_like_str($this->input->post('previous_certificate', TRUE)),
                    't_c' => $this->db->escape_like_str($this->input->post('tc', TRUE)),
                    'academic_transcription' => $this->db->escape_like_str($this->input->post('at', TRUE)),
                    'national_birth_certificate' => $this->db->escape_like_str($this->input->post('nbc', TRUE)),
                    'testimonial' => $this->db->escape_like_str($this->input->post('testmonial', TRUE)),
                    'documents_info' => $this->db->escape_like_str($this->input->post('submit_file_information', TRUE)),
                    'blood' => $this->db->escape_like_str($this->input->post('blood', TRUE)),
                    'starting_year' => $this->db->escape_like_str(date('Y')),
                );
                if ($this->db->insert('Choir_member_info', $Choir_membersInfo)) {
                    $Choir_member_info_id = $this->db->insert_id();
                    $additionalData3 = array(
                        'year' => $this->db->escape_like_str(date('Y')),
                        'user_id' => $this->db->escape_like_str($userid),
                        'roll_number' => $this->db->escape_like_str($this->input->post('roll_number', TRUE)),
                        'Choir_member_id' => $this->db->escape_like_str($this->input->post('Choir_member_id', TRUE)),
                        'Choir_title' => $this->db->escape_like_str($Choir_title),
                        'Choir_id' => $this->db->escape_like_str($Choir_id),
                        'section' => $this->db->escape_like_str($this->input->post('section', TRUE)),
                        'Choir_member_title' => $this->db->escape_like_str($username),
                    );

                    if ($this->db->insert('Choir_Choir_members', $additionalData3)) {
                        $Choir_memberAmount = $this->common->ChoirChoir_memberAmount($Choir_id);
                        $clas_info = array(
                            'Choir_member_amount' => $this->db->escape_like_str($Choir_memberAmount)
                        );
                        $this->db->where('id', $Choir_id);
                        if ($this->db->update('Choir', $clas_info)) {
                            $Choir_member_access = array(
                                'user_id' => $this->db->escape_like_str($userid),
                                'group_id' => $this->db->escape_like_str(3),
                                'das_top_info' => $this->db->escape_like_str(0),
                                'das_grab_chart' => $this->db->escape_like_str(0),
                                'das_Choir_info' => $this->db->escape_like_str(0),
                                'das_message' => $this->db->escape_like_str(1),
                                'das_employ_attend' => $this->db->escape_like_str(0),
                                'das_notice' => $this->db->escape_like_str(1),
                                'das_calender' => $this->db->escape_like_str(1),
                                'admission' => $this->db->escape_like_str(0),
                                'all_Choir_member_info' => $this->db->escape_like_str(0),
                                'stud_edit_delete' => $this->db->escape_like_str(0),
                                'stu_own_info' => $this->db->escape_like_str(1),
                                'section_leader_info' => $this->db->escape_like_str(1),
                                'add_section_leader' => $this->db->escape_like_str(0),
                                'section_leader_details' => $this->db->escape_like_str(0),
                                'section_leader_edit_delete' => $this->db->escape_like_str(0),
                                'all_section_trainers_info' => $this->db->escape_like_str(0),
                                'own_section_trainers_info' => $this->db->escape_like_str(1),
                                'make_section_trainers_id' => $this->db->escape_like_str(0),
                                'section_trainers_edit_dlete' => $this->db->escape_like_str(0),
                                'add_new_Choir' => $this->db->escape_like_str(0),
                                'all_Choir_info' => $this->db->escape_like_str(0),
                                'Choir_details' => $this->db->escape_like_str(0),
                                'Choir_delete' => $this->db->escape_like_str(0),
                                'Choir_promotion' => $this->db->escape_like_str(0),
                                'assin_optio_sub' => $this->db->escape_like_str(0),
                                'add_Choir_routine' => $this->db->escape_like_str(0),
                                'own_Choir_routine' => $this->db->escape_like_str(1),
                                'all_Choir_routine' => $this->db->escape_like_str(0),
                                'rutin_edit_delete' => $this->db->escape_like_str(0),
                                'attendance_preview' => $this->db->escape_like_str(0),
                                'take_studence_atten' => $this->db->escape_like_str(0),
                                'edit_Choir_member_atten' => $this->db->escape_like_str(0),
                                'add_employee' => $this->db->escape_like_str(0),
                                'employee_list' => $this->db->escape_like_str(0),
                                'employ_attendance' => $this->db->escape_like_str(0),
                                'empl_atte_view' => $this->db->escape_like_str(0),
                                'add_song' => $this->db->escape_like_str(0),
                                'all_song' => $this->db->escape_like_str(0),
                                'make_suggestion' => $this->db->escape_like_str(0),
                                'all_suggestion' => $this->db->escape_like_str(0),
                                'own_suggestion' => $this->db->escape_like_str(1),
                                'add_rehearsal_gread' => $this->db->escape_like_str(0),
                                'rehearsal_gread' => $this->db->escape_like_str(0),
                                'add_rehearsal_routin' => $this->db->escape_like_str(0),
                                'all_rehearsal_routine' => $this->db->escape_like_str(0),
                                'own_rehearsal_routine' => $this->db->escape_like_str(1),
                                'rehearsal_attend_preview' => $this->db->escape_like_str(0),
                                'approve_result' => $this->db->escape_like_str(0),
                                'view_result' => $this->db->escape_like_str(1),
                                'all_mark_sheet' => $this->db->escape_like_str(0),
                                'own_mark_sheet' => $this->db->escape_like_str(1),
                                'take_rehearsal_attend' => $this->db->escape_like_str(0),
                                'change_rehearsal_attendance' => $this->db->escape_like_str(0),
                                'make_result' => $this->db->escape_like_str(0),
                                'add_category' => $this->db->escape_like_str(0),
                                'all_category' => $this->db->escape_like_str(1),
                                'edit_delete_category' => $this->db->escape_like_str(0),
                                'add_resources' => $this->db->escape_like_str(0),
                                'all_resources' => $this->db->escape_like_str(1),
                                'edit_delete_resources' => $this->db->escape_like_str(0),
                                'add_library_mem' => $this->db->escape_like_str(0),
                                'memb_list' => $this->db->escape_like_str(0),
                                'issu_return' => $this->db->escape_like_str(0),
                                'add_concerts' => $this->db->escape_like_str(0),
                                'add_set_dormi' => $this->db->escape_like_str(0),
                                'set_member_seat' => $this->db->escape_like_str(0),
                                'dormi_report' => $this->db->escape_like_str(1),
                                'add_transport' => $this->db->escape_like_str(0),
                                'all_transport' => $this->db->escape_like_str(1),
                                'transport_edit_dele' => $this->db->escape_like_str(0),
                                'add_account_title' => $this->db->escape_like_str(0),
                                'edit_dele_acco' => $this->db->escape_like_str(0),
                                'trensection' => $this->db->escape_like_str(0),
                                'fee_collection' => $this->db->escape_like_str(0),
                                'all_slips' => $this->db->escape_like_str(0),
                                'own_slip' => $this->db->escape_like_str(1),
                                'slip_edit_delete' => $this->db->escape_like_str(0),
                                'pay_salary' => $this->db->escape_like_str(0),
                                'creat_notice' => $this->db->escape_like_str(0),
                                'send_message' => $this->db->escape_like_str(0),
                                'vendor' => $this->db->escape_like_str(0),
                                'delet_vendor' => $this->db->escape_like_str(0),
                                'add_inv_cat' => $this->db->escape_like_str(0),
                                'inve_item' => $this->db->escape_like_str(0),
                                'delete_inve_ite' => $this->db->escape_like_str(0),
                                'delete_inv_cat' => $this->db->escape_like_str(0),
                                'inve_issu' => $this->db->escape_like_str(0),
                                'delete_inven_issu' => $this->db->escape_like_str(0),
                                'check_leav_appli' => $this->db->escape_like_str(0),
                                'setting_manage_user' => $this->db->escape_like_str(0),
                                'setting_accounts' => $this->db->escape_like_str(0),
                                'other_setting' => $this->db->escape_like_str(0),
                                'front_setings' => $this->db->escape_like_str(0),
                            );
                            if ($this->db->insert('role_based_access', $Choir_member_access)) {
                                $data['success'] = '<div class="alert alert-info alert-dismissable admisionSucceassMessageFont">
                                                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button"></button>
                                                                    <strong>Success!</strong> The Choir_member admitted successfully.
                                                            </div>';
                                //Load the admission form again for new Choir_member. 
                                $data['s_Choir'] = $this->common->getAllData('Choir');
                                $this->load->view('temp/header');
                                $this->load->view('add_new_Choir_member', $data);
                                $this->load->view('temp/footer');
                            }
                        }
                    }
                }
            }
        } else {
            $query = $this->common->countryPhoneCode();
            $data['countryPhoneCode'] = $query->countryPhonCode;
            $data['s_Choir'] = $this->common->getAllData('Choir');
            //display the create user form
            $this->load->view('temp/header');
            $this->load->view('add_new_Choir_member', $data);
            $this->load->view('temp/footer');
        }
    }

    //This function add section_leader in this function
    function addSection_leader() {
       

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('auth', 'refresh');
        }
        
        if ($this->input->post('submit', TRUE)) {
            $this->load->database();
            $tables = $this->config->item('tables', 'ion_auth');
            $edu_1 = '';
           
            $edu_2 = '';
            $edu_3 = '';
            $edu_4 = '';
            $edu_5 = '';
            $dd_1 = $this->input->post('dd_1', TRUE);
            if (!empty($dd_1)) {
                $this->form_validation->set_rules('scu_1', 'School/College/University 1st fild', 'required');
                $this->form_validation->set_rules('result_1', 'Result  1st fild', 'required');
                $this->form_validation->set_rules('paYear_1', 'Passing year 1st fild', 'required');
                $edu_1 = $this->input->post('dd_1', TRUE) . ',' . $this->input->post('scu_1', TRUE) . ',' . $this->input->post('result_1', TRUE) . ',' . $this->input->post('paYear_1', TRUE);
            }

            $dd_2 = $this->input->post('dd_2', TRUE);
            if (!empty($dd_2)) {
                $this->form_validation->set_rules('scu_2', 'School/College/University 2st fild', 'required');
                $this->form_validation->set_rules('result_2', 'Result  2st fild', 'required');
                $this->form_validation->set_rules('paYear_2', 'Passing year 2st fild', 'required');
                $edu_2 = $this->input->post('dd_2', TRUE) . ',' . $this->input->post('scu_2', TRUE) . ',' . $this->input->post('result_2', TRUE) . ',' . $this->input->post('paYear_2', TRUE);
            }

            $dd_3 = $this->input->post('dd_3', TRUE);
            if (!empty($dd_3)) {
                $this->form_validation->set_rules('scu_3', 'School/College/University 3st fild', 'required');
                $this->form_validation->set_rules('result_3', 'Result  3st fild', 'required');
                $this->form_validation->set_rules('paYear_3', 'Passing year 3st fild', 'required');
                $edu_3 = $this->input->post('dd_3', TRUE) . ',' . $this->input->post('scu_3', TRUE) . ',' . $this->input->post('result_3', TRUE) . ',' . $this->input->post('paYear_3', TRUE);
            }

            $dd_4 = $this->input->post('dd_4', TRUE);
            if (!empty($dd_4)) {
                $this->form_validation->set_rules('scu_4', 'School/College/University 4st fild', 'required');
                $this->form_validation->set_rules('result_4', 'Result  4st fild', 'required');
                $this->form_validation->set_rules('paYear_4', 'Passing year 4st fild', 'required');
                $edu_4 = $this->input->post('dd_4', TRUE) . ',' . $this->input->post('scu_4', TRUE) . ',' . $this->input->post('result_4', TRUE) . ',' . $this->input->post('paYear_4', TRUE);
            }

            $dd_5 = $this->input->post('dd_5', TRUE);
            if (!empty($dd_5)) {
                $this->form_validation->set_rules('scu_5', 'School/College/University 5st fild', 'required');
                $this->form_validation->set_rules('result_5', 'Result  5st fild', 'required');
                $this->form_validation->set_rules('paYear_5', 'Passing year 5st fild', 'required');
                $edu_5 = $this->input->post('dd_5', TRUE) . ',' . $this->input->post('scu_5', TRUE) . ',' . $this->input->post('result_5', TRUE) . ',' . $this->input->post('paYear_5', TRUE);
            }

            $username = $this->input->post('first_name') . ' ' . $this->input->post('last_name');
            $email = strtolower($this->input->post('email', TRUE));
            $password = $this->input->post('password', TRUE);
            $phone = $this->input->post('phoneCode', TRUE) . '' . $this->input->post('phone', TRUE);

            //here is upload the section_leader's photo.
            $config['upload_path'] = './assets/uploads/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '10000';
            $config['max_width'] = '10240';
            $config['max_height'] = '7680';
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->do_upload();
            $uploadFileInfo = $this->upload->data();

            //This array information's are sending to "user" table as a core information as a user this system.
            $additional_data = array(
                'first_name' => $this->db->escape_like_str($this->input->post('first_name', TRUE)),
                'last_name' => $this->db->escape_like_str($this->input->post('last_name', TRUE)),
                'phone' => $this->db->escape_like_str($phone),
                'profile_image' => $this->db->escape_like_str($uploadFileInfo['file_name']),
                'leave_status' => $this->db->escape_like_str('Available'),
                'user_status' => $this->db->escape_like_str('Employee'),
                'section' => $this->db->escape_like_str($this->input->post('section', TRUE)),
                    'Choir_id' => $this->db->escape_like_str($this->input->post('Choir_id', TRUE)),

            );

            $group_ids = array(
                'group_id' => $this->db->escape_like_str(4)
            );
            if ($this->ion_auth->register($username, $password, $email, $additional_data, $group_ids)) {

                
                //This the next user id in users table. If we " -1 " from it we can get current user id 
                $userid = $this->common->usersId();
                //This array information's are sending to "section_leaders_info" table.
                $section_leadersInfo = array(
                    'user_id' => $this->db->escape_like_str($userid),
                    'fullname' => $this->db->escape_like_str($username),
                    'farther_name' => $this->db->escape_like_str($this->input->post('father_name', TRUE)),
                    'mother_name' => $this->db->escape_like_str($this->input->post('mother_name', TRUE)),
                    'Choir_id' => $this->db->escape_like_str($this->input->post('Choir_id', TRUE)),
                    'section' => $this->db->escape_like_str($this->input->post('section', TRUE)),

                    'birth_date' => $this->db->escape_like_str($this->input->post('birthdate', TRUE)),
                    'sex' => $this->db->escape_like_str($this->input->post('sex', TRUE)),
                    'present_address' => $this->db->escape_like_str($this->input->post('present_address', TRUE)),
                    'permanent_address' => $this->db->escape_like_str($this->input->post('permanent_address', TRUE)),
                    'song' => $this->db->escape_like_str($this->input->post('facultiesSong', TRUE)),
                    'position' => $this->db->escape_like_str($this->input->post('position', TRUE)),
                    'index_no' => $this->db->escape_like_str($this->input->post('indexNo', TRUE)),
                    'working_hour' => $this->db->escape_like_str($this->input->post('workingHoure', TRUE)),
                    'educational_qualification_1' => $this->db->escape_like_str($edu_1),
                    'educational_qualification_2' => $this->db->escape_like_str($edu_2),
                    'educational_qualification_3' => $this->db->escape_like_str($edu_3),
                    'educational_qualification_4' => $this->db->escape_like_str($edu_4),
                    'educational_qualification_5' => $this->db->escape_like_str($edu_5),
                    'cv' => $this->db->escape_like_str($this->input->post('cv', TRUE)),
                    'educational_certificat' => $this->db->escape_like_str($this->input->post('educational_certificat', TRUE)),
                    'exprieance_certificatte' => $this->db->escape_like_str($this->input->post('exc', TRUE)),
                    'files_info' => $this->db->escape_like_str($this->input->post('submited_info', TRUE)),
                    'phone' => $this->db->escape_like_str($phone),
                );

                $section_leader_access = array(
                    'user_id' => $this->db->escape_like_str($userid),
                    'group_id' => $this->db->escape_like_str(4),
                    'das_top_info' => $this->db->escape_like_str(1),
                    'das_grab_chart' => $this->db->escape_like_str(0),
                    'das_Choir_info' => $this->db->escape_like_str(1),
                    'das_message' => $this->db->escape_like_str(1),
                    'das_employ_attend' => $this->db->escape_like_str(0),
                    'das_notice' => $this->db->escape_like_str(1),
                    'das_calender' => $this->db->escape_like_str(1),
                    'admission' => $this->db->escape_like_str(0),
                    'all_Choir_member_info' => $this->db->escape_like_str(1),
                    'stud_edit_delete' => $this->db->escape_like_str(0),
                    'stu_own_info' => $this->db->escape_like_str(0),
                    'section_leader_info' => $this->db->escape_like_str(0),
                    'add_section_leader' => $this->db->escape_like_str(0),
                    'section_leader_details' => $this->db->escape_like_str(0),
                    'section_leader_edit_delete' => $this->db->escape_like_str(0),
                    'all_section_trainers_info' => $this->db->escape_like_str(1),
                    'own_section_trainers_info' => $this->db->escape_like_str(0),
                    'make_section_trainers_id' => $this->db->escape_like_str(0),
                    'section_trainers_edit_dlete' => $this->db->escape_like_str(0),
                    'add_new_Choir' => $this->db->escape_like_str(0),
                    'all_Choir_info' => $this->db->escape_like_str(1),
                    'Choir_details' => $this->db->escape_like_str(1),
                    'Choir_delete' => $this->db->escape_like_str(0),
                    'Choir_promotion' => $this->db->escape_like_str(0),
                    'assin_optio_sub' => $this->db->escape_like_str(0),
                    'add_Choir_routine' => $this->db->escape_like_str(0),
                    'own_Choir_routine' => $this->db->escape_like_str(0),
                    'all_Choir_routine' => $this->db->escape_like_str(1),
                    'rutin_edit_delete' => $this->db->escape_like_str(0),
                    'attendance_preview' => $this->db->escape_like_str(1),
                    'take_studence_atten' => $this->db->escape_like_str(1),
                    'edit_Choir_member_atten' => $this->db->escape_like_str(0),
                    'add_employee' => $this->db->escape_like_str(0),
                    'employee_list' => $this->db->escape_like_str(0),
                    'employ_attendance' => $this->db->escape_like_str(0),
                    'empl_atte_view' => $this->db->escape_like_str(0),
                    'add_song' => $this->db->escape_like_str(0),
                    'all_song' => $this->db->escape_like_str(1),
                    'make_suggestion' => $this->db->escape_like_str(1),
                    'all_suggestion' => $this->db->escape_like_str(1),
                    'own_suggestion' => $this->db->escape_like_str(0),
                    'add_rehearsal_gread' => $this->db->escape_like_str(0),
                    'rehearsal_gread' => $this->db->escape_like_str(1),
                    'add_rehearsal_routin' => $this->db->escape_like_str(0),
                    'all_rehearsal_routine' => $this->db->escape_like_str(1),
                    'own_rehearsal_routine' => $this->db->escape_like_str(0),
                    'rehearsal_attend_preview' => $this->db->escape_like_str(1),
                    'approve_result' => $this->db->escape_like_str(0),
                    'view_result' => $this->db->escape_like_str(1),
                    'all_mark_sheet' => $this->db->escape_like_str(1),
                    'own_mark_sheet' => $this->db->escape_like_str(0),
                    'take_rehearsal_attend' => $this->db->escape_like_str(1),
                    'change_rehearsal_attendance' => $this->db->escape_like_str(0),
                    'make_result' => $this->db->escape_like_str(1),
                    'add_category' => $this->db->escape_like_str(0),
                    'all_category' => $this->db->escape_like_str(1),
                    'edit_delete_category' => $this->db->escape_like_str(0),
                    'add_resources' => $this->db->escape_like_str(0),
                    'all_resources' => $this->db->escape_like_str(1),
                    'edit_delete_resources' => $this->db->escape_like_str(0),
                    'add_library_mem' => $this->db->escape_like_str(0),
                    'memb_list' => $this->db->escape_like_str(0),
                    'issu_return' => $this->db->escape_like_str(0),
                    'add_concerts' => $this->db->escape_like_str(0),
                    'add_set_dormi' => $this->db->escape_like_str(0),
                    'set_member_seat' => $this->db->escape_like_str(0),
                    'dormi_report' => $this->db->escape_like_str(1),
                    'add_transport' => $this->db->escape_like_str(0),
                    'all_transport' => $this->db->escape_like_str(1),
                    'transport_edit_dele' => $this->db->escape_like_str(0),
                    'add_account_title' => $this->db->escape_like_str(0),
                    'edit_dele_acco' => $this->db->escape_like_str(0),
                    'trensection' => $this->db->escape_like_str(0),
                    'fee_collection' => $this->db->escape_like_str(1),
                    'all_slips' => $this->db->escape_like_str(1),
                    'own_slip' => $this->db->escape_like_str(0),
                    'slip_edit_delete' => $this->db->escape_like_str(0),
                    'pay_salary' => $this->db->escape_like_str(0),
                    'creat_notice' => $this->db->escape_like_str(0),
                    'send_message' => $this->db->escape_like_str(1),
                    'vendor' => $this->db->escape_like_str(0),
                    'delet_vendor' => $this->db->escape_like_str(0),
                    'add_inv_cat' => $this->db->escape_like_str(0),
                    'inve_item' => $this->db->escape_like_str(0),
                    'delete_inve_ite' => $this->db->escape_like_str(0),
                    'delete_inv_cat' => $this->db->escape_like_str(0),
                    'inve_issu' => $this->db->escape_like_str(0),
                    'delete_inven_issu' => $this->db->escape_like_str(0),
                    'check_leav_appli' => $this->db->escape_like_str(0),
                    'setting_manage_user' => $this->db->escape_like_str(0),
                    'setting_accounts' => $this->db->escape_like_str(0),
                    'other_setting' => $this->db->escape_like_str(0),
                    'front_setings' => $this->db->escape_like_str(0),
                );

                $this->db->insert('section_leaders_info', $section_leadersInfo);
                if ($this->db->insert('role_based_access', $section_leader_access)) {
                    //Load the Section_leaders Information's page after Add New Section_leader.
                    redirect('section_leaders/section_leadersInfomration', 'refresh');
                }
            } else {
                $query = $this->common->countryPhoneCode();
                $data['countryPhoneCode'] = $query->countryPhonCode;
                //display the create user form
                $this->load->view('temp/header');
                $this->load->view('add_new_section_leader', $data);
                $this->load->view('temp/footer');
            }
        } else {
            $query = $this->common->countryPhoneCode();
            $data['countryPhoneCode'] = $query->countryPhonCode;
            //display the create user form
            $this->load->view('temp/header');
            $this->load->view('add_new_section_leader', $data);
            $this->load->view('temp/footer');
        }
    }

    //This function is returning Choir_member id and roll number by class title , runing year
    public function Choir_member_info() {
        $Choir_id = $this->input->get('q', TRUE);
        $query = $this->common->getWhere('Choir', 'id', $Choir_id);
        foreach ($query as $row) {
            $data = $row;
        }
        $Choir_code = $data['ChoirCode'];
        //making here Choir Section fild.
        if (!empty($data['section'])) {
            $section = $data['section'];
            $sectionArray = explode(",", $section);
            echo '<div class="form-group">
                        <label class="col-md-3 control-label">section <span class="requiredStar"> * </span></label>
                        <div class="col-md-6">
                            <select name="section" class="form-control">
                                <option value="">Select one</option>';
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

        //making here Choir_memberID Unick number.
        if (strlen($Choir_code) == 1) {
            $ChoirId = '0' . $Choir_code;
        } elseif (strlen($Choir_code) == 2) {
            $ChoirId = $Choir_code;
        }
        $roll = $this->common->rollNumber($Choir_id);
        if (strlen($roll) == 1) {
            $rollNumber = '00' . $roll;
        } elseif (strlen($roll) == 2) {
            $rollNumber = '0' . $roll;
        } elseif (strlen($roll) == 3) {
            $rollNumber = $roll;
        }
        $finalChoir_memberId = date("Y") . $ChoirId . $rollNumber;

        echo '<div class="form-group">
                    <label class="col-md-3 control-label">Choir_member\'s ID <span class="requiredStar"> * </span></label>
                    <div class="col-md-6">
                        <input type="text" name="Choir_member_id" class="form-control" value="' . $finalChoir_memberId . '" readonly>
                    </div>
                </div>';


        //making here Choir Roll Number fild.
        echo '<div class="form-group">
                    <label class="col-md-3 control-label">Roll Number <span class="requiredStar"> * </span></label>
                    <div class="col-md-6">
                        <input type="text" name="roll_number" class="form-control" value="' . $rollNumber . '" readonly>
                    </div>
                </div>';
    }

    public function Section_trainer_info() {
        $Choir_id = $this->input->get('q', TRUE);
        $query = $this->common->getWhere('Choir', 'id', $Choir_id);
        error_log("Choir ID: " . $Choir_id);

        foreach ($query as $row) {
            $data = $row;
        }
        $Choir_code = $data['ChoirCode'];
        //making here Choir Section fild.
        if (!empty($data['section'])) {
            $section = $data['section'];
            $sectionArray = explode(",", $section);
            echo '<div class="form-group">
                        <label class="col-md-3 control-label">section <span class="requiredStar"> * </span></label>
                        <div class="col-md-6">
                            <select name="section" class="form-control">
                                <option value="">Select one</option>';
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

    //This function is using for add new section_trainers
    function addSection_trainers() {
        if ($this->input->post('submit', TRUE)) {
            // Fetch Choir ID and Section
        $Choir_id = $this->db->escape_like_str($this->input->post('Choir', TRUE));
         $Choir_title = $this->common->Choir_title($Choir_id);

$section = $this->db->escape_like_str($this->input->post('section', TRUE));

// Include these in your data array for database insertion
$additional_data['Choir_id'] = $Choir_id;
$additional_data['section'] = $section;

$section_leadersInfo['Choir_id'] = $Choir_id;
$section_leadersInfo['section'] = $section;
$section_leadersInfo['Choir_title'] = $Choir_title;

$username = $this->input->post('first_name') . ' ' . $this->input->post('last_name');
$email = strtolower($this->input->post('email', TRUE));
$password = $this->input->post('password', TRUE);
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
$this->upload->display_errors('<p>', '</p>');

$phone = $this->input->post('phoneCode', TRUE) . '' . $this->input->post('phone', TRUE);
$additional_data = array(
'first_name' => $this->db->escape_like_str($this->input->post('first_name', TRUE)),
'last_name' => $this->db->escape_like_str($this->input->post('last_name', TRUE)),
'phone' => $this->db->escape_like_str($phone),
'profile_image' => $this->db->escape_like_str($uploadFileInfo['file_name'])
);
$group_ids = array(
'group_id' => $this->db->escape_like_str(5)
);
if ($this->ion_auth->register($username, $password, $email, $additional_data, $group_ids)) {
//This the next user id in users table. If we " -1 " from it we can get current user id 
$userid = $this->common->usersId();
$additionalData1 = array(
    'user_id' => $this->db->escape_like_str($userid),
    'Choir_member_id' => $this->db->escape_like_str($this->input->post('Choir_memberId', TRUE)),
    'Choir_title' => $this->db->escape_like_str($Choir_title),
    'Choir_id' => $this->db->escape_like_str($Choir_id),
    'section' => $this->db->escape_like_str($this->input->post('section', TRUE)),
    'section_trainers_name' => $this->db->escape_like_str($username),
    'level' => $this->db->escape_like_str($this->input->post('guardianLevel', TRUE)),
    'email' => $this->db->escape_like_str($this->input->post('email', TRUE)),
    'phone' => $this->db->escape_like_str($phone)
);
$this->db->insert('section_trainers_info', $additionalData1);
$section_trainers_access = array(
    'user_id' => $this->db->escape_like_str($userid),
    'group_id' => $this->db->escape_like_str(5),
    'das_top_info' => $this->db->escape_like_str(0),
    'Choir_title' => $this->db->escape_like_str($Choir_title),
    'Choir_id' => $this->db->escape_like_str($Choir_id),
    'section' => $this->db->escape_like_str($this->input->post('section', TRUE)),
    'das_grab_chart' => $this->db->escape_like_str(0),
    'das_Choir_info' => $this->db->escape_like_str(0),
    'das_message' => $this->db->escape_like_str(1),
    'das_employ_attend' => $this->db->escape_like_str(0),
    'das_notice' => $this->db->escape_like_str(1),
    'das_calender' => $this->db->escape_like_str(1),
    'admission' => $this->db->escape_like_str(0),
    'all_Choir_member_info' => $this->db->escape_like_str(0),
    'stud_edit_delete' => $this->db->escape_like_str(0),
    'stu_own_info' => $this->db->escape_like_str(1),
    'section_leader_info' => $this->db->escape_like_str(1),
    'add_section_leader' => $this->db->escape_like_str(0),
    'section_leader_details' => $this->db->escape_like_str(0),
    'section_leader_edit_delete' => $this->db->escape_like_str(0),
    'all_section_trainers_info' => $this->db->escape_like_str(0),
    'own_section_trainers_info' => $this->db->escape_like_str(1),
    'make_section_trainers_id' => $this->db->escape_like_str(0),
    'section_trainers_edit_dlete' => $this->db->escape_like_str(0),
    'add_new_Choir' => $this->db->escape_like_str(0),
    'all_Choir_info' => $this->db->escape_like_str(0),
    'Choir_details' => $this->db->escape_like_str(0),
    'Choir_delete' => $this->db->escape_like_str(0),
    'Choir_promotion' => $this->db->escape_like_str(0),
    'assin_optio_sub' => $this->db->escape_like_str(0),
    'add_Choir_routine' => $this->db->escape_like_str(0),
    'own_Choir_routine' => $this->db->escape_like_str(1),
    'all_Choir_routine' => $this->db->escape_like_str(0),
    'rutin_edit_delete' => $this->db->escape_like_str(0),
    'attendance_preview' => $this->db->escape_like_str(0),
    'take_studence_atten' => $this->db->escape_like_str(0),
    'edit_Choir_member_atten' => $this->db->escape_like_str(0),
    'add_employee' => $this->db->escape_like_str(0),
    'employee_list' => $this->db->escape_like_str(0),
    'employ_attendance' => $this->db->escape_like_str(0),
    'empl_atte_view' => $this->db->escape_like_str(0),
    'add_song' => $this->db->escape_like_str(0),
    'all_song' => $this->db->escape_like_str(0),
    'make_suggestion' => $this->db->escape_like_str(0),
    'all_suggestion' => $this->db->escape_like_str(0),
    'own_suggestion' => $this->db->escape_like_str(1),
    'add_rehearsal_gread' => $this->db->escape_like_str(0),
    'rehearsal_gread' => $this->db->escape_like_str(0),
    'add_rehearsal_routin' => $this->db->escape_like_str(0),
    'all_rehearsal_routine' => $this->db->escape_like_str(0),
    'own_rehearsal_routine' => $this->db->escape_like_str(1),
    'rehearsal_attend_preview' => $this->db->escape_like_str(0),
    'approve_result' => $this->db->escape_like_str(0),
    'view_result' => $this->db->escape_like_str(1),
    'all_mark_sheet' => $this->db->escape_like_str(0),
    'own_mark_sheet' => $this->db->escape_like_str(1),
    'take_rehearsal_attend' => $this->db->escape_like_str(0),
    'change_rehearsal_attendance' => $this->db->escape_like_str(0),
    'make_result' => $this->db->escape_like_str(0),
    'add_category' => $this->db->escape_like_str(0),
    'all_category' => $this->db->escape_like_str(1),
    'edit_delete_category' => $this->db->escape_like_str(0),
    'add_resources' => $this->db->escape_like_str(0),
    'all_resources' => $this->db->escape_like_str(1),
    'edit_delete_resources' => $this->db->escape_like_str(0),
    'add_library_mem' => $this->db->escape_like_str(0),
    'memb_list' => $this->db->escape_like_str(0),
    'issu_return' => $this->db->escape_like_str(0),
    'add_concerts' => $this->db->escape_like_str(0),
    'add_set_dormi' => $this->db->escape_like_str(0),
    'set_member_seat' => $this->db->escape_like_str(0),
    'dormi_report' => $this->db->escape_like_str(1),
    'add_transport' => $this->db->escape_like_str(0),
    'all_transport' => $this->db->escape_like_str(1),
    'transport_edit_dele' => $this->db->escape_like_str(0),
    'add_account_title' => $this->db->escape_like_str(0),
    'edit_dele_acco' => $this->db->escape_like_str(0),
    'trensection' => $this->db->escape_like_str(0),
    'fee_collection' => $this->db->escape_like_str(0),
    'all_slips' => $this->db->escape_like_str(0),
    'own_slip' => $this->db->escape_like_str(1),
    'slip_edit_delete' => $this->db->escape_like_str(0),
    'pay_salary' => $this->db->escape_like_str(0),
    'creat_notice' => $this->db->escape_like_str(0),
    'send_message' => $this->db->escape_like_str(0),
    'vendor' => $this->db->escape_like_str(0),
    'delet_vendor' => $this->db->escape_like_str(0),
    'add_inv_cat' => $this->db->escape_like_str(0),
    'inve_item' => $this->db->escape_like_str(0),
    'delete_inve_ite' => $this->db->escape_like_str(0),
    'delete_inv_cat' => $this->db->escape_like_str(0),
    'inve_issu' => $this->db->escape_like_str(0),
    'delete_inven_issu' => $this->db->escape_like_str(0),
    'check_leav_appli' => $this->db->escape_like_str(0),
    'setting_manage_user' => $this->db->escape_like_str(0),
    'setting_accounts' => $this->db->escape_like_str(0),
    'other_setting' => $this->db->escape_like_str(0),
    'front_setings' => $this->db->escape_like_str(0),
);
if ($this->db->insert('role_based_access', $section_trainers_access)) {
    //check to see if we are creating the user
    //redirect them back to the admin page
    $this->session->set_flashdata('message', $this->ion_auth->messages());

    //redirect("section_trainers/section_trainersInformation", 'refresh');

    $data['s_Choir'] = $this->common->getAllData('Choir');
    $data['success'] = '<div class="col-md-12"><div class="alert alert-info alert-dismissable admisionSucceassMessageFont">
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button"></button>
                                        <strong>Success!</strong> The section_trainers profile made successfully.
                                </div></div>';
    $this->load->view('temp/header');
    $this->load->view('makeProfile', $data);
    $this->load->view('temp/footer');
}
}
} else {
$query = $this->common->countryPhoneCode();
$data['countryPhoneCode'] = $query->countryPhonCode;
$data['s_Choir'] = $this->common->getAllData('Choir');
$this->load->view('temp/header');
$this->load->view('makeProfile', $data);
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
                            <strong>Info:</strong> This Choir_member ID <strong>' . $Choir_memberId . '</strong> is not matching in our Choir_member\'s list.
                    </div></div></div>';
        } else {
            echo '<div class="col-md-9 col-md-offset-1 stuInfoIdBox">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Choir_member\'s Name <span class="requiredStar">  </span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="Choir_memberName" value="' . $query->Choir_member_nam . '" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Choir <span class="requiredStar">  </span></label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="Choir_title" value="' . $this->common->Choir_title($query->Choir_id) . '" readonly>
                            </div>
                        </div>
                        <input type="hidden" name="Choir_id" value="' . $query->Choir_id . '">
                    </div>
                    <div class="col-md-2">
                        <img src="assets/uploads/' . $query->Choir_member_photo . '" class="img-responsive" alt=""><br>
                    </div>
                </div>';
        }
    }

    public function Choir_InfoById() {
        $Choir_id = $this->input->get('q', TRUE);
        if (empty($Choir_id)) {
            echo 'No valid Choir ID provided.';
            return; // Exit if no ID is provided
        }
        $query = $this->common->ChoirIdInfo($Choir_id);
        // rest of the function...
    }
    


    //Whene give the Choir_member id from the frontend input file.
    //Then this function return Choir_member information
//    public function ajaxChoir_memberInfo() {
//        $ChoirTitle = $this->input->get('q', TRUE);
//        $query = $this->common->getWhere('Choir_member_info', 'Choir', $ChoirTitle);
//        foreach ($query as $row) {
//            $data[] = $row;
//        }
//        if (!empty($data)) {
//            echo '<div class="form-group">
//                        <label class="col-md-3 control-label"></label>
//                        <div class="col-md-6">
//                            <select name="Choir_memberID" class="form-control">
//                                <option value="all">Select Choir_member ID</option>';
//            foreach ($data as $sec) {
//                echo '<option value="' . $sec['Choir_member_id'] . '">' . $sec['Choir_member_nam'] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ID - <span>' . $sec['Choir_member_id'] . '</span></option>';
//            }
//            echo '</select></div>
//                    </div>';
//        } else {
//            echo '<div class="form-group">
//                    <label class="col-md-3 control-label"></label>
//                        <div class="col-md-6">
//                        <div class="alert alert-danger">
//                            <strong>Info:</strong> This Choir has no Choir_member.
//                    </div></div></div>';
//        }
//    }
    //This function will add new users in this system as Accountent,Libreament &Drivers etc
    public function addNewUsers() {
        if ($this->input->post('submit', TRUE)) {
            $this->load->database();
            $tables = $this->config->item('tables', 'ion_auth');
            $edu_1 = '';
            $edu_2 = '';
            $edu_3 = '';
            $edu_4 = '';
            $edu_5 = '';
            $dd_1 = $this->input->post('dd_1', TRUE);
            if (!empty($dd_1)) {
                $this->form_validation->set_rules('scu_1', 'School/College/University 1st fild', 'required');
                $this->form_validation->set_rules('result_1', 'Result  1st fild', 'required');
                $this->form_validation->set_rules('paYear_1', 'Passing year 1st fild', 'required');
                $edu_1 = $this->input->post('dd_1', TRUE) . ',' . $this->input->post('scu_1', TRUE) . ',' . $this->input->post('result_1', TRUE) . ',' . $this->input->post('paYear_1', TRUE);
            }

            $dd_2 = $this->input->post('dd_2', TRUE);
            if (!empty($dd_2)) {
                $this->form_validation->set_rules('scu_2', 'School/College/University 2st fild', 'required');
                $this->form_validation->set_rules('result_2', 'Result  2st fild', 'required');
                $this->form_validation->set_rules('paYear_2', 'Passing year 2st fild', 'required');
                $edu_2 = $this->input->post('dd_2', TRUE) . ',' . $this->input->post('scu_2', TRUE) . ',' . $this->input->post('result_2', TRUE) . ',' . $this->input->post('paYear_2', TRUE);
            }

            $dd_3 = $this->input->post('dd_3', TRUE);
            if (!empty($dd_3)) {
                $this->form_validation->set_rules('scu_3', 'School/College/University 3st fild', 'required');
                $this->form_validation->set_rules('result_3', 'Result  3st fild', 'required');
                $this->form_validation->set_rules('paYear_3', 'Passing year 3st fild', 'required');
                $edu_3 = $this->input->post('dd_3', TRUE) . ',' . $this->input->post('scu_3', TRUE) . ',' . $this->input->post('result_3', TRUE) . ',' . $this->input->post('paYear_3', TRUE);
            }

            $dd_4 = $this->input->post('dd_4', TRUE);
            if (!empty($dd_4)) {
                $this->form_validation->set_rules('scu_4', 'School/College/University 4st fild', 'required');
                $this->form_validation->set_rules('result_4', 'Result  4st fild', 'required');
                $this->form_validation->set_rules('paYear_4', 'Passing year 4st fild', 'required');
                $edu_4 = $this->input->post('dd_4', TRUE) . ',' . $this->input->post('scu_4', TRUE) . ',' . $this->input->post('result_4', TRUE) . ',' . $this->input->post('paYear_4', TRUE);
            }

            $dd_5 = $this->input->post('dd_5', TRUE);
            if (!empty($dd_5)) {
                $this->form_validation->set_rules('scu_5', 'School/College/University 5st fild', 'required');
                $this->form_validation->set_rules('result_5', 'Result  5st fild', 'required');
                $this->form_validation->set_rules('paYear_5', 'Passing year 5st fild', 'required');
                $edu_5 = $this->input->post('dd_5', TRUE) . ',' . $this->input->post('scu_5', TRUE) . ',' . $this->input->post('result_5', TRUE) . ',' . $this->input->post('paYear_5', TRUE);
            }

            $username = $this->input->post('first_name') . ' ' . $this->input->post('last_name');
            $email = strtolower($this->input->post('email', TRUE));
            $password = $this->input->post('password', TRUE);
            $phone = $this->input->post('phoneCode', TRUE) . '' . $this->input->post('phone', TRUE);

            //here is upload the section_leader's photo.
            $config['upload_path'] = './assets/uploads/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '10000';
            $config['max_width'] = '10240';
            $config['max_height'] = '7680';
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->do_upload();
            $uploadFileInfo = $this->upload->data();

            //This array information's are sending to "user" table as a core information as a user this system.
            $additional_data = array(
                'first_name' => $this->db->escape_like_str($this->input->post('first_name', TRUE)),
                'last_name' => $this->db->escape_like_str($this->input->post('last_name', TRUE)),
                'phone' => $this->db->escape_like_str($phone),
                'profile_image' => $this->db->escape_like_str($uploadFileInfo['file_name']),
                'leave_status' => $this->db->escape_like_str('Available'),
                'user_status' => $this->db->escape_like_str('Employee')
            );

            $group_ids = array(
                'group_id' => $this->db->escape_like_str($this->input->post('group', TRUE))
            );
            if ($this->ion_auth->register($username, $password, $email, $additional_data, $group_ids)) {
                //This the next user id in users table. If we " -1 " from it we can get current user id 
                $userid = $this->common->usersId();
                //This array information's are sending to "section_leaders_info" table.
                $additional_data2 = array(
                    'user_id' => $this->db->escape_like_str($userid),
                    'full_name' => $this->db->escape_like_str($username),
                    'farther_name' => $this->db->escape_like_str($this->input->post('father_name', TRUE)),
                    'mother_name' => $this->db->escape_like_str($this->input->post('mother_name', TRUE)),
                    'birth_date' => $this->db->escape_like_str($this->input->post('birthdate', TRUE)),
                    'sex' => $this->db->escape_like_str($this->input->post('sex', TRUE)),
                    'present_address' => $this->db->escape_like_str($this->input->post('present_address', TRUE)),
                    'permanent_address' => $this->db->escape_like_str($this->input->post('permanent_address', TRUE)),
                    'group_id' => $this->db->escape_like_str($this->input->post('group', TRUE)),
                    'group_id' => $this->db->escape_like_str($this->input->post('group', TRUE)),
                    'working_hour' => $this->db->escape_like_str($this->input->post('workingHoure', TRUE)),
                    'educational_qualification_1' => $this->db->escape_like_str($edu_1),
                    'educational_qualification_2' => $this->db->escape_like_str($edu_2),
                    'educational_qualification_3' => $this->db->escape_like_str($edu_3),
                    'educational_qualification_4' => $this->db->escape_like_str($edu_4),
                    'educational_qualification_5' => $this->db->escape_like_str($edu_5),
                    'users_photo' => $this->db->escape_like_str($uploadFileInfo['file_name']),
                    'cv' => $this->db->escape_like_str($this->input->post('cv', TRUE)),
                    'educational_certificat' => $this->db->escape_like_str($this->input->post('educational_certificat', TRUE)),
                    'exprieance_certificatte' => $this->db->escape_like_str($this->input->post('exc', TRUE)),
                    'files_info' => $this->db->escape_like_str($this->input->post('submited_info', TRUE)),
                    'phone' => $this->db->escape_like_str($phone)
                );
                $user_access = array(
                    'user_id' => $this->db->escape_like_str($userid),
                    'group_id' => $this->db->escape_like_str($this->input->post('group', TRUE)),
                    'das_top_info' => $this->db->escape_like_str(0),
                    'das_grab_chart' => $this->db->escape_like_str(0),
                    'das_Choir_info' => $this->db->escape_like_str(0),
                    'das_message' => $this->db->escape_like_str(0),
                    'das_employ_attend' => $this->db->escape_like_str(0),
                    'das_notice' => $this->db->escape_like_str(0),
                    'das_calender' => $this->db->escape_like_str(0),
                    'admission' => $this->db->escape_like_str(0),
                    'all_Choir_member_info' => $this->db->escape_like_str(0),
                    'stud_edit_delete' => $this->db->escape_like_str(0),
                    'stu_own_info' => $this->db->escape_like_str(0),
                    'section_leader_info' => $this->db->escape_like_str(0),
                    'add_section_leader' => $this->db->escape_like_str(0),
                    'section_leader_details' => $this->db->escape_like_str(0),
                    'section_leader_edit_delete' => $this->db->escape_like_str(0),
                    'all_section_trainers_info' => $this->db->escape_like_str(0),
                    'own_section_trainers_info' => $this->db->escape_like_str(0),
                    'make_section_trainers_id' => $this->db->escape_like_str(0),
                    'section_trainers_edit_dlete' => $this->db->escape_like_str(0),
                    'add_new_Choir' => $this->db->escape_like_str(0),
                    'all_Choir_info' => $this->db->escape_like_str(0),
                    'Choir_details' => $this->db->escape_like_str(0),
                    'Choir_delete' => $this->db->escape_like_str(0),
                    'Choir_promotion' => $this->db->escape_like_str(0),
                    'assin_optio_sub' => $this->db->escape_like_str(0),
                    'add_Choir_routine' => $this->db->escape_like_str(0),
                    'own_Choir_routine' => $this->db->escape_like_str(0),
                    'all_Choir_routine' => $this->db->escape_like_str(0),
                    'rutin_edit_delete' => $this->db->escape_like_str(0),
                    'attendance_preview' => $this->db->escape_like_str(0),
                    'take_studence_atten' => $this->db->escape_like_str(0),
                    'edit_Choir_member_atten' => $this->db->escape_like_str(0),
                    'add_employee' => $this->db->escape_like_str(0),
                    'employee_list' => $this->db->escape_like_str(0),
                    'employ_attendance' => $this->db->escape_like_str(0),
                    'empl_atte_view' => $this->db->escape_like_str(0),
                    'add_song' => $this->db->escape_like_str(0),
                    'all_song' => $this->db->escape_like_str(0),
                    'make_suggestion' => $this->db->escape_like_str(0),
                    'all_suggestion' => $this->db->escape_like_str(0),
                    'own_suggestion' => $this->db->escape_like_str(0),
                    'add_rehearsal_gread' => $this->db->escape_like_str(0),
                    'rehearsal_gread' => $this->db->escape_like_str(0),
                    'add_rehearsal_routin' => $this->db->escape_like_str(0),
                    'all_rehearsal_routine' => $this->db->escape_like_str(0),
                    'own_rehearsal_routine' => $this->db->escape_like_str(0),
                    'rehearsal_attend_preview' => $this->db->escape_like_str(0),
                    'approve_result' => $this->db->escape_like_str(0),
                    'view_result' => $this->db->escape_like_str(0),
                    'all_mark_sheet' => $this->db->escape_like_str(0),
                    'own_mark_sheet' => $this->db->escape_like_str(0),
                    'take_rehearsal_attend' => $this->db->escape_like_str(0),
                    'change_rehearsal_attendance' => $this->db->escape_like_str(0),
                    'make_result' => $this->db->escape_like_str(0),
                    'add_category' => $this->db->escape_like_str(0),
                    'all_category' => $this->db->escape_like_str(0),
                    'edit_delete_category' => $this->db->escape_like_str(0),
                    'add_resources' => $this->db->escape_like_str(0),
                    'all_resources' => $this->db->escape_like_str(0),
                    'edit_delete_resources' => $this->db->escape_like_str(0),
                    'add_library_mem' => $this->db->escape_like_str(0),
                    'memb_list' => $this->db->escape_like_str(0),
                    'issu_return' => $this->db->escape_like_str(0),
                    'add_concerts' => $this->db->escape_like_str(0),
                    'add_set_dormi' => $this->db->escape_like_str(0),
                    'set_member_seat' => $this->db->escape_like_str(0),
                    'dormi_report' => $this->db->escape_like_str(0),
                    'add_transport' => $this->db->escape_like_str(0),
                    'all_transport' => $this->db->escape_like_str(0),
                    'transport_edit_dele' => $this->db->escape_like_str(0),
                    'add_account_title' => $this->db->escape_like_str(0),
                    'edit_dele_acco' => $this->db->escape_like_str(0),
                    'trensection' => $this->db->escape_like_str(0),
                    'fee_collection' => $this->db->escape_like_str(0),
                    'all_slips' => $this->db->escape_like_str(0),
                    'own_slip' => $this->db->escape_like_str(0),
                    'slip_edit_delete' => $this->db->escape_like_str(0),
                    'pay_salary' => $this->db->escape_like_str(0),
                    'creat_notice' => $this->db->escape_like_str(0),
                    'send_message' => $this->db->escape_like_str(0),
                    'vendor' => $this->db->escape_like_str(0),
                    'delet_vendor' => $this->db->escape_like_str(0),
                    'add_inv_cat' => $this->db->escape_like_str(0),
                    'inve_item' => $this->db->escape_like_str(0),
                    'delete_inve_ite' => $this->db->escape_like_str(0),
                    'delete_inv_cat' => $this->db->escape_like_str(0),
                    'inve_issu' => $this->db->escape_like_str(0),
                    'delete_inven_issu' => $this->db->escape_like_str(0),
                    'check_leav_appli' => $this->db->escape_like_str(0),
                    'setting_manage_user' => $this->db->escape_like_str(0),
                    'setting_accounts' => $this->db->escape_like_str(0),
                    'other_setting' => $this->db->escape_like_str(0),
                    'front_setings' => $this->db->escape_like_str(0),
                );
                $this->db->insert('userinfo', $additional_data2);
                if ($this->db->insert('role_based_access', $user_access)) {
                    //Load the Section_leaders Information's page after Add New Section_leader.
                    redirect('users/allUserInafo', 'refresh');
                }
            } else {
                $query = $this->common->countryPhoneCode();
                $data['countryPhoneCode'] = $query->countryPhonCode;
                //display the create user form
                $this->load->view('temp/header');
                $this->load->view('addNewUser', $data);
                $this->load->view('temp/footer');
            }
        } else {
            $query = $this->common->countryPhoneCode();
            $data['countryPhoneCode'] = $query->countryPhonCode;
            //display the create user form
            $this->load->view('temp/header');
            $this->load->view('addNewUser', $data);
            $this->load->view('temp/footer');
        }
    }

    //This function will return user group id & title for adding new user.
    public function newUserGrope() {
        $groupId = $this->input->get('q', TRUE);
        if ($groupId == '6') {
            echo '<input type="hidden" name="group" value="6">';
            echo '<input type="hidden" name="groupTitle" value="Accountant">';
        } elseif ($groupId == '7') {
            echo '<input type="hidden" name="group" value="7">';
            echo '<input type="hidden" name="groupTitle" value="Library Man">';
        } elseif ($groupId == '8') {
            echo '<input type="hidden" name="group" value="8">';
            echo '<input type="hidden" name="groupTitle" value="Car Driver">';
        } elseif ($groupId == '9') {
            echo '<input type="hidden" name="group" value="9">';
            echo '<input type="hidden" name="groupTitle" value="4th Choir Employee">';
        }
    }

    //This function returan all user's informations
    public function allUserInafo() {
        $data = array();
        $data['usersInfo'] = $this->common->getAllData('userinfo');
        $this->load->view('temp/header');
        $this->load->view('allUserInfo', $data);
        $this->load->view('temp/footer');
    }

    //This function returan all user's informations detalis
    public function allUserInafoDetails() {
        $id = $this->input->get('id');
        $userId = $this->input->get('uid');
        $data['userinfo'] = $this->common->getWhere('userinfo', 'id', $id);
        $data['user'] = $this->common->getWhere('users', 'id', $userId);
        $this->load->view('temp/header');
        $this->load->view('allUserInafoDetails', $data);
        $this->load->view('temp/footer');
    }

    //This function is using for editing a section_leader informations
    //And admin an select group  
    function edit_user() {
        $userId = $this->input->get('uid');
        $userInfoId = $this->input->get('id');
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
            $username = $this->input->post('first_name') . ' ' . $this->input->post('last_name');

            $phone = $this->input->post('phone', TRUE);
//            $additional_data = array(
//                'username' => $this->db->escape_like_str($username),
//                'email' => $this->db->escape_like_str($this->input->post('email', TRUE)),
//                'first_name' => $this->db->escape_like_str($this->input->post('first_name', TRUE)),
//                'last_name' => $this->db->escape_like_str($this->input->post('last_name', TRUE)),
//                'phone' => $this->db->escape_like_str($phone),
//            );
//
//            $this->db->where('id', $userId);
//            $this->db->update('users', $additional_data);

            $additional_data2 = array(
                'full_name' => $this->db->escape_like_str($username),
                'farther_name' => $this->db->escape_like_str($this->input->post('father_name', TRUE)),
                'mother_name' => $this->db->escape_like_str($this->input->post('mother_name', TRUE)),
                'birth_date' => $this->db->escape_like_str($this->input->post('birthdate', TRUE)),
                'sex' => $this->db->escape_like_str($this->input->post('sex', TRUE)),
                'present_address' => $this->db->escape_like_str($this->input->post('present_address', TRUE)),
                'permanent_address' => $this->db->escape_like_str($this->input->post('permanent_address', TRUE)),
                'group_id' => $this->db->escape_like_str($this->input->post('group', TRUE)),
                'group_id' => $this->db->escape_like_str($this->input->post('group', TRUE)),
                'working_hour' => $this->db->escape_like_str($this->input->post('workingHoure', TRUE)),
                'educational_qualification_1' => $this->db->escape_like_str($edu_1),
                'educational_qualification_2' => $this->db->escape_like_str($edu_2),
                'educational_qualification_3' => $this->db->escape_like_str($edu_3),
                'educational_qualification_4' => $this->db->escape_like_str($edu_4),
                'educational_qualification_5' => $this->db->escape_like_str($edu_5),
//                'users_photo' => $this->db->escape_like_str($uploadFileInfo['file_name']),
                'cv' => $this->db->escape_like_str($this->input->post('cv', TRUE)),
                'educational_certificat' => $this->db->escape_like_str($this->input->post('educational_certificat', TRUE)),
                'exprieance_certificatte' => $this->db->escape_like_str($this->input->post('exc', TRUE)),
                'files_info' => $this->db->escape_like_str($this->input->post('submited_info', TRUE)),
                'phone' => $this->db->escape_like_str($phone)
            );
            $this->db->where('id', $userInfoId);
            $this->db->update('userinfo', $additional_data2);
            redirect('users/allUserInafo', 'refresh');
        } else {
            //get all data about this section_leader from the "user" table
            $data['userInfo'] = $this->common->getWhere('users', 'id', $userId);
            $data['section_leaderInfo'] = $this->common->getWhere('userinfo', 'id', $userInfoId);

            //get all groupe information and current group information to view file by "$data" array.
            $data['groups'] = $this->ion_auth->groups()->result_array();
            $data['currentGroups'] = $this->ion_auth->get_users_groups($userId)->result();

            $this->load->view('temp/header');
            $this->load->view('editUserInfo', $data);
            $this->load->view('temp/footer');
        }
    }

    //This function is useing for delete a user.
    public function section_leaderDelete() {
        $userId = $this->input->get('uid');
        $userInfoId = $this->input->get('id');

        $this->db->delete('userinfo', array('id' => $userInfoId));
        $this->db->delete('users', array('id' => $userId));

        redirect('users/allUserInafo', 'refresh');
    }

    function test() {
        $a = $this->common->usersId();
        echo '<pre>';
        echo $a;
        echo '</pre>';
    }

}
