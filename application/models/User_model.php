<?php

class User_model extends CI_Model {

    //check for the login user
    function login_user($table_name,$data){
        $this->db->select('*');
        $this->db->from($table_name);
        $result = $this->db->Where($data);
        return $result;
    }

    //inserting User into the table
    function insert_user($table_name,$data){
        $result = $this->db->insert($table_name,$data);
    }

    //getting perticular user ID
    public function get_ID($table_name,$data)
    {
        // $this->db->select('*');
        // $this->db->from($table_name);
        
        //$this->db->get($table_name);
        $query =  $this->db->get_where($table_name,$data);

        foreach ($query->result() as $row)
        {
            return $row->id;
        }
    }

    //for reset password
    public function reset_password($table_name,$data,$new_password){
        $this->db->set('password', $new_password);
        $this->db->where($data);
        return $this->db->update($table_name);
    }


}