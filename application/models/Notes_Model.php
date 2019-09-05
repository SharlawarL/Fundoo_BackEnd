<?php

class Notes_Model extends CI_Model {

    //for inserting data
    function insertNote($NotesData)
    {
        $result = $this->db->insert('Notes',$NotesData);
    }

    function get_Notes(){
        $Notes = $this->db->get('Notes');
        return $Notes->result_array();
    }

}