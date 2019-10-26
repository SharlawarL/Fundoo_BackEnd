<?php
// src/Notes.php

use Doctrine\ORM\Mapping as ORM;
/**
 * Notes
 * @ORM\Entity
 * @ORM\Table(name="Notes")
 */
class Notes
{
    /** 
     * @ORM\Id
     * @ORM\Column(name = "note_id", type="integer")
     * @ORM\GeneratedValue
     */
    protected $note_id;
    /**
     * @ORM\Column(name = "user_id",type="integer")
     * @ORM\GeneratedValue
     */
    protected $user_id;
    /** 
     * @ORM\Column(name = "title") 
     */
    protected $title;
    /** 
     * @ORM\Column(name = "Notes") 
     */
    protected $Notes;
    /** 
     * @ORM\Column(name = "reminder") 
     */
    protected $reminder;
    /** 
     * @ORM\Column(name = "index_no",type="integer") 
     */
    protected $index_no;
    /** 
     * @ORM\Column(name = "is_trash",type="integer") 
     */
    protected $is_trash;
    /** 
     * @ORM\Column(name = "is_archive",type="integer") 
     */
    protected $is_archive;
    /** 
     * @ORM\Column(name = "color") 
     */
    protected $color;

     /**
     * Set user_id
     *
     * @param string $user_id
     */
    public function setNoteId($note_id)
    {
        $this->note_id = $note_id;
    }
     /**
     * Get Note id
     *
     * @return integer $note_id
     */
    public function getNoteId()
    {
        return $this->note_id;
    }

     /**
     * Set user_id
     *
     * @param string $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

     /**
     * Get User id
     *
     * @return integer $user_id
     */
    public function getUserId()
    {
        return $this->user_id;
    }

     /**
     * Set title
     *
     * @param string $name
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

     /**
     * Get title
     *
     * @return integer $title
     */
    public function getTitle()
    {
        return $this->title;
    }

     /**
     * Set Notes
     *
     * @param string $Notes
     */
    public function setNotes($Notes)
    {
        $this->Notes = $Notes;
    }

     /**
     * Get Notes
     *
     * @return integer $Notes
     */
    public function getNotes()
    {
        return $this->Notes;
    }

     /**
     * Set reminder
     *
     * @param string $reminder
     */
    public function setReminder($reminder)
    {
        $this->reminder = $reminder;
    }

     /**
     * Get reminder
     *
     * @return integer $user_id
     */
    public function getReminder()
    {
        return $this->reminder;
    }

     /**
     * Set index_no
     *
     * @param string $index_no
     */
    public function setIndexNumber($index_no)
    {
        $this->index_no = $index_no;
    }

     /**
     * Get index_no
     *
     * @return integer $index_no
     */
    public function getIndexNumber()
    {
        return $this->index_no;
    }

     /**
     * Set trash
     *
     * @param integer $trash
     */
    public function setTrash($is_trash)
    {
        $this->is_trash = $is_trash;
    }

     /**
     * Get trash
     *
     * @return integer $trash
     */
    public function getTrash()
    {
        return $this->is_trash;
    }

     /**
     * Set Archive
     *
     * @param string $archive
     */
    public function setArchive($is_archive)
    {
        $this->is_archive = $is_archive;
    }

    /**
     * Get Archive
     *
     * @return integer $archive
     */
    public function getArchive()
    {
        return $this->is_archive;
    }

     /**
     * Set color
     *
     * @param string $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * Get Color
     *
     * @return integer $color
     */
    public function getColor()
    {
        return $this->color;
    }
}