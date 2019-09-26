<?php

class Notes_Model extends CI_Model {

    // ********** Performing notes operation ***************

    //for inserting data
    function insertNote($NotesData)
    {
        $result = $this->db->insert('Notes',$NotesData);
    }

    // for retriving the notes
    function get_Notes($id){
        $this->db->where('user_id',$id);
        $Notes = $this->db->get('Notes');
        return $Notes->result_array();
    }

    // for updating the notes
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

    // delete the nodes permently
    function delete_trash($note_id)
    {
        //they are joined tables so first delete form lebel notes
        $this->db->Where('note_id',$note_id);
        $this->db->delete('lebel_notes');
        //then delete the notes
        $this->db->where('note_id',$note_id);
        $result = $this->db->delete('Notes');
        return $result;
    }

    // notes added into trash
    function is_trash($note_id)
    {
        $data = array(
            'is_trash' => '1'
        );
        $this->db->where('note_id',$note_id);
        $result = $this->db->update('Notes',$data);
        return $result;
    }

    // restoring from trash
    function restore_trash($note_id)
    {
        $data = array(
            'is_trash' => '0'
        );
        $this->db->where('note_id',$note_id);
        $result = $this->db->update('Notes',$data);
        return $result;
    }   

    //for update the reminder
    function update_reminder($Note_data)
    {
        $data = array(
            'reminder' => $Note_data['rdate']
        );
        $this->db->where('note_id',$Note_data['note_id']);
        $result = $this->db->update('Notes',$data);
        return $result;
    }

    // update the color
    function update_color($Note_data)
    {
        $data = array(
            'color' => $Note_data['color']
        );
        $this->db->where('note_id',$Note_data['note_id']);
        $result = $this->db->update('Notes',$data);
        return $result;
    }
    
    // added to archive
    function is_archive($note_id)
    {
        $data = array(
            'is_archive' => '1'
        );
        $this->db->where('note_id',$note_id);
        $result = $this->db->update('Notes',$data);
        return $result;
    }

    // getting from archive
    function get_archive($note_id)
    {
        $data = array(
            'is_archive' => '0'
        );
        $this->db->where('note_id',$note_id);
        $result = $this->db->update('Notes',$data);
        return $result;
    }

    // ************ Adding Lebels to the Notes ******************

    //inserted the label
    function add_lebel($lebel_data)
    {
        $result = $this->db->insert('lebel',$lebel_data);
        return $result;
    }

    // retriving the lebel's
    function get_labels($id){
        $this->db->where('user_id',$id);
        $Notes = $this->db->get('lebel');
        return $Notes->result_array();
    }
    
    //added lebels to the notes
    function add_lebelnotes($lebel_data)
    {
        $result = $this->db->insert('lebel_notes',$lebel_data);
        return $result;
    }

    //retriving lebel notes
    function get_labelsnote($id){
        //selecting the coulumbs
        $this->db->select("lebel_notes.id,lebel_notes.note_id,lebel_notes.lebel_id,lebel.lebel_id,lebel.lebel");
        $this->db->from('lebel_notes');

        //join the lebel table
        $this->db->join('lebel','lebel_notes.lebel_id = lebel.lebel_id');
        $lebel = $this->db->get();

        // return the output
        return $lebel->result_array();
    }

    // removing lebels
    function remove_lebel($id)
    {
        $this->db->where('id', $id);
        $result = $this->db->delete('lebel_notes');
        return $result;
    }

    // delete lebels
    function delete_lebel($id)
    {
        //they are joined table first it delete from lebel notes
        $this->db->where('lebel_id',$id);
        $this->db->delete('lebel_notes');
        //then now we can delete the lebel
        $this->db->where('lebel_id', $id);
        $result = $this->db->delete('lebel');
        return $result;
    }

    //updateting lebel
    function update_lebel($lebel_data)
    {
        $data = array(
            'lebel' => $lebel_data['lebel']
        );
        $this->db->where('lebel_id',$lebel_data['lebel_id']);
        $result = $this->db->update('lebel',$data);
        return $result;
    }

}