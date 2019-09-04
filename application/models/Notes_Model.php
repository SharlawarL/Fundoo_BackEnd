<?php

class Notes_Model extends CI_Model {

    function insertNote($NotesData)
    {
        //inserting Notes into database
        $result = $this->db->insert('Notes',$NotesData);
    }

    function get_Notes(){
        // retriving notes
        $Notes = $this->db->get('Notes');
        // returning in the formate of array
        return $Notes->result_array();
    }

}