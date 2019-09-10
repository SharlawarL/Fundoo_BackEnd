<?php

class Notes_Model extends CI_Model {

    //for inserting data
    function insertNote($NotesData)
    {
        $result = $this->db->insert('Notes',$NotesData);
    }

    function get_Notes($id){
        $this->db->where('user_id',$id);
        $Notes = $this->db->get('Notes');
        return $Notes->result_array();
    }

    function update($Notes_data)
    {
        $data = array(
            'title' => $Notes_data['title'],
            'Notes' => $Notes_data['Notes'],
            'reminder' => $Notes_data['reminder']
        );
        $id = $Notes_data['note_id'];
        $this->db->where('note_id',$id);
        $result = $this->db->update('Notes',$data);
        return $result;
    }

}