<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Message extends MX_Controller {
    /**
     * This controller is using for controlling message 
     *
     * Maps to the following URL
     * 		http://rehearsalple.com/index.php/message
     * 	- or -  
     * 		http://rehearsalple.com/index.php/message/<method_name>
     */
    function __construct() {
        parent::__construct();
        $this->lang->load('auth');
        $this->load->model('messagemodel');
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login');
        }
    }
    //This function can send message.
    public function sendMessage() {
        if ($this->input->post('submit', TRUE)) {
            $receiver = $this->input->post('receiver', TRUE);
            $group = $this->input->post('receiverGroup', TRUE);
            $day = date("m/d/Y h:i:s A");
            $date = strtotime($day);
            if ($group == 'Choir_member') {
                //if this message's receipent will Choir_members then work here
                if ($receiver == 'AllChoir_memberSchool') {
                    $query = $this->common->getAllData('Choir_member_info');
                    foreach ($query as $row) {
                        $message = array(
                            'sender_id' => $this->db->escape_like_str($this->input->post('senderId', TRUE)),
                            'receiver_id' => $this->db->escape_like_str($row['user_id']),
                            'subject' => $this->db->escape_like_str($this->input->post('subject', TRUE)),
                            'message' => $this->db->escape_like_str($this->input->post('message', TRUE)),
                            'read_unread' => $this->db->escape_like_str('0'),
                            'date' => $this->db->escape_like_str($date),
                            'sender_delete' => 1,
                            'receiver_delete' => 1
                        );
                        $this->db->insert('message', $message);
                    }
                    $data['message'] = lang('mesc_1');
                    $this->load->view('temp/header');
                    $this->load->view('message', $data);
                    $this->load->view('temp/footer');
                } else {
                    $receiver_2 = $this->input->post('receiver_2', TRUE);
                    if ($receiver_2 == 'AllChoir_membersChoir') {
                        $query = $this->common->getWhere('Choir_member_info', 'Choir_title', $receiver);
                        foreach ($query as $row) {
                            $message = array(
                                'sender_id' => $this->db->escape_like_str($this->input->post('senderId', TRUE)),
                                'receiver_id' => $this->db->escape_like_str($row['user_id']),
                                'subject' => $this->db->escape_like_str($this->input->post('subject', TRUE)),
                                'message' => $this->db->escape_like_str($this->input->post('message', TRUE)),
                                'read_unread' => $this->db->escape_like_str('0'),
                                'date' => $this->db->escape_like_str($date),
                                'sender_delete' => 1,
                                'receiver_delete' => 1
                            );
                            $this->db->insert('message', $message);
                        }
                        $data['message'] = lang('mesc_1');
                        $this->load->view('temp/header');
                        $this->load->view('message', $data);
                        $this->load->view('temp/footer');
                    } else {
                        $message = array(
                            'sender_id' => $this->db->escape_like_str($this->input->post('senderId', TRUE)),
                            'receiver_id' => $this->db->escape_like_str($receiver_2),
                            'subject' => $this->db->escape_like_str($this->input->post('subject', TRUE)),
                            'message' => $this->db->escape_like_str($this->input->post('message', TRUE)),
                            'read_unread' => $this->db->escape_like_str('0'),
                            'date' => $this->db->escape_like_str($date),
                            'sender_delete' => 1,
                            'receiver_delete' => 1
                        );
                        if ($this->db->insert('message', $message)) {
                            $data['message'] = lang('mesc_1');
                            $this->load->view('temp/header');
                            $this->load->view('message', $data);
                            $this->load->view('temp/footer');
                        }
                    }
                }
            } elseif ($group == 'Section_leader') {
                //if this message's receipent will Section_leader then work here
                if ($receiver == 'AllSection_leader') {
                    $query = $this->common->getAllData('section_leaders_info');
                    foreach ($query as $row) {
                        $message = array(
                            'sender_id' => $this->db->escape_like_str($this->input->post('senderId', TRUE)),
                            'receiver_id' => $this->db->escape_like_str($row['user_id']),
                            'subject' => $this->db->escape_like_str($this->input->post('subject', TRUE)),
                            'message' => $this->db->escape_like_str($this->input->post('message', TRUE)),
                            'read_unread' => $this->db->escape_like_str('0'),
                            'date' => $this->db->escape_like_str($date),
                            'sender_delete' => 1,
                            'receiver_delete' => 1
                        );
                        $this->db->insert('message', $message);
                    }
                    $data['message'] = lang('mesc_1');
                    $this->load->view('temp/header');
                    $this->load->view('message', $data);
                    $this->load->view('temp/footer');
                } else {
                    $message = array(
                        'sender_id' => $this->db->escape_like_str($this->input->post('senderId', TRUE)),
                        'receiver_id' => $this->db->escape_like_str($receiver),
                        'subject' => $this->db->escape_like_str($this->input->post('subject', TRUE)),
                        'message' => $this->db->escape_like_str($this->input->post('message', TRUE)),
                        'read_unread' => $this->db->escape_like_str('0'),
                        'date' => $this->db->escape_like_str($date),
                        'sender_delete' => 1,
                        'receiver_delete' => 1
                    );
                    if ($this->db->insert('message', $message)) {
                        $data['message'] = lang('mesc_1');
                        $this->load->view('temp/header');
                        $this->load->view('message', $data);
                        $this->load->view('temp/footer');
                    }
                }
            } elseif ($group == 'Section_trainers') {
                //if this message's receipent will Section_trainers then work here
                if ($receiver == 'AllSection_trainersSchool') {
                    $query = $this->common->getAllData('section_trainers_info');
                    foreach ($query as $row) {
                        $message = array(
                            'sender_id' => $this->db->escape_like_str($this->input->post('senderId', TRUE)),
                            'receiver_id' => $this->db->escape_like_str($row['user_id']),
                            'subject' => $this->db->escape_like_str($this->input->post('subject', TRUE)),
                            'message' => $this->db->escape_like_str($this->input->post('message', TRUE)),
                            'read_unread' => $this->db->escape_like_str('0'),
                            'date' => $this->db->escape_like_str($date),
                            'sender_delete' => 1,
                            'receiver_delete' => 1
                        );
                        $this->db->insert('message', $message);
                    }
                    $data['message'] = lang('mesc_1');
                    $this->load->view('temp/header');
                    $this->load->view('message', $data);
                    $this->load->view('temp/footer');
                } else {
                    $receiver_2 = $this->input->post('receiver_2', TRUE);
                    if ($receiver_2 == 'AllSection_trainersChoir') {
                        $query = $this->common->getWhere('section_trainers_info', 'Choir_member_Choir', $receiver);
                        foreach ($query as $row) {
                            $message = array(
                                'sender_id' => $this->db->escape_like_str($this->input->post('senderId', TRUE)),
                                'receiver_id' => $this->db->escape_like_str($row['user_id']),
                                'subject' => $this->db->escape_like_str($this->input->post('subject', TRUE)),
                                'message' => $this->db->escape_like_str($this->input->post('message', TRUE)),
                                'read_unread' => $this->db->escape_like_str('0'),
                                'date' => $this->db->escape_like_str($date),
                                'sender_delete' => 1,
                                'receiver_delete' => 1
                            );
                            $this->db->insert('message', $message);
                        }
                        $data['message'] = lang('mesc_1');
                        $this->load->view('temp/header');
                        $this->load->view('message', $data);
                        $this->load->view('temp/footer');
                    } else {
                        $message = array(
                            'sender_id' => $this->db->escape_like_str($this->input->post('senderId', TRUE)),
                            'receiver_id' => $this->db->escape_like_str($receiver_2),
                            'subject' => $this->db->escape_like_str($this->input->post('subject', TRUE)),
                            'message' => $this->db->escape_like_str($this->input->post('message', TRUE)),
                            'read_unread' => $this->db->escape_like_str('0'),
                            'date' => $this->db->escape_like_str($date),
                            'sender_delete' => 1,
                            'receiver_delete' => 1
                        );
                        if ($this->db->insert('message', $message)) {
                            $data['message'] = lang('mesc_1');
                            $this->load->view('temp/header');
                            $this->load->view('message', $data);
                            $this->load->view('temp/footer');
                        }
                    }
                }
            }
        } else {
            $data['message'] = lang('mesc_1');
            $this->load->view('temp/header');
            $this->load->view('message', $data);
            $this->load->view('temp/footer');
        }
    }

    //This function can send message.
    public function sendMessage2() {
        $group = $this->input->post('receiverGroup', TRUE);
        $receiver = $this->input->post('receiver', TRUE);
        $receiver2 = $this->input->post('receiver_2', TRUE);
        $day = date("m/d/y h:i:s A");
        $date = strtotime($day);
        if ($this->input->post('submit', TRUE)) {
            if ($this->input->post('msgType') == 'smsapi') {
                $query = $this->db->query('SELECT msg_apai_email,msg_hash_number,msg_sender_title FROM configuration')->row();

                // Textlocal account details
                $username = $query->msg_apai_email;
                $hash = $query->msg_hash_number;

                // Message details
                $numbers = $this->messagemodel->Choir_memberNumber($group, $receiver, $receiver2);
                $sender = urlencode($query->msg_sender_title);
                $message = rawurlencode($query->msg_sender_title);

                $numbers = implode(',', $numbers);

                // Prepare data for POST request
                $data = array('username' => $username, 'hash' => $hash, 'numbers' => $numbers, "sender" => $sender, "message" => $message);

                // Send the POST request with cURL
                $ch = curl_init('http://api.txtlocal.com/send/');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);

                // Process your response here
                $json = json_decode($response);

                if ($json->status == 'success') {
                    $data['Success'] = lang('mesc_1');
                } else {
                    $data['Error'] = lang('mesc_2');
                }
                $this->load->view('temp/header');
                $this->load->view('message', $data);
                $this->load->view('temp/footer');
            } else {
                if ($group == 'Choir_member') {
                    //if this message's receipent will Choir_members then work here
                    if ($receiver == 'AllChoir_memberSchool') {
                        $query = $this->common->getAllData('Choir_member_info');
                        foreach ($query as $row) {
                            $message = array(
                                'sender_id' => $this->db->escape_like_str($this->input->post('senderId', TRUE)),
                                'receiver_id' => $this->db->escape_like_str($row['user_id']),
                                'subject' => $this->db->escape_like_str($this->input->post('subject', TRUE)),
                                'message' => $this->db->escape_like_str($this->input->post('message', TRUE)),
                                'read_unread' => $this->db->escape_like_str('0'),
                                'date' => $this->db->escape_like_str($date),
                                'sender_delete' => 1,
                                'receiver_delete' => 0
                            );
                            $this->db->insert('message', $message);
                        }
                        $data['message'] = lang('mesc_1');
                        $this->load->view('temp/header');
                        $this->load->view('message', $data);
                        $this->load->view('temp/footer');
                    } else {
                        $receiver_2 = $this->input->post('receiver_2', TRUE);
                        if ($receiver_2 == 'AllChoir_membersChoir') {
                            $query = $this->common->getWhere('Choir_member_info', 'Choir_id', $receiver);
                            foreach ($query as $row) {
                                $message = array(
                                    'sender_id' => $this->db->escape_like_str($this->input->post('senderId', TRUE)),
                                    'receiver_id' => $this->db->escape_like_str($row['user_id']),
                                    'subject' => $this->db->escape_like_str($this->input->post('subject', TRUE)),
                                    'message' => $this->db->escape_like_str($this->input->post('message', TRUE)),
                                    'read_unread' => $this->db->escape_like_str('0'),
                                    'date' => $this->db->escape_like_str($date),
                                    'sender_delete' => 1,
                                    'receiver_delete' => 0
                                );
                                $this->db->insert('message', $message);
                            }
                            $data['message'] = lang('mesc_1');
                            $this->load->view('temp/header');
                            $this->load->view('message', $data);
                            $this->load->view('temp/footer');
                        } else {
                            // Assuming receiver_2 is some form of identifier that needs to be converted to user_id
                            $user_info = $this->db->select('user_id')
                                                  ->where('Choir_member_id', $receiver_2)
                                                  ->get('Choir_member_info')
                                                  ->row();
                        
                            // Check if user_info was successfully retrieved and has user_id
                            if ($user_info && !empty($user_info->user_id)) {
                                $message = array(
                                    'sender_id' => $this->db->escape_like_str($this->input->post('senderId', TRUE)),
                                    'receiver_id' => $this->db->escape_like_str($user_info->user_id),  // Use the fetched user_id
                                    'subject' => $this->db->escape_like_str($this->input->post('subject', TRUE)),
                                    'message' => $this->db->escape_like_str($this->input->post('message', TRUE)),
                                    'read_unread' => $this->db->escape_like_str('0'),
                                    'date' => $this->db->escape_like_str($date),
                                    'sender_delete' => 1,
                                    'receiver_delete' => 1
                                );
                              
                                if ($this->db->insert('message', $message)) {
                                    $data['message'] = lang('mesc_1');
                                    $this->load->view('temp/header');
                                    $this->load->view('message', $data);
                                    $this->load->view('temp/footer');
                                }
                            } else {
                                // Handle the case where no valid user_id could be found
                                log_message('error', 'Invalid choir member ID or no corresponding user ID found: ' . $receiver_2);
                            }
                        }
                        
                    }
                } elseif ($group == 'Section_leader') {
                    //if this message's receipent will Section_leader then work here
                    if ($receiver == 'AllSection_leader') {
                        $query = $this->common->getAllData('section_leaders_info');
                        foreach ($query as $row) {
                            $message = array(
                                'sender_id' => $this->db->escape_like_str($this->input->post('senderId', TRUE)),
                                'receiver_id' => $this->db->escape_like_str($row['user_id']),
                                'subject' => $this->db->escape_like_str($this->input->post('subject', TRUE)),
                                'message' => $this->db->escape_like_str($this->input->post('message', TRUE)),
                                'read_unread' => $this->db->escape_like_str('0'),
                                'date' => $this->db->escape_like_str($date),
                                'sender_delete' => 1,
                                'receiver_delete' => 1
                            );
                            $this->db->insert('message', $message);
                        }
                        $data['message'] = lang('mesc_1');
                        $this->load->view('temp/header');
                        $this->load->view('message', $data);
                        $this->load->view('temp/footer');
                    } else {
                        $message = array(
                            'sender_id' => $this->db->escape_like_str($this->input->post('senderId', TRUE)),
                            'receiver_id' => $this->db->escape_like_str($receiver),
                            'subject' => $this->db->escape_like_str($this->input->post('subject', TRUE)),
                            'message' => $this->db->escape_like_str($this->input->post('message', TRUE)),
                            'read_unread' => $this->db->escape_like_str('0'),
                            'date' => $this->db->escape_like_str($date),
                            'sender_delete' => 1,
                            'receiver_delete' => 1
                        );
                        if ($this->db->insert('message', $message)) {
                            $data['message'] = lang('mesc_1');
                            $this->load->view('temp/header');
                            $this->load->view('message', $data);
                            $this->load->view('temp/footer');
                        }
                    }
                } elseif ($group == 'Section_trainers') {
                    //if this message's receipent will Section_trainers then work here
                    if ($receiver == 'AllSection_trainersSchool') {
                        $query = $this->common->getAllData('section_trainers_info');
                        foreach ($query as $row) {
                            $message = array(
                                'sender_id' => $this->db->escape_like_str($this->input->post('senderId', TRUE)),
                                'receiver_id' => $this->db->escape_like_str($row['user_id']),
                                'subject' => $this->db->escape_like_str($this->input->post('subject', TRUE)),
                                'message' => $this->db->escape_like_str($this->input->post('message', TRUE)),
                                'read_unread' => $this->db->escape_like_str('0'),
                                'date' => $this->db->escape_like_str($date),
                                'sender_delete' => 1,
                                'receiver_delete' => 1
                            );
                            $this->db->insert('message', $message);
                        }
                       
                    } else {
                        $receiver_2 = $this->input->post('receiver_2', TRUE);
                        if ($receiver_2 == 'AllSection_trainersChoir') {
                            $query = $this->common->getWhere('section_trainers_info', 'Choir_member_Choir', $receiver);
                            foreach ($query as $row) {
                                $message = array(
                                    'sender_id' => $this->db->escape_like_str($this->input->post('senderId', TRUE)),
                                    'receiver_id' => $this->db->escape_like_str($row['user_id']),
                                    'subject' => $this->db->escape_like_str($this->input->post('subject', TRUE)),
                                    'message' => $this->db->escape_like_str($this->input->post('message', TRUE)),
                                    'read_unread' => $this->db->escape_like_str('0'),
                                    'date' => $this->db->escape_like_str($date),
                                    'sender_delete' => 1,
                                    'receiver_delete' => 1
                                );
                                $this->db->insert('message', $message);
                            }
                            $data['message'] = lang('mesc_1');
                            $this->load->view('temp/header');
                            $this->load->view('message', $data);
                            $this->load->view('temp/footer');
                        } else {
                            $message = array(
                                'sender_id' => $this->db->escape_like_str($this->input->post('senderId', TRUE)),
                                'receiver_id' => $this->db->escape_like_str($receiver_2),
                                'subject' => $this->db->escape_like_str($this->input->post('subject', TRUE)),
                                'message' => $this->db->escape_like_str($this->input->post('message', TRUE)),
                                'read_unread' => $this->db->escape_like_str('0'),
                                'date' => $this->db->escape_like_str($date),
                                'sender_delete' => 1,
                                'receiver_delete' => 1
                            );
                            if ($this->db->insert('message', $message)) {
                                $data['message'] = lang('mesc_1');
                                $this->load->view('temp/header');
                                $this->load->view('message', $data);
                                $this->load->view('temp/footer');
                            }
                        }
                    }
                }
            }
        } else {
            //If the message is not set oe not submit it will load at first view for sending message
            $data['message'] = lang('mesc_1');
            $this->load->view('temp/header');
            $this->load->view('message', $data);
            $this->load->view('temp/footer');
        }
    }

    //This function will return all receiver whene give/select any user group.
    public function ajaxSelectReciver() {
        $group = $this->input->get('q');
        if ($group == 'Choir_member') {
            //If the Choir_member's groun was selected thene work here
            $query = $this->common->getAllData('Choir');
            echo '<option value="AllChoir_memberSchool">' . lang('mesc_3') . '</option>';
            foreach ($query as $row) {
                echo '<option value="' . $row['id'] . '">' . $row['Choir_title'] . ' </option>';
            }
        } elseif ($group == 'Section_leader') {
            //If the section_leader's groun was selected thene work here
            $query = $this->common->getAllData('section_leaders_info');
            echo '<option value="AllSection_leader">' . lang('mesc_4') . '</option>';
            foreach ($query as $row) {
                echo '<option value="' . $row['user_id'] . '">' . $row['fullname'] . '</option>';
            }
        } elseif ($group == 'Section_trainers') {
            //If the section_trainer's groun was selected thene work here
            $query = $this->common->getAllData('Choir');
            echo '<option value="AllSection_trainersSchool">' . lang('mesc_5') . '</option>';
            foreach ($query as $row) {
                echo '<option value="' . $row['id'] . '">' . $row['Choir_title'] . '</option>';
            }
        }
    }

    //This function will return all receiver whene give/select any user group.
    public function ajaxChoirStuAndPar() {
        $group = $this->input->get('g');
        $recInfo = $this->input->get('p');
        if ($group == 'Choir_member') {
            //If the Choir_member's groun was selected thene work here
            $query = $this->common->getWhere('Choir_member_info', 'Choir_id', $recInfo);
            echo '<option value="AllChoir_membersChoir">' . lang('mesc_6') . ' </option>';
            foreach ($query as $row) {
                echo '<option value="' . $row['Choir_member_id'] . '">' . $row['Choir_member_id'] . ' - ' . $row['Choir_member_nam'] . ' </option>';
            }
        } elseif ($group == 'Section_trainers') {
            $query = $this->common->getWhere('section_trainers_info', 'Choir_id', $recInfo);
            echo '<option value="AllSection_trainersChoir">' . lang('mesc_7') . ' </option>';
            foreach ($query as $row) {
                echo '<option value="' . $row['user_id'] . '">' . $row['section_trainers_name'] . ' - Choir_memberID : ' . $row['Choir_member_id'] . ' </option>';
            }
        }
    }

    //This function will return all inbox read and unread message
    public function inbox() {
        error_log('Checking inbox for user: ');
        $user = $this->ion_auth->user()->row();
        $id = $user->id;
        error_log('Checking inbox for user: ' . $id);
        $data['message'] = $this->common->getWhere22('message', 'receiver_id', $id, 'receiver_delete', 1);
        error_log('Inbox messages: ' . var_export($data['message'], true));
    
        
        $this->load->view('temp/header');
        $this->load->view('inbox', $data);
        $this->load->view('temp/footer');
    }
    
    

    //This function will return all inbox read and unread message
    public function sentMessage() {
        $user = $this->ion_auth->user()->row();
        $id = $user->id;
        $data['message'] = $this->common->getWhere22('message', 'sender_id', $id, 'sender_delete', 1);
        $this->load->view('temp/header');
        $this->load->view('sent', $data);
        $this->load->view('temp/footer');
    }

    //This function can return unread message in the inbox. 
    public function unreadMessage() {
        $user = $this->ion_auth->user()->row();
        $id = $user->id;
        $data['unreadMessage'] = $this->messagemodel->unReadMessage($id);
    }

    //user can read the message by this function
    public function readMessage() {
        $id = $this->input->get('id');
        $data['message'] = $this->common->getWhere('message', 'id', $id);
        $update = array(
            'read_unread' => $this->db->escape_like_str(1)
        );
        if ($this->db->update('message', $update, array('id' => $this->db->escape_like_str($id)))) {
            $this->load->view('temp/header');
            $this->load->view('readmessage', $data);
            $this->load->view('temp/footer');
        }
    }

    //This function can check at first thet is the sender want to delete it.
    //If the sender delete the message befor the receiver delte then this function can delete this message from databae.
    //Or remove this message only from the inbox item.
    public function deleteInboxMessage() {
        $id = $this->input->get('id');
        $query = $this->common->getWhere('message', 'id', $id);
        foreach ($query as $row) {
            $senderDelete = $row['sender_delete'];
        }
        if ($senderDelete == '0') {
            if ($this->db->delete('message', array('id' => $id))) {
                redirect('message/inbox', 'refresh');
            }
        } else {
            $this->db->where('id', $id);
            $data = array('receiver_delete' => 0);
            if ($this->db->update('message', $data)) {
                redirect('message/inbox', 'refresh');
            }
        }
    }

    //This function can check at first thet is the receiver want to delete it.
    //If the receiver delete the message befor the sender delte then this function can delete this message from databae.
    //Or remove this message only from the sent message item.
    public function deleteSentMessage() {
        $id = $this->input->get('id');
        $query = $this->common->getWhere('message', 'id', $id);
        foreach ($query as $row) {
            $receiverDelete = $row['receiver_delete'];
        }
        if ($receiverDelete == '0') {
            if ($this->db->delete('message', array('id' => $id))) {
                redirect('message/inbox', 'refresh');
            }
        } else {
            $this->db->where('id', $id);
            $data = array('sender_delete' => 0);
            if ($this->db->update('message', $data)) {
                redirect('message/sentMessage', 'refresh');
            }
        }
    }

}
