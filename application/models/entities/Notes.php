<?php
// src/Notes.php

use Doctrine\ORM\Mapping as ORM;
/**
 * Notes
 * @ORM\Entity
 * @ORM\Table(name="Notes")
 * @ORM\HasLifecycleCallbacks
 */
class Notes
{
    /** 
     * @ORM\Note_Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $note_id;
    /** 
     * @ORM\User_Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $user_id;
    /** 
     * @ORM\title
     * @ORM\Column(type="varchar") 
     */
    protected $title;
    /** 
     * @ORM\Notes
     * @ORM\Column(type="varchar") 
     */
    protected $Notes;
    /** 
     * @ORM\reminder
     * @ORM\Column(type="varchar") 
     */
    protected $reminder;
    /** 
     * @ORM\index_no
     * @ORM\Column(type="integer") 
     */
    protected $index_no;
    /** 
     * @ORM\is_trash
     * @ORM\Column(type="integer") 
     */
    protected $is_trash;
    /** 
     * @ORM\is_archive
     * @ORM\Column(type="integer") 
     */
    protected $is_archive;
    /** 
     * @ORM\Color
     * @ORM\Column(type="varchar") 
     */
    protected $color;

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
     * @param string $trash
     */
    public function setTrash($trash)
    {
        $this->trash = $trash;
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
    public function setArchive($archive)
    {
        $this->archive = $archive;
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