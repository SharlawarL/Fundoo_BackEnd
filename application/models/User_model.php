<?php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

/** @Entity **/
class User_model extends CI_Model {

    //check for the login user
    function login_user($table_name,$User_data){

        $query =  $this->db->get_where($table_name,$User_data);
        foreach ($query->result() as $row)
        {
            return $row;
        }
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
        $query =  $this->db->get_where($table_name,$data);

        foreach ($query->result() as $row)
        {
            return $row->id;
        }
    }

    //check user
    public function check_user($table_name,$User_data)
    {
        $email = $User_data['email'];
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

    // get user details
    function get_user_details($id){
        $this->db->where('id',$id);
        $Notes = $this->db->get('user');
        return $Notes->result_array();
    }

    // get user details
    function total_user(){
        $Notes = $this->db->get('user');
        return $Notes->result_array();
    }

    // update photo
    public function update_photo($table_name,$id,$img_url)
    {
        $this->db->set('photo', $img_url);
        $this->db->where('id',$id);
        return $this->db->update($table_name);   
    }

    //updating Firebase token
    public function update_firebase_token($user_id,$firebase_token)
    {
        $this->db->set('Firebase_token', $firebase_token);
        $this->db->where('id',$user_id);
        $this->db->update('user');
    }
}