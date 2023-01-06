<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }





	public function index()
	{


		if(!$this->session->userdata('is_logged_in'))
        {
            $this->load->view('frontend/inc/header_view');
            $this->load->view('frontend/register_view');
            $this->load->view('frontend/inc/footer_view');
        }
        else
        {
            redirect(base_url('home'));
        }

	}

    public function registerUser()
    {
       if(! $this->session->userdata('is_logged_in'))
       {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('uname', 'Username', 'required|min_length[4]|max_length[16]');
            $this->form_validation->set_rules('uemail', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('pwd', 'Password', 'required|min_length[8]');
            $this->form_validation->set_rules('confpwd', 'Password confirmation', 'required|matches[pwd]');

            if($this->form_validation->run())
            {

                $insertData = 
                [
                    'user_name'       => $this->input->post('uname'),
                    'user_email'      => $this->input->post('uemail'),
                    'user_pass'       => password_hash($this->input->post('pwd'), PASSWORD_DEFAULT),
                    'user_photo'      => $this->input->post('defaultPfp'),
                    'user_created_at' => date('M d, Y H:i A')
                ];

                // Insert User to the database
                if($this->user_model->insertUser($insertData))
                {
                    // Display success message
                    $response = 
                    [
                        'success'    => true, 
                        'successMsg' => 'You have been successfully registered'
                    ];
                
                }

            }
            else
            {
                $response = [
                    "error" => true, 
                    'uname_error'   => form_error('uname'),
                    'uemail_error'  => form_error('uemail'),
                    'pwd_error'     => form_error('pwd'),
                    'confpwd_error' => form_error('confpwd')
                ];
            }


            echo json_encode($response);
       }
       else
       {
        redirect(base_url('home'));
       }


    }
}
