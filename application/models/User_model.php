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

    //verify mail
    function update_mail_status($table_name,$User_id){
        $this->db->set('email_verify', '1');
        $this->db->where('id', $User_id);
        $result = $this->db->update($table_name); 
        return $result;
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

    //check user
    public function check_user($table_name,$User_data)
    {
        // $this->db->select('*');
        // $this->db->where($User_email);
        // $this->db->from($table_name);
        //$this->db->get($table_name);
        $email = $User_data['email'];
        //print_r($User_data);
        //$email = $User_email['firstname'];
        //$query =  $this->db->get_where($table_name,$email);
        $query = $this->db->query("select * from ".$table_name." where `email`='".$email."'");
        
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