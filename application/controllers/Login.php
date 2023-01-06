<?php 

defined('BASEPATH') OR exit('No direct script access allowed');


class Login extends CI_Controller {
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
            $this->load->view('frontend/login_view');
            $this->load->view('frontend/inc/footer_view');
        }
        else 
        {
            redirect(base_url('home'));
        }
        
    }

    public function loginUser() 
    {
      if(!$this->session->userdata('is_logged_in'))
        {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('uname', 'Username', 'required');
            $this->form_validation->set_rules('pwd', 'Password', 'required');
    
            if($this->form_validation->run())
            {
                $uname = $this->input->post('uname');
                $pwd   = $this->input->post('pwd');
    
                $user = $this->user_model->userExist($uname, $pwd);
    
    
                if(!$user)
                {
                    
                    $response = 
                    [
                        'error'       => true,
                        'login_error' => '<p style="padding-bottom: 20px;">Please check your email or password and try again.</p>'
                    ];
                }
    
                elseif(!password_verify($pwd, $user->user_pass))
                {
                    $response = 
                    [
                        'error'       => true,
                        'login_error' => '<p style="padding-bottom: 20px;">Please check your email or password and try again.</p>'
                    ];
                }
                else
                {
    
                    // Setting Session Data
                    $data = 
                    [
                        'is_logged_in' => TRUE,
                        'userId'       => $user->user_id,
                        'userName'     => $user->user_name,
                        'userEmail'    => $user->user_email,
                        'userPic'      => $user->user_photo
                    ];
    
                    $this->session->set_userdata($data);
    
                    $response = [
                        'success'    => true,
                        'successMsg' => 'Login Success',
                    ];
                }
    
            }
            else
            {
                $response = 
                [
                    'error'       => true,
                    'uname_error' => form_error('uname'),
                    'pwd_error'   => form_error('pwd')
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