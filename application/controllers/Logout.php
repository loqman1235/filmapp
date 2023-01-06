<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {
    public function index() {
        
        if($this->session->userdata('userName')) {
            $user_data = $this->session->all_userdata();
            foreach ($user_data as $key => $value) {
                if ($key != 'userId' && $key != 'userName' && $key != 'userEmail' && $key != 'userPic') {
                    $this->session->unset_userdata($key);
                }
            }

            $this->session->sess_destroy();
            redirect(base_url('home'));
        } 
        else
        {
            redirect(base_url('home'));
        }
    }
}