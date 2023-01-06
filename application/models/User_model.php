<?php 

defined('BASEPATH') OR exit('No direct script access allowed');


class User_model extends CI_Model
{
    public function insertUser($data)
    
    {
        if($this->db->insert('users', $data))
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    public function userExist($uname, $pwd)
    {
       
        return $this->db->get_where('users', ['user_name' => $uname])->row();
    }

}